@extends('deliveryboy.layouts.master')
@section('title','MEDCART || Delivery work')
@section('main-content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary float-left">Delivery Works</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                @if(count($work)>0)
                    <table class="table table-bordered" id="order-dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>S.N.</th>
                            <th>Order Number</th>
                            <th>Shop Name</th>
                            <th>Shop Place</th>
                            <th>Total Quantity</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($work as $work)
                            <tr>
                                <td>{{$loop->index +1}}</td>
                                <td>{{$work->order_number}}</td>
                                <td>{{$work->shop_name}}</td>
                                <td>{{$work->place}}</td>
                                <td>{{$work->quantity - $work->r_quantity}}</td>
                                <td>RS {{number_format($work->total_amount - $work->r_total_amount,2)}}</td>
                                <td>
                                    @if($work->status=='progress')
                                        <span class="badge badge-warning">{{$work->status}}</span>
                                    @elseif($work->status=='completed')
                                        <span class="badge badge-success">{{$work->status}}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('db.order',$work->id) }}" class="btn-sm btn-warning shadow-sm">Details</a>
                                    @if($work->status=='progress')
                                        <a href="{{route('db.status',$work->id)}}" class=" btn-sm btn-primary shadow-sm">Delivered</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <h6 class="text-center">No works found at the moment!!!</h6>
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
                    "targets":[6]
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
