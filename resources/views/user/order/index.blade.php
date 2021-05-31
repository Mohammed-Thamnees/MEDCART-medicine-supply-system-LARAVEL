@extends('frontend.layouts.master')

@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary float-left">Order Lists</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($orders)>0)
        <table class="table table-bordered" id="order-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>S.N.</th>
              <th>Order No.</th>
              <th>Total quantity of products</th>
              <th>Total Amount</th>
              <th>Order Date</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>

          <tbody>
            @foreach($orders as $order)
            @php
                $shipping_charge=DB::table('shippings')->where('id',$order->shipping_id)->pluck('price');
            @endphp
                <tr>
                    <td>{{$loop->index +1}}</td>
                    <td>{{$order->order_number}}</td>
                    <td align="center">{{$order->quantity}}</td>
                    <td>RS {{number_format($order->total_amount,2)}}</td>
                    <td>{{$order->created_at->format('d/m/Y')}}</td>
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
                        <a href="{{route('user.order.show',$order->id)}}" class="btn-warning btn-sm float-left mr-1" style="height:20px; width:20px;border-radius:50%" data-toggle="tooltip" title="view" data-placement="bottom"><i class="fas fa-eye"></i></a>

                    </td>
                </tr>
            @endforeach
          </tbody>
        </table>
        <span style="float:right">{{$orders->links()}}</span>
        @else
          <h6 class="text-center">No orders found!!! Please order some products</h6>
        @endif
      </div>
    </div>
</div>
@endsection

@push('styles')
  <link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
  <style>
      div.dataTables_wrapper div.dataTables_paginate{
          display: none;
      }
  </style>
@endpush

@push('scripts')

  <!-- Page level plugins -->
  <script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
  <script>

      $('#order-dataTable').DataTable( {
            "columnDefs":[
                {
                    "orderable":false,
                    "targets":[5]
                }
            ]
        } );

        // Sweet alert

  </script>
  <script>
      $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
      })
  </script>
@endpush
