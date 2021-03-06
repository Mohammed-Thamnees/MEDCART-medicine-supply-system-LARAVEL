<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\User;
use Illuminate\Http\Request;

class UserHistoryController extends Controller
{
    public function index()
    {
        $user=User::where('status','active')->where('role','user')->orderBy('created_at','DESC')->paginate(10);
        return view('backend.shophistory.index')->with('user',$user);
    }

    public function orders($id)
    {
        $orders=Order::where('user_id',$id)->orderBy('created_at','DESC')->get();
        //return $orders;
        return view('backend.shophistory.orders')->with('orders',$orders);
    }

    public function products($id)
    {
        $products=Order::getAllOrder($id);
        //return $products;
        return view('backend.shophistory.products')->with('products',$products);
    }

    public function report(){
        $order=Order::get();
        //return $order;
        return view('backend.shophistory.report')->with('order',$order);
    }
}
