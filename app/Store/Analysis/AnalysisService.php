<?php


namespace App\Store\Analysis;
use \App\Store\Contracts\Services\AnalysisService as Analysis;
use App\Store\Contracts\Repository\Analysis as AnalysisRepository;


class AnalysisService implements Analysis
{
    protected $analysis;
    public function __construct(AnalysisRepository $analysis)
    {
        $this->analysis = $analysis;
    }

    public function getFilterInformation()
    {
        return $this->analysis->getFilterInformation();
    }

    public function subjectPlotData($param)
    {
        return $this->analysis->subjectPlotData($param);
    }

    public function subjectBoxData($param)
    {
        return $this->analysis->subjectBoxData($param);
    }

    public function marksData($param)
    {
        return $this->analysis->marksData($param);
    }
}
