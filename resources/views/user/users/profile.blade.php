@extends('frontend.layouts.master')

@section('title','User Profile')

@section('main-content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
     <h4 class=" font-weight-bold">Profile</h4>
   </div>
   <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="image">
                        @if($profile->photo)
                        <img class="card-img-top img-fluid roundend-circle mt-4" style="border-radius:50%;height:80px;width:80px;margin:auto;" src="{{$profile->photo}}" alt="profile picture">
                        @else
                        <img class="card-img-top img-fluid roundend-circle mt-4" style="border-radius:50%;height:80px;width:80px;margin:auto;" src="{{asset('backend/img/avatar.png')}}" alt="profile picture">
                        @endif
                    </div>
                    <div class="card-body mt-4 ml-2">
                      <h5 class="card-title text-left"><small><i class="fas fa-user"></i> {{$profile->name}}</small></h5>
                      <p class="card-text text-left"><small><i class="fas fa-envelope"></i> {{$profile->email}}</small></p>
                      <p class="card-text text-left"><small class="text-muted"><i class="fas fa-hammer"></i> {{$profile->role}}</small></p>
                    </div>
                  </div>
            </div>
            <div class="col-md-8">
                <form class="border px-4 pt-2 pb-3" method="POST" action="{{route('user-profile-update',$profile->id)}}">
                    @csrf
                      <div class="form-group">
                        <label for="inputTitle" class="col-form-label">Shop Name<span class="text-danger">*</span></label>
                      <input id="inputTitle" type="text" name="name" placeholder="Enter name"  value="{{$profile->name}}" class="form-control">
                      @error('name')
                      <span class="text-danger">{{$message}}</span>
                      @enderror
                      </div>

                      <div class="form-group">
                        <label for="inputTitle" class="col-form-label">Owner Name<span class="text-danger">*</span></label>
                      <input id="inputTitle" type="text" name="owner_name" placeholder="Enter owner name"  value="{{$profile->owner_name}}" class="form-control">
                      @error('owner_name')
                      <span class="text-danger">{{$message}}</span>
                      @enderror
                      </div>

                      <div class="form-group">
                        <label for="inputPlace" class="col-form-label">Place<span class="text-danger">*</span></label>
                      <input id="inputPlace" type="text" name="place" placeholder="Enter place"  value="{{$profile->place}}" class="form-control">
                      @error('place')
                      <span class="text-danger">{{$message}}</span>
                      @enderror
                      </div>

                      <div class="form-group">
                          <label for="inputEmail" class="col-form-label">Email<span class="text-danger">*</span></label>
                        <input id="inputEmail" disabled type="email" name="email" placeholder="Enter email"  value="{{$profile->email}}" class="form-control">
                        @error('email')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                      </div>

                      <div class="form-group">
                        <label for="inputNumber" class="col-form-label">Phone Number<span class="text-danger">*</span></label>
                      <input id="inputNumber" type="number" name="number" placeholder="Enter phone number"  value="{{$profile->number}}" class="form-control">
                      @error('number')
                      <span class="text-danger">{{$message}}</span>
                      @enderror
                      </div>

                      <div class="form-group">
                        <label for="inputPost" class="col-form-label">Post Office<span class="text-danger">*</span></label>
                      <input id="inputPost" type="text" name="post" placeholder="Enter post office"  value="{{$profile->post}}" class="form-control">
                      @error('post')
                      <span class="text-danger">{{$message}}</span>
                      @enderror
                      </div>

                      <div class="form-group">
                        <label for="inputPin" class="col-form-label">Pin<span class="text-danger">*</span></label>
                      <input id="inputPin" type="number" name="pin" placeholder="Enter pin"  value="{{$profile->pin}}" class="form-control">
                      @error('pin')
                      <span class="text-danger">{{$message}}</span>
                      @enderror
                      </div>

                      <div class="form-group">
                        <label for="inputMark" class="col-form-label">Land Mark<span class="text-danger">*</span></label>
                      <input id="inputMark" type="text" name="mark" placeholder="Enter land mark"  value="{{$profile->mark}}" class="form-control">
                      @error('mark')
                      <span class="text-danger">{{$message}}</span>
                      @enderror
                      </div>

                      <div class="form-group">
                      <label for="inputPhoto" class="col-form-label">Photo</label>
                      <div class="input-group">
                          <span class="input-group-btn">
                              <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                              <i class="fa fa-picture-o"></i>Choose
                              </a>
                          </span>
                          <input id="thumbnail" class="form-control" type="text" name="photo" value="{{$profile->photo}}">
                      </div>
                        @error('photo')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                      </div>

                        <button type="submit" class="btn btn-success btn-sm">Update</button>
                </form>
            </div>
        </div>
   </div>
</div>

@endsection

<style>
    .breadcrumbs{
        list-style: none;
    }
    .breadcrumbs li{
        float:left;
        margin-right:10px;
    }
    .breadcrumbs li a:hover{
        text-decoration: none;
    }
    .breadcrumbs li .active{
        color:red;
    }
    .breadcrumbs li+li:before{
      content:"/\00a0";
    }
    .image{
        background:url('{{asset('backend/img/background.jpg')}}');
        height:150px;
        background-position:center;
        background-attachment:cover;
        position: relative;
    }
    .image img{
        position: absolute;
        top:55%;
        left:35%;
        margin-top:30%;
    }
    i{
        font-size: 14px;
        padding-right:8px;
    }
  </style>

@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
    $('#lfm').filemanager('image');
</script>
@endpush
