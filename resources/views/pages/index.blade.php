@extends('layouts.app')

@section('content')
    <!--@guest
        <h1>Welcome to SSM</h1>
        <p>Simplified Social Media Home</p>
    @endguest
    @auth
        <h1>Welcome {{ Auth::user()->name }} </h1>
    @endauth-->
    @auth
    @include('includes.dashboard')
    @endauth
    
    
    @guest
    <div class="row">
        <div class="col-md-6">
            <h2>Simple Social Media Feed</h2>
        </div>
        <div class="col-md-offset-1 col-md-5">
            <h3>Don't have an account? Register Now!</h3>
            <form action="{{ route('register') }}" Method="POST">
                {{ csrf_field() }}
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <input class="form-control" type="text" name="name" id="name" placeholder="Name" value="{{Request::old('name')}}" required>
                </div>
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <input class="form-control" type="email" name="email" id="email-signup" placeholder="Email" value="{{Request::old('email')}}" required>
                </div>
                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    <input class="form-control" type="password" name="password" id="password-signup" placeholder="Password" required>
                </div>
                <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Re-enter Password" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    @endguest
@endsection