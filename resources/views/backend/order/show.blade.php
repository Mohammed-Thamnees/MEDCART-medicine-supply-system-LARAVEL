@extends('backend.layouts.master')

@section('title','Order Detail')

@section('main-content')
<div class="card">
<h5 class="card-header">Order
  <!--<a href="{{route('order.pdf',$order->id)}}" class=" btn btn-sm btn-primary shadow-sm float-right"><i class="fas fa-download fa-sm text-white-50"></i> Generate PDF</a>
  <a href="javascript:window.print()" class="btn btn-sm btn-primary shadow-sm float-right"><i class="fas fa-download fa-sm text-white-50"></i>  Print Bill</a>-->
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
            <th>Total quantity</th>
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
                @if($order->status=='new')
                <a href="{{route('order.edit',$order->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                <br><br>
                @endif
                <form method="POST" action="{{route('order.destroy',[$order->id])}}">
                  @csrf
                  @method('delete')
                      <button class="btn btn-danger btn-sm dltBtn" data-id={{$order->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                </form>
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
                        <td>Total Ordered Quantity</td>
                        <td> : {{$order->quantity - $order->r_quantity}}</td>
                    </tr>
                    <tr>
                      <td>Total Returned Quantity</td>
                      <td> : {{$order->r_quantity}}</td>
                    </tr>
                    <tr>
                        <td>Total Ordered Amount</td>
                        <td> : RS {{number_format($order->total_amount - $order->r_total_amount,2)}}</td>
                    </tr>
                    <tr>
                      <td>Total Returned Amount</td>
                      <td> : RS {{number_format($order->r_total_amount,2)}}</td>
                    </tr>
                    <tr>
                      <td>Coupon</td>
                      <td> : RS {{number_format($order->coupon,2)}}</td>
                    </tr>
                    <tr>
                      <td>Order Status</td>
                      <td> : {{$order->status}}</td>
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
                    ->where('carts.order_id',$order->id)->whereRaw('(carts.quantity - carts.r_quantity)>0')->get();
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

    function deleteData(id){

    }

</style>
@endpush

@push('scripts')

    <!-- Page level plugins -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- Page level custom scripts -->
    <script>

        // Sweet alert

        function deleteData(id){

        }
    </script>
    <script>
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.dltBtn').click(function(e){
                var form=$(this).closest('form');
                var dataID=$(this).data('id');
                // alert(dataID);
                e.preventDefault();
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            form.submit();
                        } else {
                            swal("Your data is safe!");
                        }
                    });
            })
        })
    </script>
@endpush

