@extends('user.profile')
@section('content2')
    <style>
        .listing-img {
            width: 100px;
            height: 100px;
            border-radius: 0.5rem;
        }
        img {
            object-fit: cover;
        }
    </style>
    <div class="row">
        <div class="col-md-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>Picture</th>
                        <th>Headline</th>
                        <th>Contents</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($own_posts_ids)
                        @foreach($own_posts_ids as $listing)
                            <tr>
                                @if ($listing->image_url == null)
                                    <td>pictures not available</td>
                                @else
                                    <td><img src="{{ asset('storage/posts/'.$listing->image_url) }}" class="listing-img" alt="Listing Image"></td>
                                @endif
                                <td>{{ $listing->headline }}</td>
                                <td>{{ Str::limit($listing->content, 40) }}</td>
                                <td>{{ $listing->created_at }}</td>
                                <td>{{ $listing->updated_at }}</td>
                                <td>
                                    <form action="{{ route('delete.post', $listing->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
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