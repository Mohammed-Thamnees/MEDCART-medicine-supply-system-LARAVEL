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

        </div>
        <div class="card-body">
            <div class="table-responsive">
                @if(count($work)>0)
                    <table class="table table-bordered" id="banner-dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>

                            <th>Order Number</th>
                            <th>Shop Name</th>
                            <th>Shop Address</th>
                            <th>Delivery Boy Name</th>
                            <th>Delivery Boy Number</th>
                            <th>Assigned Date</th>
                            <th>Status</th>
                        </tr>
                        </thead>

                        <tbody>



                                @php
                                $query=DB::table('delivery_boys')
                                        ->join('delivery_works','delivery_works.boy_id','=','delivery_boys.id')
                                        ->join('orders','orders.id','=','delivery_works.order_id')
                                        ->select('orders.order_number','orders.owner_name','orders.shop_name','orders.post','orders.pin','orders.mark','delivery_boys.name','delivery_boys.number','delivery_works.status','delivery_works.created_at')
                                        ->get();

                                //dd($query);
                                @endphp

                                @foreach($query as $query)

                             <tr>

                                <td>{{ $query->order_number }}</td>
                                <td>{{ $query->shop_name }}</td>
                                 <td> Owner Name : {{ $query->owner_name }}<br> Post : {{ $query->post }} <br>Pin : {{ $query->pin }} <br>Land Mark : {{ $query->mark }}</td>
                                <td>{{ $query->name }}</td>
                                <td>{{ $query->number }}</td>
                                <td>{{$query->created_at}}</td>
                                <td>
                                    @if($query->status=='progress')
                                        <span class="badge badge-warning">{{$query->status}}</span>
                                    @elseif($query->status=='delivered')
                                        <span class="badge badge-success">{{$query->status}}</span>
                                    @endif
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
                    "targets":[3,4,5]
                }
            ]
        } );

    </script>

@endpush
