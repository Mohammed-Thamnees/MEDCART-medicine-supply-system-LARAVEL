<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Events\MessageSent;
class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $messages=Message::orderBy('created_at','DESC')->paginate(20);
        return view('backend.message.index')->with('messages',$messages);
    }
    public function messageFive()
    {
        $message=Message::whereNull('read_at')->limit(5)->get();
        return response()->json($message);
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
            'message'=>'required|min:20|max:200',
            'subject'=>'required|string'
        ]);

        $data=$request->all();
        $data['user_id']=Auth()->user()->id;

         //return $data;

        $message=Message::create($data);
            // return $message;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $message=Message::find($id);
        if($message){
            $message->read_at=\Carbon\Carbon::now();
            $message->save();
            return view('backend.message.show')->with('message',$message);
        }
        else{
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $message=Message::find($id);
        return view('backend.message.reply')->with('message',$message);
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
        $message=Message::findOrFail($id);
        $this->validate($request,[
            'reply'=>'required|String'
        ]);
        $data=$request->all();
        $status=$message->fill($data)->save();
        if($status){
            request()->session()->flash('success','successfully replied');
        }
        else{
            request()->session()->flash('error','Error occurred while replying');
        }
        return redirect()->route('message.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $message=Message::find($id);
        $status=$message->delete();
        if($status){
            request()->session()->flash('success','Successfully deleted message');
        }
        else{
            request()->session()->flash('error','Error occurred please try again');
        }
        return back();
    }

    public function reply(){
        $reply=Message::where('id',Auth()->user()->id)->get();
        //return $reply;
        return view('frontend.pages.view-reply')->with('reply',$reply);
    }
}
