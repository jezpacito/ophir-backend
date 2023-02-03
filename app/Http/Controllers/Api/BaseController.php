<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use EllipseSynergie\ApiResponse\Contracts\Response;

class BaseController extends Controller
{
    /**
     * @param  \EllipseSynergie\ApiResponse\Contracts\Response  $response
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
    }
}
