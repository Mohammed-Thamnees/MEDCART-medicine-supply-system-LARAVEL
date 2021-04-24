<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable=['user_id','order_number','sub_total','quantity','razorpay_id','status','total_amount','name','owner_name','post','pin','mark','number','email','payment_status','coupon','payment_method'];

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

}
