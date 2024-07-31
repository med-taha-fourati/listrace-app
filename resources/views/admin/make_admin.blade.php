@extends('components.layout')
@section('content')
<div class="container">
        <div class="row">
            <div class="col-md-12">
    <h1 style="font-size: 40px;margin-bottom: 30px;">Make admin</h1>
    <table class="table">
        <thead>
        <tr>
            <th>Name</td>
            <th>Email</td>
            <!--<th>Password</td>-->
            <th>Make admin?</td>
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            @if ($user['admin_id'] == null)
            <form action="{{ route('admin.make', $user) }}" method="post">
                @csrf
                @method("PUT")
                <tr id="{{ $user['id'] }}">
                    <td>{{ $user['name'] }}</td>
                    <td>{{ $user['email'] }}</td>
                    <!--<td>{{ $user['password'] }}</td>-->
                    <td><button class="btn btn-primary" type="submit">Make admin</button></td>
                </tr>
            </form>
            @endif
        @endforeach
        </tbody>
    </table>
    </div>
    </div>
    </div>
@endsection