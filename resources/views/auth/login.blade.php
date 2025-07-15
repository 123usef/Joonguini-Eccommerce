@extends('Layout.Base')


@section('content')
<div class="bg-dark text-white w-50 mx-auto mt-5 rounded-3 p-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1>Login</h1>
            </div>
        </div>
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <form action="{{ route('login.post') }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" name = "email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" name = "password" class="form-control" id="exampleInputPassword1">
            </div>
            
            <button type="submit" class="btn btn-primary">Submit</button>
</form>
    </div>
</div>
@endsection