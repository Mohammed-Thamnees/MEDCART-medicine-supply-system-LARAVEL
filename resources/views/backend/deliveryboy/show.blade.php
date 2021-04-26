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
      <h6 class="m-0 font-weight-bold text-primary float-left">Delivery Boy View</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table" width="100%" cellspacing="0">
        @if($boy)
            <tr>
                <th>Photo</th>
                <td>
                    @if($boy->photo)
                        <img src="{{$boy->photo}}" class="img-fluid" style="max-width:80px" alt="{{$boy->photo}}">
                    @else
                        <img src="{{asset('backend/img/thumbnail-default.jpg')}}" class="img-fluid" style="max-width:80px" alt="avatar.png">
                    @endif
                </td>
            </tr>
            
            <tr>
                <th>Name</th>
                <td>{{ $boy->name }}</td>
            </tr>
            <tr>
                <th>Place</th>
                <td>{{ $boy->place }}</td>
            </tr>
            <tr>
                <th>Address</th>
                <td>{!! $boy->address !!}</td>
            </tr>
            <tr>
                <th>Post office</th>
                <td>{{ $boy->post }}</td>
            </tr>
            <tr>
                <th>Pin</th>
                <td>{{ $boy->pin }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $boy->email }}</td>
            </tr>
            <tr>
                <th>Number</th>
                <td>{{ $boy->number }}</td>
            </tr>
            <tr>
                <th>Join Date</th>
                <td>{{ $boy->created_at->format('D d M, Y')}} at {{$boy->created_at->format('g : i a') }}</td>
            </tr>

        @else
        <h6 class="text-center">No delivery boys found!!!</h6>
        @endif
        </table>

      </div>
    </div>
</div>
@endsection


