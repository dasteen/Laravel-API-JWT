<?php

namespace App\Lib\Facades;

use Illuminate\Support\Facades\Response as BaseResponse;


class Response extends BaseResponse
{
    public static function sendJSON($data, $errorsList = [], $status = \Illuminate\Http\Response::HTTP_OK, $headers = [])
    {
        $errors = static::getErrors($errorsList);

        return BaseResponse::json(compact('status', 'data', 'errors'), $status, $headers);
    }

    public static function sendJSONEx($data, $errors = [], $status = \Illuminate\Http\Response::HTTP_OK, $headers = [])
    {
        return BaseResponse::json(compact('status', 'data', 'errors'), $status, $headers);
    }

    public static function sendError($errorsList = [], $status = \Illuminate\Http\Response::HTTP_BAD_REQUEST, $headers = [])
    {
        $data = [];

        $errors = static::getErrors($errorsList);

        return BaseResponse::json(compact('status', 'data', 'errors'), $status, $headers);
    }

    public static function getError($errorCode, $data = [])
    {
        $parts = explode('.', $errorCode);
        if (count($parts) == 3) {
            list($scope, , $code) = $parts;
        }
        else {
            list($scope, $code) = $parts;
        }

        return [
            'scope' => $scope,
            'code' => $code,
            'message' => trans($errorCode, $data),
        ];
    }

    private static function getErrors($errorsList)
    {
        $errors = [];

        if (!is_array($errorsList)) {
            $errorsListCopy['error'] = $errorsList;
            $errorsList = $errorsListCopy;
        }

        if (count($errorsList) && isset($errorsList[0])) {
            for ($i = 0; $i < count($errorsList); $i++) {
                $errors[] = static::getError(
                    $errorsList[$i]['error'],
                    isset($errorsList[$i]['data']) ? $errorsList[$i]['data'] : []
                );
            }
        }
        elseif (isset($errorsList['error'])) {
            $errors[] = static::getError(
                $errorsList['error'],
                isset($errorsList['data']) ? $errorsList['data'] : []
            );
        }

        return $errors;
    }
}