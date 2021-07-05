@extends('common')

@section('title', 'Log in!')

@section('content')



    <div class="row">
        <div class="offset-md-4 col-md-4 col-10 offset-1 mt-5">

        @if($info ?? '')
            <div class="alert alert-{{$info['type'] ?? 'success'}} alert-dismissible fade show" role="alert">
                <strong>{{$info['title'] ?? ''}}</strong> {{$info['desc'] ?? ''}}
            </div>
        @endif

            <form method="POST" action="{{url('/')}}">
                @csrf
                <input required name="login" type="text" placeholder="Login" class="form-control mb-3">
                <input required name="password" type="password" placeholder="password" class="form-control mb-3">
                <button type="submit" class="btn btn-primary input-block-level form-control">Log in!</button>
                <a class="link-success" href="{{url('register')}}">Register now!</a>
            </form>
        </div>
    </div>

@endsection