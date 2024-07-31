@extends('components.layout')
@section('content')
<style>
    .card{
        margin-top: 20px;
    }
    .card-details{
        margin-top: 20px;
    }
    img{
        width: 200px;
        height: 200px;
        border-radius: 50%;
    }
    h1{
        margin-top: 20px;
    }
    p {
        font-size: 15px;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="{{ asset('images/user.jpg') }}" class="img-fluid"  alt="User Image">
                        </div>
                        <div class="col-md-9">
                            <h1 style="font-size: 50px;">{{ $user->name }}</h1>
                            <div class="card-details">
                                 <p><b>Email:</b> {{ $user->email }}</p>
                                 <p><b>Created At:</b> {{ $user->created_at }}</p>
                                 <p><b>Role:</b> <?php 
                                     if ($user->admin_id != null) {
                                         echo "Admin";
                                     } else {
                                         echo "User";
                                     }
                                 ?></p>
                                 <p><b>Updated At:</b> {{ $user->updated_at }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    @yield('content2')
</div>
@endsection