@extends('deliveryboy.layouts.master')
@section('title','MEDCART || Ordered Product')
@section('main-content')
    <div class="card">
        <h5 class="card-header">Returned Product</h5>
        <div class="card-body">
            @if($order)
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
                                            <td>Total Quantity</td>
                                            <td> : {{$order->r_quantity}}</td>
                                        </tr>

                                        <tr>
                                            <td>Total Amount</td>
                                            <td> : {{$order->r_total_amount}}</td>
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

                <h3 class="text-center pb-4"><u>Returned Product Information</u></h3>
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
                                    ->select('products.title','carts.r_quantity','carts.price','carts.r_amount')
                                    ->where([['carts.order_id',$order->id],['carts.status','<>','new']])->get();
                    @endphp
                    @foreach ($product as $product)
                        <tr>

                            <td>{{$product->title}}</td>
                            <td>{{ $product->r_quantity }}</td>
                            <td>RS {{number_format($product->price,2)}}</td>
                            @php
                                $amount=$product->r_amount;
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
