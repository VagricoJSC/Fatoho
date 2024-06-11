<?php


namespace App\Http\Controllers;

use App\Traits\ApiResponseTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use phpDocumentor\Reflection\Types\Object_;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, ApiResponseTrait;

    /**
     * @param string $message
     * @param null $data
     * @param int $code
     * @param array $header
     * @return JsonResponse
     * To return success API template
     * Use in any controller by $this->hasSuccess
     */
    public function hasSuccess(string $message, $data = null, int $code = 200,array $header = []): JsonResponse
    {
        $responseData = [
            'success' => true,
            'message' => $message,
            'result' => $data,
            'status' => $code
        ];
        return $this->apiResponse($responseData,$code,$header);
    }

    /**
     * @param string $message
     * @param null $data
     * @param int $code
     * @param array $header
     * @return JsonResponse
     * To return success API template
     * Use in any controller by $this->hasSuccess
     */
    public function hasSuccessMobile($message, $data = '', $options = [],$result = true)
    {
        $response = [
            'result' => $result,
            'message' => $message,
            'data' => $data
        ];
        if (count($options)) {
            $response = array_merge($response, $options);
        }
        return response()->json($response,Response::HTTP_OK,[],JSON_UNESCAPED_UNICODE);
    }

    /**
     * @param string $message
     * @param $error
     * @param int $code
     * @param array $header
     * @return JsonResponse
     * To return error API template
     * Use in any controller by $this->hasError
     */
    public function hasError(string $message, $error, int $code = 422,array $header = []): \Illuminate\Http\JsonResponse
    {
        $responseData = [
            'success' => false,
            'message' => $message,
            'errors' => $error,
            'status' => $code
        ];
        return $this->apiResponse($responseData,$code,$header);
    }

    public function hasErrorMobile(string $message, $error,  int $code = 422,array $header = [])
    {
        $response = [
            'success' => false,
            'message' => $message,
            'errors' => $error,
            'status' => $code
        ];
        return response()->json($response,$code ?? Response::HTTP_OK,[],JSON_UNESCAPED_UNICODE);
    }
}
