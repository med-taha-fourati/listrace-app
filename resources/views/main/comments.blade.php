@extends('components.layout')

@section('content')
<style>
    .post-header {
        height: 30px;
        padding: 20px;
        display: flex;
        justify-content: space-between;
    }

    .post-content {
        padding: 20px;
        height: auto;
    }

    .post-content-text {
        padding: 10px 0;
    }

    .comments-page {
        margin-top: 20px;
        padding: 50px;
    }

    .comment-author-img {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        margin-right: 10px;
    }

    .post-comment-form {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .post-comment-form > .form-group > #content {
        min-width: 100%;
        box-decoration-break: clone;
        border-radius: 50px;
        background-color: #f9f9f9;
        border: 1px solid #ccc;
    }

    .post-picture {
        width: 100%;
        height: auto; /* Maintain aspect ratio */
    }

    .row {
        display: flex; /* Use flexbox for layout */
        align-items: flex-start;
    }

    .vertical-bar {
        border: 1px #ccc solid; /* Add a vertical bar */
        width: 2px; /* Adjust the width of the vertical bar */
        background-color: #ccc; /* Adjust the color of the vertical bar */
        height: 100%; /* Make the bar full height of its container */
        margin: 0 20px; /* Space between columns and bar */
    }

    .post-content, .comment-section {
        padding: 20px; /* Add padding if needed */
    }

    .post-headline {
        font-size: xx-large;
        margin-bottom: 20px;
    }

    .comment {
        margin-bottom: 20px;
    }

    .comment-header {
        display: flex;
        justify-content: flex-start;
        align-items: center;
    }

    .comment-container {
        margin-right: 10px;
    }
</style>

<div class="comments-page">
    <div class="row">
        <div class="col-md-8 post-content">
            <div class="post-header">
                <div class="post-author">From: <i><?php 
                    foreach ($users as $user) {
                        if ($user['id'] == $post['author']) {
                            if ($user['admin_id'] != null) {
                                echo $user['name'] . " (Admin)";
                            } else {
                                echo $user['name'];
                            }
                        }
                    }
                ?></i></div>
                <div class="post-date">Date: <i>{{ $post['created_at'] }}</i></div>
            </div>
            <div class="post-content-text">
                <h2 class="post-headline">{{ $post['headline'] }}</h2>
                <p class="post-text{{$post['id']}}">{{ $post['content'] }}</p>
                
                @if ($post['image_url'] != null)
                    <img class="post-picture" src="{{ asset('storage/posts/'.$post->image_url) }}" alt="Post Picture">
                @endif
            </div>
        </div>

        <div class="vertical-bar"></div> <!-- Vertical bar div -->

        <div class="col-md-4 comment-section">
            <form action="{{ route('comments.store', $post) }}" method="POST">
                <div class="post-comment-form">
                    <div class="form-group">
                        <img src="{{ asset('images/user.jpg') }}" alt="" class="comment-author-img">
                    </div>
                    @csrf
                    @method('POST')
                    
                    <input type="hidden" name="post_id" value="{{ $post['id'] }}">
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <div class="form-group">
                        <textarea name="content" class="form-control" id="content" cols="90" rows="1" placeholder="Write a comment..."></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Comment</button>
                    </div>
                </div>
            </form>
            <hr>
            <div class="comments">
                @foreach ($comments as $comment)
                    <div class="comment">
                        <div class="comment-header">
                            <div class="comment-container">
                                <img src="{{ asset('images/user.jpg') }}" alt="" class="comment-author-img">
                            </div>
                            <div class="comment-container">
                                <div class="comment-author">

                                    From: <i><?php 

                                    foreach ($users as $user) {
                                        if ($user['id'] == $comment['comment_author']) {
                                            if ($user['admin_id'] != null) {
                                                echo $user['name'] . " (Admin)";
                                            } else {
                                                echo $user['name'];
                                            }
                                        }
                                    }
                                ?></i></div>
                            </div>
                            <div class="comment-container">
                                <div class="comment-date">Date: <i>{{ $comment['created_at'] }}</i></div>
                            </div>
                        </div>
                        <div class="comment-content">
                            <p>{{ $comment['comment'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div> 
</div>
@endsection
