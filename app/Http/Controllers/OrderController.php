<?php

namespace App\Http\Controllers;

use App\Models\DeliveryBoy;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Shipping;
use App\Models\DeliveryWork;
use App\User;
use Illuminate\Support\Facades\DB;
use PDF;
use Notification;
use Helper;
use Illuminate\Support\Str;
use App\Notifications\StatusNotification;

//newly added
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
use Monolog\SignalHandler;
use Session;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders=Order::orderBy('created_at','DESC')->paginate(10);
        //return $orders;
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
    public function store(Request $request)
    {
        $this->validate($request,[
            'shop_name'=>'required|string',
            'owner_name'=>'required|string',
            'coupon'=>'nullable|string',
            'number'=>'required|numeric|digits:10',
            'post'=>'required|string',
            'pin'=>'required|numeric|digits:6',
            'mark'=>'required|string',
            'place'=>'required|string',
            'email'=>'required|email'
        ]);
         //return $request->all();

        if(empty(Cart::where('user_id',auth()->user()->id)->where('order_id',null)->first())){
            request()->session()->flash('error','Cart is Empty !');
            return back();
        }


        $order=new Order();
        $order_data=$request->all();
        $order_data['order_number']='ORD-'.strtoupper(Str::random(10));

        $order_data['user_id']=$request->user()->id;
        $order_data['shipping_id']=$request->shipping;
        $shipping=Shipping::where('id',$order_data['shipping_id'])->pluck('price');
        // return session('coupon')['value'];
        $order_data['sub_total']=Helper::totalCartPrice();
        //return $order_data['sub_total'];
        $order_data['quantity']=Helper::cartCount();

        //gst 12% add with amound
        $gst=$order_data['sub_total']+($order_data['sub_total']*(12/100));
        //return $gst;


        if(session('coupon')){
            $order_data['coupon']=session('coupon')['value'];
        }
        if($request->shipping){
            if(session('coupon')){
                $order_data['total_amount']=$gst+$shipping[0]-session('coupon')['value'];
            }
            else{
                $order_data['total_amount']=$gst+$shipping[0];
            }
        }
        else{
            if(session('coupon')){
                $order_data['total_amount']=$gst-session('coupon')['value'];
            }
            else{
                $order_data['total_amount']=$gst;
            }
        }


        $order_data['status']="new";
        $order_data['payment_status']='Unpaid';

        //$api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));
        //$create  = $api->order->create(array('receipt' => '123', 'amount' => $order_data['total_amount'] * 100 , 'currency' => 'INR')); // Creates order
        //$orderId = $create['id'];





        $order->fill($order_data);
        //return $order;
        //dd($order);
        $status=$order->save();

        $data = array(
            'order_id' => $order_data['order_number'],
            'amount' => $order_data['total_amount']
        );

        //return $data;
        //Session::put('data', $data);
        //Session::put('order_id', $order_data['order_number']);
        //Session::put('amount' , $order_data['total_amount']);


        if($order)
        // dd($order->id);
        $users=User::where('role','admin')->first();
        $details=[
            'title'=>'New order created',
            'actionURL'=>route('order.show',$order->id),
            'fas'=>'fa-file-alt'
        ];
        Notification::send($users, new StatusNotification($details));

        if(request('payment_method')=='paypal'){
            return redirect()->route('payment')->with(['id'=>$order->id]);
        }
        else{
            session()->forget('cart');
            session()->forget('coupon');
        }

        Cart::where('user_id', auth()->user()->id)->where('order_id', null)->update(['order_id' => $order->id]);

        // dd($users);


        //request()->session()->flash('success','Your product successfully placed in order');
        request()->session()->flash('success','Order successfully placed');
        //return redirect()->route('start')->with('data',$data);
        //return view('frontend.pages.payment')->with('data',$data);
        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$order=Order::find($id);
        $order=Order::getAllOrder($id);
        //return $order;
        return view('backend.order.show')->with('order',$order);
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
            'status'=>'required|in:new,process'
        ]);
        $data=$request->all();
        // return $request->status;
        if ($request->status=='process'){
            foreach($order->cart as $cart){
                $product=$cart->product;
                // return $product;
                $product->stock -=$cart->quantity;
                $product->save();
            }
        }

        $status=$order->fill($data)->save();
        if($status){
            request()->session()->flash('success','Successfully updated order');
        }
        else{
            request()->session()->flash('error','Error while updating order');
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
            Cart::where('order_id',$order->id)->delete();
            DeliveryWork::where('order_id',$order->id)->delete();
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

    public function return($id){
        $boy=DeliveryWork::select('order_id')->where([['type','pickup'],['order_id',$id]])->first();
        //return $boy;
        $cart=DB::table('products')->join('carts','products.id','=','carts.product_id')
                    ->select('products.title','carts.r_quantity','carts.price','carts.r_amount','carts.status','carts.order_id')
                    ->where([['carts.order_id',$id],['carts.status','!=','new']])->get();
        //return $cart;
        return view('backend.order.return')->with('cart',$cart)->with('boy',$boy);
    }

    public function boys($id){
        $order=Order::find($id);
        $boy=User::where('role','db')->orderBy('created_at','DESC')->paginate(10);
        return view('backend.order.boys')->with('boy',$boy)->with('order',$order);
    }

    public function assign(Request $request, $id,$oid)
    {
        $boy=User::find($id);
        //return $boy;
        $order=Order::find($oid);
        //return $order;
        $data['boy_id']=$boy->id;
        $data['order_id']=$order->id;
        $data['type']='pickup';
        $status=DeliveryWork::create($data);

        if($status){
            request()->session()->flash('success','successfully assigned delivery boy');
        }
        else{
            request()->session()->flash('error','Error occurred while assigning delivery boy');
        }
        return redirect()->route('order.index');

    }

}


