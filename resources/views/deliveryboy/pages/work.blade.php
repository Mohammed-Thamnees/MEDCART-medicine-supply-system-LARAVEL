@extends('deliveryboy.layouts.master')
@section('title','MEDCART || Ordered Product')
@section('main-content')
    <div class="card">
        <h5 class="card-header">Ordered Product</h5>
        <div class="card-body">
            @if($order)
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Order No.</th>
                        <th>Shop Name</th>
                        <th>Owner Name</th>
                        <th>Email</th>
                        <th>Total quantity of products</th>
                        <th>Total Amount</th>
                        <th>Payment Status</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{$order->order_number}}</td>
                        <td>{{$order->shop_name}}</td>
                        <td>{{$order->owner_name}}</td>
                        <td>{{$order->email}}</td>
                        <td align="center">{{$order->quantity}}</td>
                        <td>RS {{number_format($order->total_amount,2)}}</td>
                        <td>
                            @if($order->payment_status=='paid')
                                <span class="badge badge-success">{{$order->payment_status}}</span>
                            @elseif($order->payment_status=='unpaid')
                                <span class="badge badge-danger">{{$order->payment_status}}</span>
                            @endif
                        </td>
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
                        <td>
                            @if($order->status=='process')
                                <a href="{{route('db.status',$order->id)}}" class=" btn-sm btn-primary shadow-sm">Delivered</a>
                            @else
                                Order Delivered
                            @endif
                        </td>

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
                                            <td>Total quantity of products</td>
                                            <td> : {{$order->quantity}}</td>
                                        </tr>
                                        <tr>
                                            <td>Coupon</td>
                                            <td> : RS {{number_format($order->coupon,2)}}</td>
                                        </tr>
                                        <tr>
                                            <td>Total Amount</td>
                                            <td> : RS {{number_format($order->total_amount,2)}}</td>
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
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <br><br>

                <h3 class="text-center pb-4"><u>Ordered Product Information</u></h3>
                <table class="table table-striped table-hover">

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
                    @php
                        $product=DB::table('products')->join('carts','products.id','=','carts.product_id')
                                    ->select('products.title','carts.quantity','carts.price','carts.amount')
                                    ->where('carts.order_id','=',$order->id)->get();
                    @endphp
                    @foreach ($product as $product)
                        <tr>

                            <td>{{$product->title}}</td>
                            <td>{{ $product->quantity }}</td>
                            <td>RS {{number_format($product->price,2)}}</td>
                            @php
                                $amount=$product->amount;
                                $gst=$amount*(6/100);
                                //$gst_total=2*$gst;
                                //$total_pay=$gst_total+$amount;
                            @endphp
                            <td>RS {{number_format($gst,2)}}</td>
                            <td>RS {{number_format($gst,2)}}</td>
                            <td>RS {{number_format($product->amount,2)}}</td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>



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
