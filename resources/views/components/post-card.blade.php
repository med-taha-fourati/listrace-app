<style>
    .post {
        border: 1px solid #ccc;
        border-radius: 5px;
        margin: 10px;
        padding: 10px;
        background-color: #f9f9f9;
        transition: all 0.3s;
        margin: 15px 100px;
    }

    .post:hover {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        background-color: #fafafa;
    }

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

    .post-image {
        width: 100%;
        height: auto;
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
</style>

<div class="post">
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
    <div class="post-content">
        <h2 class="post-headline">{{ $post['headline'] }}</h2>
        <div class="post-content-text">
            <p class="post-text{{$post['id']}}">{{ $post['content'] }}</p>
        </div>
    
        @if ($post['image_url'] != null)
            <img class="post-picture" src="{{ asset('storage/posts/'.$post->image_url) }}" alt="Post Picture">
        @endif

        <hr>
        @auth
        <form action="{{ route('comments.store', $post) }}" method="POST">
        <div class="post-comment-form">
            
                <div class="form-group">
                    <img src="{{ asset('images/user.jpg') }}" alt="" class="comment-author-img">
                </div>
                @csrf
                @method('POST')
                
                <input type="hidden" name="post_id" value="{{ $post['id'] }}">
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                <div class="form-group">
                    <textarea name="content" class="form-control" id="content" cols="90" rows="1" placeholder="Write a comment..."></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Comment</button>
                </div>
                
        </div>
        </form>
        <a href="{{ route('main.comments', $post) }}">View all comments</a>
        @endauth
        @guest
        <div class="post-comment-form">
            <div class="form-group">
                <p>You must be logged in in order to comment on this news post. <a href="{{ route('auth.login') }}" style="color: lightblue;">Log in?</a></p>
            </div>
        </div>
        @endguest
    </div>
</div>

<script>
    // do the 'see more' logic here
    var lengthLimit = 200;
    $(document).ready(function() {
        var postText = $('.post-text{{$post->id}}').text();
        if (postText.length > lengthLimit) {
            var shortText = postText.substring(0, lengthLimit);
            var longText = postText.substring(lengthLimit, postText.length);
            $('.post-text{{$post->id}}').html(shortText + '<span class="more-text{{$post->id}}" style="display: none;">' + longText + '</span><button style="font-size: 15px;font-weight: bold;color:light-blue;" class="more-link{{$post->id}}">..see more</button>');
        }

        $('.more-link{{$post->id}}').click(function() {
            $('.more-text{{$post->id}}').show();
            $(this).hide();
        });
    });
</script>