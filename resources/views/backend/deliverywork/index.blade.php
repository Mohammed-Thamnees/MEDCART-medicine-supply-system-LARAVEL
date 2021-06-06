@extends('backend.layouts.master')

@section('main-content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row">
            <div class="col-md-12">
                @include('backend.layouts.notification')
            </div>
        </div>
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary float-left">Delivery Work Details</h6>
            {{-- <a href="{{ route('work') }}" class=" btn btn-sm btn-primary shadow-sm float-right"><i class="fas fa-sm text-white-50"></i> View Delivery Work List</a> --}}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                @if(count($order)>0)
                    <table class="table table-bordered" id="banner-dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>S.N.</th>
                            <th>Order Number</th>
                            <th>Shop Name</th>
                            <th>Shop Owner</th>
                            <th>Shop Address</th>
                            <th>Place</th>
                            <th>Order Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($order as $order)
                             <tr>
                                <td>{{ $loop->index +1 }}</td>
                                <td>{{ $order->order_number }}</td>
                                <td>{{ $order->shop_name }}</td>
                                <td>{{ $order->owner_name }}</td>
                                <td> Post : {{ $order->post }} <br>Pin : {{ $order->pin }} <br>Land Mark : {{ $order->mark }}</td>

                                <td>{{ $order->place }}</td>
                                <td>{{Carbon\Carbon::parse($order->created_at)->format('d/m/Y')}}</td>
                                <td>
                                    <a href="{{route('deliveryworks.show',$order->id)}}" class=" btn btn-sm btn-primary shadow-sm">Delivery Boy Assign</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                @else
                    <h6 class="text-center">No delivery works found!!!</h6>
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

        $('#banner-dataTable').DataTable( {
            "columnDefs":[
                {
                    "orderable":false,
                    "targets":[4,5,6]
                }
            ]
        } );

    </script>

@endpush
