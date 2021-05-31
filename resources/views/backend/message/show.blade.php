@extends('backend.layouts.master')
@section('main-content')
<div class="card">
  <h5 class="card-header">Message</h5>
  <div class="card-body">
    @if($message)
        @php
            $user=DB::table('messages')->join('users','messages.user_id','=','users.id')
                            ->select('users.name','users.owner_name','users.number','users.place','users.email','messages.created_at','messages.updated_at')
                            ->where('messages.id',$message->id)->get();
        @endphp
      @foreach($user as $user)
          <div class="py-4"><h5>From Address</h5><br>
              <b>Shop Name        :    </b>{{$user->name}}<br>
              <b>Owner Name       :    </b>{{$user->owner_name}}<br>
              <b>Email            :    </b>{{$user->email}}<br>
              <b>Phone            :    </b>{{$user->number}}<br>
              <b>Place            :    </b>{{$user->place}}<br>
              <b>Date            :    </b>{{Carbon\Carbon::parse($user->created_at)->format('d/m/Y')}}
        </div>
        <hr/>
      @endforeach
  <h5 class="text-center" style="text-decoration:underline"><strong>Subject :</strong> {{$message->subject}}</h5>
        <p class="py-5">{{$message->message}}</p>



      @if($message->reply)
              <br><br><br><u><h5> Message Replied On {{ $message->updated_at->format('d/m/Y') }}</h5></u>
          <p>{{$message->reply}}</p>
      @else
        <div class="form-group mb-3">
            <form method="post" action="{{route('message.edit',$message->id)}}">
                @csrf
                @method('GET')
            <button class="btn btn-success" type="">Reply</button>
            </form>
        </div>
      @endif
    @endif

  </div>
</div>
@endsection
