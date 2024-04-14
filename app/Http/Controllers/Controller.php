<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Database\RecordsNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as RoutingController;
use Illuminate\Support\Facades\Log;

class Controller extends RoutingController
{
    public function callAction($method, $parameters)
    {
        try {
            return parent::callAction($method, $parameters);
        } catch (RecordsNotFoundException $e) {
            Log::error('Controller error', [$method, $parameters, $e]);

            $errorCode = Response::HTTP_UNPROCESSABLE_ENTITY;

            return Response(['error' => 'Register not found'], $errorCode);

        } catch (Exception $e) {
            dd($e);
            Log::error('Controller error', [$method, $parameters, $e]);

            $errorCode = Response::HTTP_INTERNAL_SERVER_ERROR;

            return Response(['error' => $errorCode], $errorCode);
        }
    }
}
