@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Edit User</h5>
    <div class="card-body">
      <form method="post" action="{{route('users.update',$user->id)}}">
        @csrf 
        @method('PATCH')
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Shop Name</label>
        <input id="inputTitle" disabled type="text" name="name" placeholder="Enter name"  value="{{$user->name}}" class="form-control">
        @error('name')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
          <label for="inputPlace" class="col-form-label">Place</label>
        <input id="inputPlace" disabled type="text" name="place" placeholder="Enter place"  value="{{$user->place}}" class="form-control">
        @error('place')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

          <div class="form-group">
            <label for="inputEmail" class="col-form-label">Email</label>
          <input id="inputEmail" disabled type="email" name="email" placeholder="Enter email"  value="{{$user->email}}" class="form-control">
          @error('email')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputNumber" class="col-form-label">Number</label>
        <input id="inputNumber" disabled type="number" name="number" placeholder="Enter number"  value="{{$user->number}}" class="form-control">
        @error('number')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
            <label for="inputPost" class="col-form-label">Post Office</label>
          <input id="inputPost" disabled type="text" name="post" placeholder="Enter post office"  value="{{$user->post}}" class="form-control">
          @error('post')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputPin" class="col-form-label">Pin</label>
        <input id="inputPin" disabled type="number" name="pin" placeholder="Enter pin"  value="{{$user->pin}}" class="form-control">
        @error('pin')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
          <label for="inputMark" class="col-form-label">Land Mark</label>
        <input id="inputMark" disabled type="text" name="mark" placeholder="Enter land mark"  value="{{$user->mark}}" class="form-control">
        @error('mark')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

       
        
        @php 
        $roles=DB::table('users')->select('role')->where('id',$user->id)->get();
        // dd($roles);
        //dd($user->status);
        @endphp
        <div class="form-group">
            <label for="role" class="col-form-label">Role</label>
            <select name="role" class="form-control" disabled>
                <option value="">-----Select Role-----</option>
                @foreach($roles as $role)
                    <option value="{{$role->role}}" {{(($role->role=='admin') ? 'selected' : '')}}>Admin</option>
                    <option value="{{$role->role}}" {{(($role->role=='user') ? 'selected' : '')}}>User</option>
                @endforeach
            </select>
          @error('role')
          <span class="text-danger">{{$message}}</span>
          @enderror
          </div>
          

         <div class="form-group">
            <label for="status" class="col-form-label">Status</label>
            <select name="status" class="form-control">
                //dd($user->status);
                <option value="active" {{(($user->status=='active') ? 'selected' : '')}}>Active</option>
                <option value="inactive" {{(($user->status=='inactive') ? 'selected' : '')}}>Inactive</option>
            </select>
          @error('status')
          <span class="text-danger">{{$message}}</span>
          @enderror
          </div>
        <div class="form-group mb-3">
           <button class="btn btn-success" type="submit">Approve</button>
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