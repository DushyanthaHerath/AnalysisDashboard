<?php


namespace App\Store\Analysis;


use App\Store\Contracts\Repository\Analysis;
use App\Store\Models\Result;
use Illuminate\Support\Facades\DB;

class AnalysisRepository implements Analysis
{
    protected $result;
    public function __construct(Result $result)
    {
        $this->result = $result;
    }

    public function getFilterInformation()
    {
        return [
          'student_ids'=>$this->result::select('student_id')->groupBy('student_id')->orderBy('student_id')->get(),
          'years'=>$this->result::select('calender_year')->groupBy('calender_year')->orderBy('calender_year')->get(),
          'grades'=>$this->result::select('grade')->groupBy('grade')->orderBy('grade')->get(),
          'subjects'=>$this->result::select('subject')->groupBy('subject')->orderBy('subject')->get()
        ];
    }

    public function subjectPlotData($param)
    {
        $param = $this->fixParam($param);
        $subjects = $this->result::select('subject')->groupBy('subject')->orderBy('subject')->get();
        $data = [];
        $data['categories'] = [];
        $max = 0;
        foreach ($subjects as $subject) {
            array_push($data['categories'], $subject->subject);
            unset($param['subject']);
            $_data =  $this->result::select('mark')->where($param)->where('subject', $subject->subject)->orderBy('mark', 'asc')->get()->pluck('mark');
            /*$_bins = DB::select('select floor(mark/20)*20 as bin_floor, count(*) as row_counts from results group by 1 order by row_counts desc');
            $_plot = [];
            for($i=1;$i<count($_bins);$i++) {
                $_val = $this->result::whereBetween('mark',[$_bins[$i-1]->bin_floor, $_bins[$i-1]->bin_floor+20])->where('subject', $subject->subject)->avg('mark');
                $_plot[$i-1] = round($_val);
            }*/
            $data['series'][] = $_data->toArray();
            /*sort($_plot);
            $data['plot'][] = $_plot;*/
            $max = (count($_data)>$max) ? count($_data) : $max;
        }
        foreach ($data['series'] as &$series) {
            for($i=0; $i<$max; $i++) {
                $series[$i] = $series[$i] ?? 0;
            }
            sort($series);
        }
        return $data;
    }

    public function subjectBoxData($param)
    {
        $param = $this->fixParam($param);
        $subjects = $this->result::select('subject')->groupBy('subject')->orderBy('subject')->get();
        $data = [];
        $data['categories'] = [];
        $max = 0;
        foreach ($subjects as $subject) {
            array_push($data['categories'], $subject->subject);
            if(isset($param['subject'])) unset($param['subject']);
            $_dataMax =  $this->result->where($param)->where('subject', $subject->subject)->max('mark');
            $_dataAvg =  $this->result->where($param)->where('subject', $subject->subject)->avg('mark');
            $data['series'][0][] = round($_dataMax,2);
            $data['series'][1][] = round($_dataAvg,2);
        }
        return $data;
    }

    public function fixParam($params) {
        foreach ($params as $key=>$param) {
            if(empty($param))
                unset($params[$key]);
        }
        return $params;
    }

    public function marksData($param)
    {
        $param = $this->fixParam($param);
        $subjects = $this->result::select('subject')->groupBy('subject')->orderBy('subject')->get();
        $start = $this->result->min('calender_year');
        $end = $this->result->max('calender_year');

        $data = [];
        $data['categories'] = [];
        $data['series'] = [];

        for($i=$start;$i<$end;$i++) {
            array_push($data['categories'], $i.'-1');
            array_push($data['categories'], $i.'-2');
        }

        $max = 0;
        foreach ($data['categories'] as $k=>$semester) {
            foreach ($subjects as $subject) {

                $_dataMax = $this->result->where($param)
                    ->where('calender_year', explode('-', $semester)[0])
                    ->where('semester', explode('-', $semester)[1])
                    ->where('subject', $subject->subject)->max('mark');
                $data['series'][$subject->subject][] = round($_dataMax, 2);
            }
        }
        return $data;
    }
}
