<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable=['user_id','order_number','sub_total','quantity','delivery_charge','status','total_amount','first_name','last_name','country','post_code','address1','address2','phone','email','payment_method','payment_status','shipping_id','coupon', 'province', 'district', 'wards','shipping_vt','inp_total_cart_ship','code_vt_ship', 'vit_post_data', 'deliveried_time', 'paid_confirmed_by'];

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

}
