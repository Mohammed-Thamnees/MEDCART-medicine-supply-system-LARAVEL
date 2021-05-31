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
                                    ->select('products.title','carts.quantity','carts.price','carts.amount')
                                    ->where([['carts.status','<>','returned'],['carts.order_id',$products->id]])->get();
                        //dd($product);
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

                <!--Returned product listing-->

                @php
                        $product1=DB::table('products')->join('carts','products.id','=','carts.product_id')
                                    ->select('products.title','carts.quantity','carts.price','carts.amount')
                                    ->where([['carts.status','returned'],['carts.order_id',$products->id]])->get();
                @endphp
                @foreach ($product1 as $product1)
                @if ($product1)
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
                    
                        <tr>

                            <td>{{$product1->title}}</td>
                            <td>{{ $product1->quantity }}</td>
                            <td>RS {{number_format($product1->price,2)}}</td>
                            @php
                                $amount=$product1->amount;
                                $gst=$amount*(6/100);
                                //$gst_total=2*$gst;
                                //$total_pay=$gst_total+$amount;
                            @endphp
                            <td>RS {{number_format($gst,2)}}</td>
                            <td>RS {{number_format($gst,2)}}</td>
                            <td>RS {{number_format($product1->amount,2)}}</td>

                        </tr>
                    
                    </tbody>
                </table>
                @endif
                @endforeach
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
