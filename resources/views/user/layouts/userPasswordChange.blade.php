@extends('user.layouts.master')
@section('main-content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Change Password</div>
   
                <div class="card-body">
                    <form method="POST" action="{{ route('change.password') }}">
                        @csrf   
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Current Password<span class="text-danger">*</span></label>
  
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="current_password" autocomplete="current-password">
                            @error('current_password')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                            </div>
                        </div>
  
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">New Password<span class="text-danger">*</span></label>
  
                            <div class="col-md-6">
                                <input id="new_password" type="password" class="form-control" name="new_password" autocomplete="current-password">
                            @error('new_password')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                            <br><span style="color:rgb(150, 140, 140)">Your password must be minimum 8 characters long, Should contain atleast 1 Uppercase, 1 Lowecase, 1 Numeric and 1 Special character.</span>
                            </div>
                        </div>
  
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">New Confirm Password<span class="text-danger">*</span></label>
    
                            <div class="col-md-6">
                                <input id="new_confirm_password" type="password" class="form-control" name="new_confirm_password" autocomplete="current-password">
                            @error('new_confirm_password')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                            </div>
                        </div>
   
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Update Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection