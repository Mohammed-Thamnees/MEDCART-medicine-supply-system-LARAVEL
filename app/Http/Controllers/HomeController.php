<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\DeliveryWork;
use Illuminate\Http\Request;
use App\User;
use App\Models\Order;
use App\Models\ProductReview;
use App\Models\PostComment;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\DB;
use Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    public function index(){
        return view('user.index');
    }

    public function profile(){
        $profile=Auth()->user();
        // return $profile;
        return view('user.users.profile')->with('profile',$profile);
    }

    public function profileUpdate(Request $request,$id){
        // return $request->all();
        $user=User::findOrFail($id);
        $this->validate($request,[
            'name'=>'required|string|min:2',
            'owner_name'=>'required|string|min:2',
            'place'=>'required|string|min:2',
            'number'=>'required|numeric|digits:10',
            'post'=>'required|string|min:2',
            'pin'=>'required|numeric|digits:6',
            'mark'=>'required|string|min:3',
        ]);
        $data=$request->all();
        $status=$user->fill($data)->save();
        if($status){
            request()->session()->flash('success','Successfully updated your profile');
        }
        else{
            request()->session()->flash('error','Please try again!');
        }
        return redirect()->back();
    }

    // Order
    public function orderIndex(){
        $orders=Order::orderBy('id','DESC')->where('user_id',auth()->user()->id)->paginate(10);
        return view('user.order.index')->with('orders',$orders);
    }
    public function userOrderDelete($id)
    {
        $order=Order::find($id);
        if($order){
           if($order->status=="process" || $order->status=='delivered' || $order->status=='cancel'){
                return redirect()->back()->with('error','You cannot delete this order now');
           }
           else{
                $status=$order->delete();
                if($status){
                    request()->session()->flash('success','Order Successfully deleted');
                }
                else{
                    request()->session()->flash('error','Order cannot deleted');
                }
                return redirect()->route('user.order.index');
           }
        }
        else{
            request()->session()->flash('error','Order can not found');
            return redirect()->back();
        }
    }

    public function userOrderCancel(Request $request, $id)
    {
        $order=Order::find($id);
        if($order){
            if($order->status=='delivered' || $order->status=='cancelled'){
                return redirect()->back()->with('error','You cannot cancel this order now');
            }
            else{
                $order['status']='cancelled';
                $status=$order->save();
                DeliveryWork::where('order_id',$order->id)->delete();
                //return $work;
                if($status){
                    request()->session()->flash('success','Order Successfully cancelled');
                }
                else{
                    request()->session()->flash('error','Order cannot cancel');
                }
                return redirect()->route('user.order.index');
            }
        }
        else{
            request()->session()->flash('error','Order cannot found');
            return redirect()->back();
        }
    }

    public function userOrderReturn(Request $request, $id)
    {
        $cart=Cart::find($id);
        $order=Order::where('id',$cart->order_id)->first();
        //return $cart;
        if($cart){
            if($cart->status=='returned'){
                return redirect()->back()->with('error','Product already returned');
            }
            else{
                $this->validate($request,[
                    'r_quantity'=>'required|numeric',
                ]);
                $data['r_quantity']=$cart->r_quantity + $request->r_quantity;
                $data['r_amount']=$data['r_quantity'] * $cart->price;
                $data['status']='process';
                if($request->r_quantity > ($cart->quantity - $cart->r_quantity)){
                    request()->session()->flash('error','Return quantity do not exceeds purchased quantity');
                    return redirect()->back()->with('order',$order);
                }
                else{
                //return $data;
                $status=$cart->fill($data)->save();
                $r_qty_sum=Cart::where('order_id',$order->id)->sum('r_quantity');
                $r_amt_sum=Cart::where('order_id',$order->id)->sum('r_amount');
                $gst=$r_amt_sum + ($r_amt_sum * 12/100);
                $order['r_quantity']=$r_qty_sum;
                $order['r_total_amount']=$gst;
                $order->save();
                if($status){
                    request()->session()->flash('success','Product return applied successfully');
                }
                else{
                    request()->session()->flash('error','Product cannot return. Try again!!!');
                }
                return redirect()->back()->with('order',$order);
                }
            }
        }
        else{
            request()->session()->flash('error','Product cannot found in ordered list');
            return redirect()->back()->with('order',$order);
        }
    }

    public function orderShow($id)
    {
        $order=Order::find($id);
        // return $order;
        return view('user.order.show')->with('order',$order);
    }
    // Product Review
    public function productReviewIndex(){
        $reviews=ProductReview::getAllUserReview();
        return view('user.review.index')->with('reviews',$reviews);
    }

    public function productReviewEdit($id)
    {
        $review=ProductReview::find($id);
        // return $review;
        return view('user.review.edit')->with('review',$review);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function productReviewUpdate(Request $request, $id)
    {
        $review=ProductReview::find($id);
        if($review){
            $data=$request->all();
            $status=$review->fill($data)->update();
            if($status){
                request()->session()->flash('success','Review Successfully updated');
            }
            else{
                request()->session()->flash('error','Something went wrong! Please try again!!');
            }
        }
        else{
            request()->session()->flash('error','Review not found!!');
        }

        return redirect()->route('user.productreview.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function productReviewDelete($id)
    {
        $review=ProductReview::find($id);
        $status=$review->delete();
        if($status){
            request()->session()->flash('success','Successfully deleted review');
        }
        else{
            request()->session()->flash('error','Something went wrong! Try again');
        }
        return redirect()->route('user.productreview.index');
    }

    public function userComment()
    {
        $comments=PostComment::getAllUserComments();
        return view('user.comment.index')->with('comments',$comments);
    }
    public function userCommentDelete($id){
        $comment=PostComment::find($id);
        if($comment){
            $status=$comment->delete();
            if($status){
                request()->session()->flash('success','Post Comment successfully deleted');
            }
            else{
                request()->session()->flash('error','Error occurred please try again');
            }
            return back();
        }
        else{
            request()->session()->flash('error','Post Comment not found');
            return redirect()->back();
        }
    }
    public function userCommentEdit($id)
    {
        $comments=PostComment::find($id);
        if($comments){
            return view('user.comment.edit')->with('comment',$comments);
        }
        else{
            request()->session()->flash('error','Comment not found');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userCommentUpdate(Request $request, $id)
    {
        $comment=PostComment::find($id);
        if($comment){
            $data=$request->all();
            // return $data;
            $status=$comment->fill($data)->update();
            if($status){
                request()->session()->flash('success','Comment successfully updated');
            }
            else{
                request()->session()->flash('error','Something went wrong! Please try again!!');
            }
            return redirect()->route('user.post-comment.index');
        }
        else{
            request()->session()->flash('error','Comment not found');
            return redirect()->back();
        }

    }

    public function changePassword(){
        return view('user.layouts.userPasswordChange');
    }
    public function changPasswordStore(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => 'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);

        return redirect()->route('home')->with('success','Password successfully changed');
    }


}
