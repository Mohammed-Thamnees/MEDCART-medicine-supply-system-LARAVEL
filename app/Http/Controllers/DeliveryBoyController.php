<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeliveryBoy;
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
        $boy=DeliveryBoy::orderBy('id','ASC')->paginate(10);
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

            'name'=>'required|alpha_dash|max:30',
            'place'=>'required|alpha|min:2',
            'address'=>'required|min:2',
            'email'=>'required|email|unique:delivery_boys,email',
            'number'=>'required|numeric|digits:10|unique:delivery_boys,number',
            'post'=>'required|alpha|min:2',
            'pin'=>'required|numeric|digits:6',
            'password'=>'required|string',
            'status'=>'required|in:active,inactive',
            'photo'=>'nullable|string',
        ]);

        $data=$request->all();
        $data['password']=Hash::make($request->password);
        $status=DeliveryBoy::create($data);
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
        $boy=DeliveryBoy::find($id);
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
        $boy=DeliveryBoy::findOrFail($id);
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
        $boy=DeliveryBoy::findOrFail($id);
        $this->validate($request,
        [
            
            'name'=>'required|alpha_dash|max:30',
            'place'=>'required|alpha|min:2',
            'address'=>'required|min:2',
            'email'=>'required|email',
            'number'=>'required|numeric|digits:10',
            'post'=>'required|alpha|min:2',
            'pin'=>'required|numeric|digits:6',
            'status'=>'required|in:active,inactive',
            'photo'=>'nullable|string'
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
        $delete=DeliveryBoy::findorFail($id);
        $status=$delete->delete();
        if($status){
            request()->session()->flash('success','successfully deleted delivery boy');
        }
        else{
            request()->session()->flash('error','Error occurred while deleting delivery boy');
        }
        return redirect()->route('deliveryboys.index');
    }
}
