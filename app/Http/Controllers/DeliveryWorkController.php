<?php

namespace App\Http\Controllers;

use App\Models\DeliveryWork;
use App\Models\Order;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryWorkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order=DB::table('orders')->select('orders.*')->whereNotIn('orders.id',function ($query){
                $query->select('delivery_works.order_id')->from('delivery_works')->get();
                })
            ->where('orders.status','process')->orderBy('orders.created_at','DESC')
            ->paginate(10);
        //return $order;
        return view('backend.deliverywork.index')->with('order',$order);
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
        //
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
        $boy=User::where('role','db')->orderBy('created_at','DESC')->paginate(10);
        return view('backend.deliverywork.boys')->with('boy',$boy)->with('order',$order);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function assign(Request $request, $id,$oid)
    {
        $boy=User::find($id);
        //return $boy;
        $order=Order::find($oid);
        //return $order;
        $data['boy_id']=$boy->id;
        $data['order_id']=$order->id;
        $data['type']='delivery';
        $status=DeliveryWork::create($data);

        if($status){
            request()->session()->flash('success','successfully assigned delivery boy');
        }
        else{
            request()->session()->flash('error','Error occurred while assigning delivery boy');
        }
        return redirect()->route('deliveryworks.index');

    }

    public function work()
    {
        $work=DB::table('delivery_works')->join('users','delivery_works.boy_id','=','users.id')
                    ->join('orders','delivery_works.order_id','=','orders.id')
                    ->select('orders.order_number','orders.shop_name','orders.place','users.name','users.number','delivery_works.created_at','delivery_works.status')
                    ->get();
        return view('backend.deliverywork.worklist')->with('work',$work);
    }
}
