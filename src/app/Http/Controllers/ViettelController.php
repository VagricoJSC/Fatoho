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

class ViettelController extends Controller
{

	public function updateStatusOrder(Request $request)
    {
		$tracker = new Tracker();
		$token = $request->header('Token');
		$password = 'Alphacep0000';
		$hashedPassword = md5($password);
		if ($token != $hashedPassword) {
			return $this->hasError('Sai token.', []);
		}
		$data = $request->all();
		if (!isset($data['DATA']['ORDER_NUMBER'])) {
			return $this->hasError('Dữ liệu đầu vào không đúng định dạng.', []);
		}
		$tracker->order_id = $data['DATA']['ORDER_NUMBER'];
		$tracker->data = json_encode($data['DATA']);
		$tracker->save();
		
		
		return $this->hasSuccess('update successful.', []);
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

