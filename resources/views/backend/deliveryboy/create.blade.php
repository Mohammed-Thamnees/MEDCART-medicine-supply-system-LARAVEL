@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Add Deliver Boy</h5>
    <div class="card-body">
      <form method="post" action="{{route('deliveryboys.store')}}">
        {{csrf_field()}}
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Name</label>
        <input id="inputTitle" type="text" name="name" placeholder="Enter name"  value="{{old('name')}}" class="form-control">
        @error('name')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
            <label for="inputPlace" class="col-form-label">Place</label>
          <input id="inputPlace" type="text" name="place" placeholder="Enter place"  value="{{old('place')}}" class="form-control">
          @error('place')
          <span class="text-danger">{{$message}}</span>
          @enderror
          </div>

          <div class="form-group">
            <label for="address" class="col-form-label">Address</label>
            <textarea class="form-control" id="address" name="address">{{old('address')}}</textarea>
            @error('address')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>


        <div class="form-group">
            <label for="inputEmail" class="col-form-label">Email</label>
          <input id="inputEmail" type="email" name="email" placeholder="Enter email"  value="{{old('email')}}" class="form-control">
          @error('email')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
            <label for="inputNumber" class="col-form-label">Phone Number</label>
          <input id="inputNumber" type="number" name="number" placeholder="Enter number"  value="{{old('number')}}" class="form-control">
          @error('number')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

          <div class="form-group">
            <label for="inputPin" class="col-form-label">Pin</label>
          <input id="inputPin" type="number" name="pin" placeholder="Enter pin"  value="{{old('pin')}}" class="form-control">
          @error('pin')
          <span class="text-danger">{{$message}}</span>
          @enderror
          </div>

          <div class="form-group">
            <label for="inputPost" class="col-form-label">Post Office</label>
          <input id="inputPin" type="text" name="post" placeholder="Enter post office"  value="{{old('post')}}" class="form-control">
          @error('post')
          <span class="text-danger">{{$message}}</span>
          @enderror
          </div>

        <div class="form-group">
            <label for="inputPassword" class="col-form-label">Password</label>
          <input id="inputPassword" type="password" name="password" placeholder="Enter password"  value="{{old('password')}}" class="form-control">
          @error('password')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
            <label for="inputPhoto" class="col-form-label">Photo </label>
            <div class="input-group">
                <span class="input-group-btn">
                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                    <i class="fa fa-picture-o"></i> Choose
                    </a>
                </span>
            <input id="thumbnail" class="form-control" type="text" name="photo" value="{{old('photo')}}">
          </div>
          <div id="holder" style="margin-top:15px;max-height:100px;"></div>
            @error('photo')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="status" class="col-form-label">Status</label>
            <select name="status" class="form-control">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
          @error('status')
          <span class="text-danger">{{$message}}</span>
          @enderror
          </div>
        <div class="form-group mb-3">
          <button type="reset" class="btn btn-warning">Reset</button>
           <button class="btn btn-success" type="submit">Submit</button>
        </div>
      </form>
    </div>
</div>

@endsection

@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
    $('#lfm').filemanager('image');
</script>
@endpush