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
            <h6 class="m-0 font-weight-bold text-primary float-left">Pickup Work Assign</h6>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                @if(count($boy)>0)
                    <table class="table table-bordered" id="banner-dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>S.N.</th>
                            <th>Delivery Boy Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Place</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($boy as $boy)
                            <tr>
                                <td>{{ $loop->index +1 }}</td>
                                <td>{{ $boy->name }}</td>
                                <td>{{ $boy->email }}</td>
                                <td>{{ $boy->number }}</td>
                                <td>{{ $boy->place }}</td>
                                <td>
                                    <a href="{{route('return.assign',[ $boy->id, $order->id ])}}" class=" btn btn-sm btn-primary shadow-sm">Assign</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                @else
                    <h6 class="text-center">No delivery boys found. Register first!!!</h6>
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
