<?php


namespace App\Traits;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ApiResponderTrait {

    /**
     * Send as json response on JSON API format
     * @param array $data
     * @param null $message
     * @param int $code
     * @return JsonResponse
     */
    protected function successResponse($data = [], $message = null, $code = Response::HTTP_OK): JsonResponse {
        return response()->json([
            'status' => 'Success',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    /**
     * Send as raw json response
     * @param array $data
     * @param int $code
     * @return JsonResponse
     */
    protected function rawJsonResponse($data = [], int $code = Response::HTTP_OK): JsonResponse {
        return response()->json($data, $code);
    }

    /**
     * Send as raw response
     * @param string $content
     * @param int $code
     * @param array $headers
     * @return Response
     * @throws BindingResolutionException
     */
    protected function rawResponse(string $content, int $code = Response::HTTP_OK, array $headers = []): Response {
        return response()->make($content, $code, $headers);
    }

    /**
     * Send as error response on JSON API format
     * @param string|null $message
     * @param int $code
     * @return JsonResponse
     */
    protected function errorResponse(string $message = null, int $code = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse {
        return response()->json([
            'status' => 'Error',
            'message' => $message,
            'data' => null
        ], $code);
    }

    /**
     * Send NO CONTENT response
     * @return Response
     */
    protected function noContent(): Response {
        return response()->noContent();
    }

}
