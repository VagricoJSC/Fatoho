<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Shipping;
use App\Models\Tracker;
use App\User;
use PDF;
use Notification;
use Helper;
use Illuminate\Support\Str;
use App\Notifications\StatusNotification;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders=Order::orderBy('id','DESC')->paginate(10);
        return view('backend.order.index')->with('orders',$orders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
	
	
    public function store(Request $request)
    {
        if(empty(Cart::where('user_id',auth()->user()->id)->where('order_id',null)->first())){
            request()->session()->flash('error','Cart is Empty !');
            return back();
        }
        
        $order=new Order();
        $order_data=$request->all();
		
        $order_data['order_number']='ORD-'.strtoupper(Str::random(10));
        $order_data['user_id']=$request->user()->id;
		
        $order_data['sub_total']=Helper::totalCartPrice();
        $order_data['quantity']=Helper::cartCount();
        $order_data['total_amount']=Helper::totalCartPrice() + $request->inp_total_cart_ship;
		
        $order_data['status'] = "new";
        if(request('payment_method')=='bank'){
            $order_data['payment_method']='bank';
            $order_data['payment_status']='unpaid';
        }
        else{
            $order_data['payment_method']='cod';
            $order_data['payment_status']='unpaid';
        }
		
        $order->fill($order_data);
        $status=$order->save();
 
		if ($order) {
			// Notify to admin
			$users = User::where('role','admin')->orderBy('id', 'ASC')->first();
			$details=[
				'title'=>'Có đơn hàng mới. Hãy tiến hành kiểm tra và xử lý.',
				'actionURL'=>route('order.show',$order->id),
				'fas'=>'fa-file-alt'
			];
			Notification::send($users, new StatusNotification($details));

			session()->forget('cart');
			session()->forget('coupon');
			
			// Update cart
			Cart::where('user_id', auth()->user()->id)->where('order_id', null)->update(['order_id' => $order->id]);

			// Create order tracking
			$tracker = new Tracker();
			$tracker->order_id = $order->id;
			$shipinfo = [
				'STATUS' => $order->status
			];
			$tracker->data = json_encode($shipinfo);
			$tracker->save();

			request()->session()->flash('success', 'Đơn hàng đã tạo thành công!');
		}
		
        return redirect()->route('home');
    }

	/**
	 * Change payment status to paid
	 */
	public function confirmPaid($id) {
        $order=Order::find($id);
		$order->payment_status = 'paid';
		$order->paid_confirmed_by = auth()->user()->id;
		$order->save();
		
        request()->session()->flash('success','Đã cập nhật trạng thái thanh toán thành công!');
        return redirect()->route('order.show', $order->id);
	}
	
	
	/**
	 * Create delivery request
	 */
	public function createDeliveryRequest($id) {
        $order = Order::find($id);
		if ($order == null) {
			request()->session()->flash('error', 'Không tìm thấy đơn hàng!');
			return redirect()->route('order.show', $order->id);
		}
		
		if ($order->payment_method == 'bank') {
			if ($order->payment_status == 'unpaid') {
				request()->session()->flash('error', 'Đơn hàng này phương thức thanh toàn bằng Chuyển khoản ngân hàng. Cần xác nhận đã thanh toán trước khi gửi hàng hóa!');
				return redirect()->route('order.show', $order->id);
			}
		}
		
		$vt_post = $this->getAccessToken(env('URL_VIETTELPOSTPROC', '') . 'v2/user/Login');
		$token = '';
		if ($vt_post && $vt_post['data']) {
			 $token = $vt_post['data']['token'];
		}
		
		$url = env('URL_VIETTELPOSTPROC', '') . "v2/order/createOrderNlp";
		$data = [
			"ORDER_NUMBER" => $order->id,
			"SENDER_FULLNAME" => env('INFO_SENDER_NAME', ''),
			"SENDER_ADDRESS" => env('INFO_SENDER_ADDRESS', ''),
			"SENDER_PHONE" => env('INFO_SENDER_PHONE', ''),
			"RECEIVER_FULLNAME" => $order->first_name . ' ' . $order->last_name,
			"RECEIVER_ADDRESS" => $order->address2,
			"RECEIVER_PHONE" => $order->phone,
			"PRODUCT_NAME" =>  env('INFO_PRODUCT_NAME', ''),
			"PRODUCT_DESCRIPTION" => "Cho khách xem hàng khi nhận, cho xem hàng",
			"PRODUCT_QUANTITY" => $order->quantity,
			"PRODUCT_PRICE" => $order->sub_total,
			"PRODUCT_WEIGHT" => Helper::totalCartWEIGHT(),
			"PRODUCT_LENGTH" => 0,
			"PRODUCT_WIDTH" => 0,
			"PRODUCT_HEIGHT" => 0,
			"ORDER_PAYMENT" => ($order->payment_method == 'cod') ? 3 : 1,
			"ORDER_SERVICE" => $order->shipping_vt,
			"PRODUCT_TYPE" => "HH",
			"ORDER_SERVICE_ADD" => null,
			"ORDER_NOTE" => " Cho khách xem hàng khi nhận, cho xem hàng",
			"MONEY_COLLECTION" => $order->total_amount,  
			"EXTRA_MONEY" => 0,  
			"CHECK_UNIQUE" => true,  
			"LIST_ITEM" => []
		];
		$cart =  Cart::with('product')->where('user_id', $order->user_id)->where('order_id', $order->id)->get();
		
		$productList = [];
		foreach($cart as $item) {
			$productList[] = [
				"PRODUCT_NAME" => $item->product->title,
				"PRODUCT_QUANTITY" => $item->quantity,
				"PRODUCT_PRICE" => $item->product->price,
				"PRODUCT_WEIGHT" => $item->product->weight
			];
		}
		$data['LIST_ITEM'] = $productList;
		
		$resp = $this->getDataMethodPost($url, $data , $token);
		
		// Failed to request ship
		if (!isset($resp['data']['ORDER_NUMBER'])) {
			request()->session()->flash('error','Gửi yêu cầu chuyển hàng hóa thất bại. Hãy thử lại sau ít phút!');
			return redirect()->route('order.show', $order->id);
		}
		
		// Update ship info into ORDER
		$order->ship_order_code = $resp['data']['ORDER_NUMBER'];
		if ($order->status == 'new' || $order->status == 'processing') {
			$order->status = 'shipped';
		}
		$order->vit_post_data = json_encode($resp);
		$order->save();

		// Notify admin
		$users=User::where('role','admin')->orderBy('id', 'ASC')->first();
		$details=[
			'title'=>'Đã gửi yêu cầu chuyển hàng cho ViettelPost',
			'actionURL'=>route('order.show', $order->id),
			'fas'=>'fa-file-alt'
		];
		Notification::send($users, new StatusNotification($details));

        request()->session()->flash('success','Đã gửi yêu cầu chuyển hàng hóa!');
        return redirect()->route('order.show', $order->id);
	}
	

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order=Order::find($id);
		$order->vit_post_data = json_decode($order->vit_post_data);
		$carts = Cart::with('product')->where('order_id', $id)->get();
        // return $order;
        return view('backend.order.show')->with('carts',$carts)->with('order',$order);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order=Order::find($id);
        return view('backend.order.edit')->with('order',$order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order=Order::find($id);
        $this->validate($request,[
            'status'=>'required|in:new,processing,shipped,delivered,cancel'
        ]);
		
        $data=$request->all();
		$order = $order->fill($data);

        if ($request->status == 'delivered') {
			$order->finish();
        }
		else if ($request->status == 'cancel') {
			// Create order tracking
			$tracker = new Tracker();
			$tracker->order_id = $order->id;
			$shipinfo = [
				'STATUS' => $order->status
			];
			$tracker->data = json_encode($shipinfo);
			$tracker->save();
		}
        
		$status = $order->save();
        
		if($status) {
            request()->session()->flash('success','Đơn hàng đã được cập nhật thành công.');
        }
        else{
            request()->session()->flash('error','Không thể cập nhật đơn hàng. Vui lòng thử lại sau ít phút.');
        }
		
        return redirect()->route('order.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order=Order::find($id);
        if($order){
            $status=$order->delete();
            if($status){
                request()->session()->flash('success','Order Successfully deleted');
            }
            else{
                request()->session()->flash('error','Order can not deleted');
            }
            return redirect()->route('order.index');
        }
        else{
            request()->session()->flash('error','Order can not found');
            return redirect()->back();
        }
    }

    public function orderTrack(){
        return view('frontend.pages.order-track')->with('tracks', []);
    }

    public function productTrackOrder(Request $request){
        $order = Order::where('order_number', $request->order_number)->first();
        if ($order == null) {
            request()->session()->flash('error','Không tìm thấy đơn hàng. Vui lòng kiểm tra lại mã đơn hàng.');
			return view('frontend.pages.order-track')->with('tracks', [])->with('order_number', $request->order_number);
		}
		
		$track_list = Tracker::where('order_id', $order->id)->orderBy('updated_at','ASC')->get();
		
		if ($track_list == null || empty($track_list)) {
            request()->session()->flash('error','Đơn hàng đang đợi nhà sản xuất tiếp nhận. Vui lòng thử lại sau vài giờ sau.');
			return view('frontend.pages.order-track')->with('tracks', [])->with('order_number', $request->order_number);
		}
		
		$pending_track_list = Tracker::createPendingStatusList($order->status);
		
        request()->session()->flash('success','Đã lấy dữ liệu thành công!');

        return view('frontend.pages.order-track')
			->with('tracks', $track_list)
			->with('order_number', $request->order_number)
			->with('pending_tracks', $pending_track_list);
    }

    // PDF generate
    public function pdf(Request $request){
        $order=Order::getAllOrder($request->id);
        // return $order;
        $file_name=$order->order_number.'-'.$order->first_name.'.pdf';
        // return $file_name;
        $pdf=PDF::loadview('backend.order.pdf',compact('order'));
        return $pdf->download($file_name);
    }
	
    // Income chart
    public function incomeChart(Request $request){
        $year=\Carbon\Carbon::now()->year;
        // dd($year);
        $items=Order::with(['cart_info'])->whereYear('created_at',$year)->where('status','delivered')->get()
            ->groupBy(function($d){
                return \Carbon\Carbon::parse($d->created_at)->format('m');
            });
            // dd($items);
        $result=[];
        foreach($items as $month=>$item_collections){
            foreach($item_collections as $item){
                $amount=$item->cart_info->sum('amount');
                // dd($amount);
                $m=intval($month);
                // return $m;
                isset($result[$m]) ? $result[$m] += $amount :$result[$m]=$amount;
            }
        }
        $data=[];
        for($i=1; $i <=12; $i++){
            $monthName=date('F', mktime(0,0,0,$i,1));
            $data[$monthName] = (!empty($result[$i]))? number_format((float)($result[$i]), 2, '.', '') : 0.0;
        }
        return $data;
    }
}
