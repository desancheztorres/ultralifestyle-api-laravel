@extends('app')

@section('title', 'Reset Password')

@section('content')
    <div class="col-2"></div>
    <div class="col-8 text-center">
        <form method="POST" action="{{route('reset')}}">
            @csrf
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm password" required>
            </div>
            <input type="hidden" class="form-control" id="token" name="token" value="{{$token}}">
            <input type="hidden" class="form-control" id="email" name="email" value="{{$email}}">
            <button type="submit" class="btn btn-primary">Reset Password</button>
        </form>
    </div>
    <div class="col-2"></div>
@endsection
