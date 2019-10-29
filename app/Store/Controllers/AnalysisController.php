<?php

namespace App\Store\Controllers;

use App\Store\Contracts\Services\AnalysisService;
use Illuminate\Http\Request;

class AnalysisController extends Controller
{
    protected $analysisService;
    public function __construct(AnalysisService $analysisService)
    {
        $this->analysisService = $analysisService;
    }

    public function getFilterInformation() {
        return $this->response($this->analysisService->getFilterInformation());
    }

    public function subjectPlotData() {
        return $this->response($this->analysisService->subjectPlotData(request()->all()));
    }

    public function subjectBoxData() {
        return $this->response($this->analysisService->subjectBoxData(request()->all()));
    }

    public function marksData() {
        return $this->response($this->analysisService->marksData(request()->all()));
    }
}
