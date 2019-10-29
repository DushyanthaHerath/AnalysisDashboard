<?php

namespace App\Store\Controllers;

use App\Store\Traits\HttpResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, HttpResponse;

    /**
     * Send response
     *
     * @param array $data
     * @param string $message
     * @param int $statusCode
     * @param array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function response($data = null, $message = '', $statusCode = 200, $headers = []){

        return $this->sendResponse($data, $message, $statusCode, $headers);

    }
}
