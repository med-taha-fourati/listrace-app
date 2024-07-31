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
                            <th>Original Post</th>
                            <th>Comment</th>
                            <th>Delete?</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($comments as $comment)
                            <tr>
                                <?php
                                    $original_post = App\Models\News::find($comment['original_post']);
                                ?>
                                <td>
                                    <a href="{{ route('main.comments', $original_post) }}">
                                    <?php
                                        echo $original_post->headline;
                                    ?></a>
                                </td>
                                <td>{{ $comment->comment }}</td>
                                <td>
                                    <form action="{{ route('comment.destroy', $comment) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
    </div>
@endsection