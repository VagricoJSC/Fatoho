<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Wishlist;
use App\Models\Cart;
use App\Models\Settings;
use App\Models\Order;
use Illuminate\Support\Str;
use Helper;
use App\Models\Tracker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class ViettelController extends Controller
{

	public function updateStatusOrder(Request $request)
    {
		Log::debug('Start ViettelController::updateStatusOrder()');
		
		$tracker = new Tracker();
		// $token = $request->header('Token');
		$password = 'Alphacep0000';
		$hashedPassword = md5($password);
		//if ($token != $hashedPassword) {
		//	Log::debug('Invalid token: ' . $token);
		//	return $this->hasError('Sai token.', []);
		//}

		$data = $request->all();
		if (!isset($data['DATA']['ORDER_NUMBER'])) {
			Log::debug('Invalid request data: ' . json_encode($data));
			return $this->hasError('Dữ liệu đầu vào không đúng định dạng.', []);
		}
		
		if (!isset($data['TOKEN'])) {
			Log::debug('TOKEN: not set');
		}
		else {
			Log::debug('TOKEN: ' . json_encode($data['TOKEN']));
		}
		
		$shipinfo = $data['DATA'];
		$order_id = $shipinfo['ORDER_NUMBER'];
		$tracker->order_id = $order_id;
		$tracker->data = json_encode($shipinfo);
		$tracker->save();

		// Update order status
		if (isset($shipinfo['ORDER_STATUS'])) {
			if ($shipinfo['ORDER_STATUS'] == '501') {
				$order = Order::find($order_id);
				if ($order != null && $order->status != 'delivered') {
					$order->finish();
					$order->save();
				}
			}
		}
		
		$sts = $this->hasSuccess('update successful.', []);
		Log::debug('End ViettelController::updateStatusOrder()');
		
		return $sts;
    }
    public function getListProvince(Request $request)
    {
		$url = env('URL_VIETTELPOSTPROC', '') . "v2/categories/listProvince";
        $datas = $this->getDataMethodGet($url);
		return $this->hasSuccess('Get list successful.', $datas);
    }
	public function getListDistrict(Request $request)
    {
		$url = env('URL_VIETTELPOSTPROC', '') . "v2/categories/listDistrict?provinceId=" . $request->id;
        $datas = $this->getDataMethodGet($url);
		return $this->hasSuccess('Get list successful.', $datas);
    }
	public function getListWards(Request $request)
    {
		$url = env('URL_VIETTELPOSTPROC', '') . "v2/categories/listWards?districtId=" . $request->id;
        $datas = $this->getDataMethodGet($url);
		return $this->hasSuccess('Get list successful.', $datas);
    }
	public function getPriceAllNlp(Request $request)
    {
		$url = env('URL_VIETTELPOSTPROC', '') . "v2/order/getPriceAllNlp";
		$data = [
			"SENDER_ADDRESS" => env('INFO_SENDER_ADDRESS', ''),
			"RECEIVER_ADDRESS" => $request->RECEIVER_ADDRESS,
			"RECEIVER_PROVINCE" =>  $request->RECEIVER_PROVINCE,
			"PRODUCT_TYPE" =>  $request->PRODUCT_TYPE,
			"PRODUCT_WEIGHT" =>  $request->PRODUCT_WEIGHT,
			"PRODUCT_PRICE" => $request->PRODUCT_PRICE,
			"MONEY_COLLECTION" =>  $request->MONEY_COLLECTION,
			"PRODUCT_LENGTH" => $request->PRODUCT_LENGTH,
			"PRODUCT_WIDTH" => $request->PRODUCT_WIDTH,
			"PRODUCT_HEIGHT" => $request->PRODUCT_HEIGHT,
			"TYPE" => $request->TYPE
		];
		$vt_post = $this->getAccessToken(env('URL_VIETTELPOSTPROC', '') . 'v2/user/Login');
        $token = '';
        if ($vt_post && $vt_post['data']) {
             $token = $vt_post['data']['token'];
        }
        $datas = $this->getDataMethodPost($url, $data , $token);
		return $this->hasSuccess('Get list successful.', $datas);
    }
	function getAccessToken($url) {
        // Initialize cURL session
        $ch = curl_init();
    
        // Set the URL
        curl_setopt($ch, CURLOPT_URL, $url);
    
        // Set the HTTP method to POST
        curl_setopt($ch, CURLOPT_POST, true);
    
        // Set the content type to JSON
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));
    
        // Set the payload
        $data = json_encode(array(
            'USERNAME' => env('USERNAME_VIETTELPOST', ''),
            'PASSWORD' => env('PASSWORD_VIETTELPOST', '')
        ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    
        // Return the response as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        // Execute the request
        $response = curl_exec($ch);
    
        // Check for errors
        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);
            print_r($error);

        }
    
        // Close the cURL session
        curl_close($ch);
    
        // Decode the JSON response
        $responseData = json_decode($response, true);
    
        return $responseData;
    }
    function getDataMethodGet($url) {
        // Initialize cURL session
        $ch = curl_init();
    
        // Set the URL
        curl_setopt($ch, CURLOPT_URL, $url);
    
    
        // Set the content type to JSON
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));
    
        // Return the response as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        // Execute the request
        $response = curl_exec($ch);
    
        // Check for errors
        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);
            print_r($error);

        }
    
        // Close the cURL session
        curl_close($ch);
    
        // Decode the JSON response
        $responseData = json_decode($response, true);
    
        return $responseData;
    }
	function getDataMethodPost($url, $data, $token) {
		
        // Initialize cURL session
        $ch = curl_init();
    
        // Set the URL
        curl_setopt($ch, CURLOPT_URL, $url);
    
        // Set the HTTP method to POST
        curl_setopt($ch, CURLOPT_POST, true);
    
        // Set the content type to JSON
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Token: ' . $token // Corrected syntax here
		));
    
        // Set the payload
        $data = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    
        // Return the response as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        // Execute the request
        $response = curl_exec($ch);
    
        // Check for errors
        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);
            print_r($error);

        }
    
        // Close the cURL session
        curl_close($ch);
    
        // Decode the JSON response
        $responseData = json_decode($response, true);
    
        return $responseData;
    }
}

