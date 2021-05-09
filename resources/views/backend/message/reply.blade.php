@extends('backend.layouts.master')
@section('main-content')
    <div class="card">
        <h5 class="card-header">Message Reply</h5>
        <div class="card-body">
            @if($message)
                @php
                    $user=DB::table('messages')->join('users','messages.user_id','=','users.id')
                                    ->select('users.name','users.owner_name','users.number','users.place','users.email')->where('messages.id',$message->id)->get();
                @endphp
                @foreach($user as $user)
                    <div class="py-4"><h5>Reply To</h5><br>
                        <b>Shop Name        :    </b>{{$user->name}}<br>
                        <b>Owner Name       :    </b>{{$user->owner_name}}<br>
                        <b>Email            :    </b>{{$user->email}}<br>
                        <b>Phone            :    </b>{{$user->number}}<br>
                        <b>Place            :    </b>{{$user->place}}
                    </div>
                    <hr/>
                @endforeach

                <form class="form-contact form contact_form" method="post" action="{{route('message.update',$message->id)}}" id="contactForm" novalidate="novalidate">
                    @csrf
                    @method('PATCH')
                        <div class="form-group">
                            <label for="inputreply" class="col-form-label">your reply<span class="text-danger">*</span></label>
                            <textarea class="form-control" id="reply" name="reply" rows="10">{{old('reply')}}</textarea>
                            @error('reply')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>


                        <div class="form-group mb-3">
                            <button class="btn btn-success" type="submit">Send Reply</button>
                        </div>

                </form>
            @endif
        </div>
    </div>
@endsection
