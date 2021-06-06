<?php

namespace App\Http\Controllers;

use App\Models\DeliveryWork;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DeliveryBoyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $boy=User::where('role','db')->orderBy('created_at','DESC')->paginate(10);
        return view('backend.deliveryboy.index')->with('boy',$boy);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.deliveryboy.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,
        [

            'name'=>'required|string|max:30',
            'place'=>'required|string|min:2',
            'address'=>'required|min:2',
            'email'=>'required|email|unique:users,email',
            'number'=>'required|numeric|digits:10|unique:users,number',
            'post'=>'required|string|min:2',
            'pin'=>'required|numeric|digits:6',
            'password'=>'required|string',
            'status'=>'required|in:active,inactive',
            'photo'=>'nullable|string',
        ]);

        $data=$request->all();
        $data['password']=Hash::make($request->password);
        $data['role']='db';
        $status=User::create($data);
        if($status){
            request()->session()->flash('success','successfully added delivery boy');
        }
        else{
            request()->session()->flash('error','Error occurred while adding delivery boy');
        }
        return redirect()->route('deliveryboys.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $boy=User::find($id);
        return view('backend.deliveryboy.show')->with('boy',$boy);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $boy=User::findOrFail($id);
        return view('backend.deliveryboy.edit')->with('boy',$boy);
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
        $boy=User::findOrFail($id);
        $this->validate($request,
        [

            'name'=>'required|string|max:30',
            'place'=>'required|string|min:2',
            'address'=>'required|min:2',
            'email'=>'required|email',
            'number'=>'required|numeric|digits:10',
            'post'=>'required|string|min:2',
            'pin'=>'required|numeric|digits:6',
            'status'=>'required|in:active,inactive',
            'photo'=>'nullable|string',
        ]);
        $data=$request->all();
        //return $data;
        $status=$boy->fill($data)->save();
        if($status){
            request()->session()->flash('success','successfully updated delivery boy');
        }
        else{
            request()->session()->flash('error','Error occurred while updating delivery boy');
        }
        return redirect()->route('deliveryboys.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete=User::findorFail($id);
        $status=$delete->delete();
        if($status){
            request()->session()->flash('success','successfully deleted delivery boy');
        }
        else{
            request()->session()->flash('error','Error occurred while deleting delivery boy');
        }
        return redirect()->route('deliveryboys.index');
    }

    public function dbhome(){
        $work=DB::table('delivery_works')->join('orders','delivery_works.order_id','=','orders.id')
                    ->select('orders.*','delivery_works.status')->where([['boy_id',Auth::id()],['type','delivery']])->orderBy('created_at','DESC')
                    ->paginate(10);
        //return $work;
        return view('deliveryboy.pages.index')->with('work',$work);
    }

    public function pickup(){
        $work=DB::table('delivery_works')->join('orders','delivery_works.order_id','=','orders.id')
            ->select('orders.*','delivery_works.status')->where([['boy_id',Auth::id()],['type','pickup']])->orderBy('created_at','DESC')
            ->paginate(10);
        //return $work;
        return view('deliveryboy.pages.pickup')->with('work',$work);
    }

    public function order($id){
        $order=Order::getAllOrder($id);
        //return $order;
        return view('deliveryboy.pages.work')->with('order',$order);
    }

    public function status(Request $request, $id){
        $order=Order::find($id);
        $data['status']='delivered';
        $data['payment_status']='paid';
        $status=$order->fill($data)->save();
        DB::table('delivery_works')->where([['order_id',$id],['type','delivery']])->update(['status'=>'completed']);

        if($status){
            request()->session()->flash('success','Successfully updated order status');
        }
        else{
            request()->session()->flash('error','Error while updating order status');
        }
        return redirect()->route('db.home');
    }

    public function returnstatus(Request $request, $id){
        $status=DB::table('carts')->where([['order_id',$id],['status','process']])->update(['status'=>'returned']);
        DB::table('delivery_works')->where([['order_id',$id],['type','pickup']])->update(['status'=>'completed']);

        if($status){
            request()->session()->flash('success','Successfully updated return status');
        }
        else{
            request()->session()->flash('error','Error while updating return status');
        }
        return redirect()->route('db.pickup');
    }

    public function returnorder($id){
        $order=Order::getAllOrder($id);
        //return $order;
        return view('deliveryboy.pages.return')->with('order',$order);
    }
}
