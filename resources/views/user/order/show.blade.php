@extends('frontend.layouts.master')

@section('title','Order Detail')

@section('main-content')
<div class="card">
<h5 class="card-header">Orders
  <!--<a href="{{route('order.pdf',$order->id)}}" class=" btn btn-sm btn-primary shadow-sm float-right"><i class="fas fa-download fa-sm text-white-50"></i> Generate PDF</a>-->
  </h5>
  <div class="card-body">
    @if($order)
    <table class="table table-striped table-hover">
      <thead>
        <tr>
            <th>Order No.</th>
            <th>Shop Name</th>
            <th>Owner Name</th>
            <th>Email</th>
            <th>Total Order Quantity</th>
            <th>Total Order Amount</th>
            <th>Status</th>
            @if($order->status=='new' || $order->status=='process')
            <th>Order Cancel</th>
            @endif
        </tr>
      </thead>
      <tbody>
        <tr>
            @php
                $shipping_charge=DB::table('shippings')->where('id',$order->shipping_id)->pluck('price');
            @endphp
            <td>{{$order->order_number}}</td>
            <td>{{$order->shop_name}}</td>
            <td>{{$order->owner_name}}</td>
            <td>{{$order->email}}</td>
            <td align="center">{{$order->quantity - $order->r_quantity}}</td>
            <td>RS {{number_format($order->total_amount - $order->r_total_amount,2)}}</td>
            <td>
                @if($order->status=='new')
                  <span class="badge badge-primary">{{$order->status}}</span>
                @elseif($order->status=='process')
                  <span class="badge badge-warning">{{$order->status}}</span>
                @elseif($order->status=='delivered')
                  <span class="badge badge-success">{{$order->status}}</span>
                @elseif($order->status=='cancelled')
                  <span class="badge badge-danger">{{$order->status}}</span>
                @endif
            </td>
            @if($order->status=='new' || $order->status=='process')
            <td>
                    <form method="post" action="{{ route('user.order.cancel',$order->id) }}">
                        @csrf
                    <button class="btn-danger btn-sm float-left mr-1" >Order Cancel</button>
                    </form>
            </td>
            @endif
        </tr>
      </tbody>
    </table>

    <section class="confirmation_part section_padding">
      <div class="order_boxes">
        <div class="row">
          <div class="col-lg-6 col-lx-4">
            <div class="order-info">
              <h4 class="text-center pb-4">ORDER INFORMATION</h4>
              <table class="table">
                    <tr class="">
                        <td>Order Number</td>
                        <td> : {{$order->order_number}}</td>
                    </tr>
                    <tr>
                        <td>Order Date</td>
                        <td> : {{$order->created_at->format('D d M, Y')}} at {{$order->created_at->format('g : i a')}} </td>
                    </tr>
                    <tr>
                        <td>Total quantity of ordered products</td>
                        <td> : {{$order->quantity - $order->r_quantity}}</td>
                    </tr>
                    <tr>
                      <td>Total quantity of returned products</td>
                      <td> : {{$order->r_quantity}}</td>
                    </tr>
                    <tr>
                        <td>Total Order Amount</td>
                        <td> : RS {{number_format($order->total_amount - $order->r_total_amount,2)}}</td>
                    </tr>
                    <tr>
                      <td>Total Return Amount</td>
                      <td> : RS {{number_format($order->r_total_amount,2)}}</td>
                  </tr>
                    <tr>
                      <td>Order Status</td>
                      <td> : {{$order->status}}</td>
                  </tr>
                    <tr>
                        <td>Payment Status</td>
                        <td> : {{$order->payment_status}}</td>
                    </tr>
              </table>
            </div>
          </div>

          <div class="col-lg-6 col-lx-4">
            <div class="shipping-info">
              <h4 class="text-center pb-4">SHIPPING INFORMATION</h4>
              <table class="table">
                    <tr class="">
                        <td>Shop Name</td>
                        <td> : {{$order->shop_name}}</td>
                    </tr>
                    <tr class="">
                      <td>Owner Name</td>
                      <td> : {{$order->owner_name}}</td>
                  </tr>
                    <tr>
                        <td>Email</td>
                        <td> : {{$order->email}}</td>
                    </tr>
                    <tr>
                        <td>Phone No.</td>
                        <td> : {{$order->number}}</td>
                    </tr>
                    <tr>
                        <td>Post Office</td>
                        <td> : {{$order->post}}</td>
                    </tr>
                    <tr>
                        <td>Pin</td>
                        <td> : {{$order->pin}}</td>
                    </tr>
                    <tr>
                        <td>Land Mark</td>
                        <td> : {{$order->mark}}</td>
                    </tr>
                    <tr>
                      <td>Shipping Charge</td>
                      <td> : Free</td>
                  </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>

    <br><br>

    <h3 class="text-center pb-4"><u>Ordered Product Information</u></h3>
    <table class="table table-hover">
      @php
        $product=DB::table('products')->join('carts','products.id','=','carts.product_id')
                    ->select('products.title','carts.quantity','carts.price','carts.amount','carts.r_amount','carts.r_quantity','carts.status','carts.id')
                    ->where('carts.order_id',$order->id)->whereRaw('(carts.quantity - carts.r_quantity)>0')->get();

        $status=DB::table('carts')->select('status')->where([['status','returned'],['order_id',$order->id]])->first();
        //dd($status);
        @endphp    
      <thead>
        <tr>

            <th>Product Name</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>CGST</th>
            <th>SGST</th>
            <th>Sub Total</th>
            
        </tr>
      </thead>
      @foreach ($product as $product)
      
      <tbody>
        <tr>

            <td>{{$product->title}}</td>
            <td>{{ $product->quantity - $product->r_quantity }}</td>
            <td>RS {{number_format($product->price,2)}}</td>
                  @php
                    $amount=$product->amount - $product->r_amount;
                    $gst=$amount*(6/100);
                    //$gst_total=2*$gst;
                    //$total_pay=$gst_total+$amount;
                  @endphp
            <td>RS {{number_format($gst,2)}}</td>
            <td>RS {{number_format($gst,2)}}</td>
            <td>RS {{number_format($amount,2)}}</td>
            
            @if(empty($status) && $order->status=='delivered')
                    <form method="post" action="{{ route('user.order.return',$product->id) }}">
                        @csrf
                        <td>
                        <div class="form-group">
                          <input name="r_quantity" type="number" min="1" size="9" placeholder="Enter Quantity">
                        </div>
                        @error('r_quantity')
                          <span class="text-danger">{{$message}}</span>
                        @enderror
                        </td>
                        <td>
                        <button class="btn-primary btn-sm float-left mr-1" >Return Product</button>
                        </td>
                    </form>
            @endif
            
        </tr>
      </tbody>
      
      @endforeach
    </table>

              <!--Returned product listing-->

        @php
        $product1=DB::table('products')->join('carts','products.id','=','carts.product_id')
                    ->select('products.title','carts.r_quantity','carts.price','carts.r_amount','carts.status','carts.id')
                    ->where([['carts.status','returned'],['carts.order_id',$order->id]])->get();
        @endphp 
    @if (count($product1)>0)
    <h3 class="text-center pb-4"><u>Returned Product Information</u></h3>
    <table class="table table-hover">   
      <thead>
        <tr>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>CGST</th>
            <th>SGST</th>
            <th>Sub Total</th> 
        </tr>
      </thead>
      <tbody>
        @foreach ($product1 as $product1)
        <tr>
            <td>{{$product1->title}}</td>
            <td>{{ $product1->r_quantity }}</td>
            <td>RS {{number_format($product1->price,2)}}</td>
                  @php
                    $amount=$product1->r_amount;
                    $gst=$amount*(6/100);
                    //$gst_total=2*$gst;
                    //$total_pay=$gst_total+$amount;
                  @endphp
            <td>RS {{number_format($gst,2)}}</td>
            <td>RS {{number_format($gst,2)}}</td>
            <td>RS {{number_format($amount,2)}}</td>
        </tr>
        @endforeach
      </tbody> 
    </table>
    @endif
    @endif
  </div>
</div>
@endsection

@push('styles')
<style>
    .order-info,.shipping-info{
        background:#ECECEC;
        padding:20px;
    }
    .order-info h4,.shipping-info h4{
        text-decoration: underline;
    }

</style>
@endpush
