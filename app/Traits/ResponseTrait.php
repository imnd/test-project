<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ResponseTrait
{
    protected function responseUnauthorized($message = 'Unauthorized'): JsonResponse
    {
        return response()->json(compact('message'), Response::HTTP_UNAUTHORIZED);
    }

    protected function responseForbidden($message = 'Forbidden'): JsonResponse
    {
        return response()->json(compact('message'), Response::HTTP_FORBIDDEN);
    }

    protected function responseBadRequest($data = 'Bad request'): JsonResponse
    {
        if (!is_array($data)) {
            $data = [
                'message' => $data,
            ];
        }

        return response()->json($data, Response::HTTP_BAD_REQUEST);
    }

    protected function responseOk($contents = []): JsonResponse
    {
        if (is_string($contents)) {
            $contents = ['message' => $contents];
        }

        return response()->json($contents, Response::HTTP_OK);
    }

    protected function responseCreated($contents = []): JsonResponse
    {
        return response()->json($contents, Response::HTTP_CREATED);
    }

    protected function responseNoContent(): JsonResponse
    {
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
