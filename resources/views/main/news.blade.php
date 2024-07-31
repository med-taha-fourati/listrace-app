@extends('components.layout')
@section('content')

<!-- foreach listing show it here -->
<style>
    .explore-content {
        padding: 5px 0;
    }
    .explore-banner {
        margin-bottom: 20px;
    }
</style>
<div class="explore-content">
    <div class="row">
        
        <!-- filter -->
        <!--<div class="col-md-12">
            <a href="{{ route('main.listings') }}" class="btn btn-primary" style="text-decoration: none;">All</a>
            <a href="{{ route('main.listings', ['type' => 1]) }}" class="btn btn-primary">Hotel</a>
            <a href="{{ route('main.listings', ['type' => 2]) }}" class="btn btn-primary">Restaurant</a>
        </div>-->
            <div class="explore-banner" style="text-align: center;">
                <h1 style="font-size: 50px;">News</h1>
                <p style="font-size: 30px;">Stay up to date with the latest topics</p>
            </div>
            <div class="container">
                <h1 style="font-size: 20px;text-align:center;">Make a new post:</h1>
                @include('components.new-post')
            </div>
            @if ($news->count() != 0)
            <div class="container">
                <hr>
                @foreach($news as $post)
                    @include('components.post-card', [
                        'post' => $post,
                        'users' => $users,
                    ])
                @endforeach
            </div>
            @else
            <div class="container">
                <hr>
                <h5 style="text-align: center;">No news currently available :c</h5>
                <p style="text-align: center;">Check back later for more news</p>
            </div>
            @endif
            <!--<div class="container">
                
            </div>-->
    </div>
</div>

@endsection