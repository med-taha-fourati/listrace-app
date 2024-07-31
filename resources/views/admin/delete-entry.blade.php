<!-- /listrace-app/resources/views/admin/delete-entry.blade.php -->
@extends('components.layout')
@section('content')
<div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 style="font-size: 40px;margin-bottom: 30px;">Entry List</h1>
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Short Description</th>
            <th>Long description</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Category</th>
            <th>Status</th>
            <th>Likes</th>
            <th>Location</th>
            <th>Price Min</th>
            <th>Price Max</th>

            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($entries as $entry)
        <tr>
            <td>{{ $entry->id }}</td>
            <td>{{ $entry->name }}</td>
            <td>{{ $entry['short-desc'] }}</td>
            <td>{{ Str::limit($entry['long-desc'], 30) }}</td>
            <td>{{ $entry->created_at }}</td>
            <td>{{ $entry->updated_at }}</td>
            <td><?php 
                foreach ($type as $t) {
                    if ($t->id == $entry->type) {
                        echo $t->type_name;
                    }
                }
            ?></td>
            <td><?php 
                if ($entry->status == 1) {
                    echo "Open now";
                } else {
                    echo "Closed now";
                }
            ?></td>
            <td>{{ $entry->likes }}</td>
            <td>{{ $entry->location }}</td>
            <td>{{ $entry['price-min'] }}</td>
            <td>{{ $entry['price-max'] }}</td>
            <td>
                <form action="{{ route('listing.destroy', $entry) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
            </div>
        </div>
    </div>
@endsection