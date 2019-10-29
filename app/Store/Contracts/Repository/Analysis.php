<?php


namespace App\Store\Contracts\Repository;


interface Analysis
{
    public function getFilterInformation();

    public function subjectPlotData($param);

    public function subjectBoxData($param);

    public function marksData($param);
}
