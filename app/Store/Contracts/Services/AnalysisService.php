<?php


namespace App\Store\Contracts\Services;


interface AnalysisService
{
    public function getFilterInformation();

    public function subjectPlotData($param);

    public function subjectBoxData($param);

    public function marksData($param);
}
