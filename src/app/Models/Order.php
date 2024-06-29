<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cart;
use App\Models\Product;

class Order extends Model
{
    protected $fillable=['user_id','order_number','sub_total','quantity','delivery_charge','status','total_amount','first_name','last_name','country','post_code','address1','address2','phone','email','payment_method','payment_status','shipping_id','coupon', 'province', 'district', 'wards','shipping_vt','inp_total_cart_ship','code_vt_ship', 'vit_post_data', 'deliveried_time', 'paid_confirmed_by', 'ship_order_code'];

	protected $casts = [
        'deliveried_time' => 'datetime'
    ];
	
    public function cart_info(){
        return $this->hasMany('App\Models\Cart','order_id','id');
    }
    public static function getAllOrder($id){
        return Order::with('cart_info')->find($id);
    }
    public static function countActiveOrder(){
        $data=Order::count();
        if($data){
            return $data;
        }
        return 0;
    }
    public function cart(){
        return $this->hasMany(Cart::class);
    }

    public function shipping(){
        return $this->belongsTo(Shipping::class,'shipping_id');
    }
	
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function getUserConfirmedPayment()
    {
        return $this->belongsTo('App\User', 'paid_confirmed_by', 'id')->first();
    }

	/**
	 * Hoan thanh 1 don hang.
	 * Mot don hang dc xem la hoan thanh khi san pham da dc giao den tay nguoi nhan.
	 * Tai thoi diem nay co the tien thanh toan moi chi dc giu boi ben van chuyen va nguoi ban van chua nhan dc thanh toan.
	 */
	public function finish() {
		// Update inventory
		foreach($this->cart as $cart){
			$product = $cart->product;
			$product->stock -= $cart->quantity;
			$product->save();
		}

		$this->deliveried_time = date('Y-m-d H:i:s');
		$this->status = 'delivered';
	}
	
}
