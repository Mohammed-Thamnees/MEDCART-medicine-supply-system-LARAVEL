@extends('frontend.layouts.master')

@section('title','Checkout page')

@section('main-content')

<div class="container mt-5 col-6 mx-auto pt-5">

    <div class="text-center">
    <img src="{{ asset('image/namaskaram.jpg') }}" class="img-fluid" style="height:200px">
    </div>
    <form method="post" action="{{ route('payments') }}">
      @csrf
        <div class="form-group">
          <label for="exampleInputEmail1">Your Order ID</label>
          <input type="text" name="name" class="form-control" placeholder="" value="">
             </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Order Total Amount</label>
          <input type="text" name="amount" class="form-control" id="exampleInputPassword1" placeholder="" value="">
        </div>
       
        <button type="submit" class="btn btn-primary btn-block">Submit</button>
      </form>


</div>

@if(Session::has('data'))

<div class="container tex-center mx-auto">
<form action="{{ url('/pay') }}" method="POST" class="text-center mx-auto mt-5">
  <script
      src="https://checkout.razorpay.com/v1/checkout.js"
      data-key= "{{ env('RAZOR_KEY') }}"
data-amount="{{Session::get('data.amount')}}" 
      data-currency="INR"
data-order_id="{{Session::get('data.order_id')}}"
      data-buttontext="Pay with Razorpay"
      data-name="Product Name"
      data-description="Product Discription"
     
      data-theme.color="#F37254"
  ></script>
  <input type="hidden" custom="Hidden Element" name="hidden">
  </form>

</div>

@endif


@endsection