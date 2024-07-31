@extends('user.profile')
@section('content2')
    <style>
        .listing-img {
            width: 100px;
            height: 100px;
            border-radius: 0.5rem;
        }
    </style>
    <div class="row">
        <div class="col-md-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>Picture</th>
                        <th>Name</th>
                        <th>No. of Likes</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($liked_listings)
                        @foreach($liked_listings as $listing)
                            <tr>
                                <td><img src="{{ asset('storage/'.$listing->image_url) }}" class="listing-img" alt="Listing Image"></td>
                                <td>{{ $listing->name }}</td>
                                <td>{{ $listing->likes }}</td>
                                <td>{{ $listing->created_at }}</td>
                                <td>{{ $listing->updated_at }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" style="text-align: center;font-size: 20px;">No likes found &#9829;</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection