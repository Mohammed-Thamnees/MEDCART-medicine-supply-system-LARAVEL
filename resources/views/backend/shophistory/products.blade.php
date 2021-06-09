@extends('backend.layouts.master')

@section('title','Order Detail')

@section('main-content')
    <div class="card">
        <h5 class="card-header">Ordered Products Details</h5>
        <div class="card-body">
            @if($products)
            <h3 class="text-center pb-4"><u>Delivered Products Information</u></h3>
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
                                    ->select('products.title','carts.quantity','carts.r_quantity','carts.r_amount','carts.price','carts.amount')
                                    ->where('carts.order_id',$products->id)->whereRaw('(carts.quantity - carts.r_quantity)>0')->get();
                        //dd($product);
                    @endphp
                    @foreach ($product as $product)
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

                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <!--Returned product listing-->

                @php
                $product1=DB::table('products')->join('carts','products.id','=','carts.product_id')
                            ->select('products.title','carts.r_quantity','carts.price','carts.r_amount')
                            ->where([['carts.status','returned'],['carts.order_id',$products->id]])->get();
                @endphp
                @if (count($product1)>0)
                <h3 class="text-center pb-4"><u>Returned Products Information</u></h3>
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
