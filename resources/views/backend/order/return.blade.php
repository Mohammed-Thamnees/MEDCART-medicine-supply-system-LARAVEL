@extends('backend.layouts.master')

@section('title','returned order')

@section('main-content')
    <div class="card">
        <h5 class="card-header">Returned Order</h5>
        <div class="card-body">
            @if($cart)
                <h3 class="text-center pb-4"><u>Returned Order</u></h3>
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
                    @foreach ($cart as $cart)
                        <tr>

                            <td>{{$cart->title}}</td>
                            <td>{{ $cart->quantity }}</td>
                            <td>RS {{number_format($cart->price,2)}}</td>
                            @php
                                $amount=$cart->amount;
                                $gst=$amount*(6/100);
                                //$gst_total=2*$gst;
                                //$total_pay=$gst_total+$amount;
                            @endphp
                            <td>RS {{number_format($gst,2)}}</td>
                            <td>RS {{number_format($gst,2)}}</td>
                            <td>RS {{number_format($cart->amount,2)}}</td>
                        </tr>
                    @endforeach
                        <tr>
                            <td colspan="6" align="center">
                                @if(empty($boy))
                                    <a href="{{ route('return.boys',$cart->order_id) }}" class="btn btn-sm btn-success shadow-sm" style="height:35px; width:180px;"><h5>Arrange Pickup</h5></a>
                                @else
                                    <h5 class="btn-danger">Pickup already assigned |OR| Order already returned</h5>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            @else
                <h6 class="text-center">No returned orders found!!!</h6>
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
