@extends('components.layout')
@section('content')
<style>
    .image-display {
        width: 100%;
        max-height: auto;
    }

    .title {
        margin: 20px 0;
        display: flex;
        justify-content: start;
        align-items: center;
    }
    
    .review-cards {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
    }

    .review-card {
        width: 30%; 
        margin: 10px; 
        padding: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .review-section {
        margin-top: 50px;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">
           <div class="card">
                <div class="card-header">
                    <div class="title">
                        <a style="font-size: 40px;margin-right: 10px;" href="{{ url()->previous() }}">&#8617;</i></a>
                        <h1 style="font-size: 40px;">{{ $listing['name'] }}</h1>
                    </div>
                </div>
                <div class="card-body">
                 <div class="col-md-6">
                      <img src="{{ asset('storage/'.$listing->image_url) }}" class="image-display" alt="">
                 </div>
                 <div class="col-md-6">
                      <p><b>Short Description: </b>{{ $listing['short-desc'] }}</p>
                      <p><b>Long Description: </b></p>
                      <p><textarea name="" id="" cols="70px" rows="15px" disabled>{{ $listing['long-desc'] }}</textarea></p>
                      <p><b>Price range: </b>{{ $listing['price-min'] }}$-{{ $listing['price-max'] }}$</p>
                      <p><b>Location: </b>{{ $listing['location'] }}</p>
                      @guest
                        <a href="{{ route('auth.login') }}" class="btn btn-primary">Login to command</a>
                      @endguest
                      @auth
                        <form action="{{ route('command.confirm', $listing) }}" method="get">
                             <button type="submit" class="btn btn-primary">Command</button>
                        </form>
                        <form action="{{ route('listing.like', $listing) }}" method="post">
                             @csrf
                             @method('PUT')
                             <button type="submit" class="btn btn-danger">{{ $listing['likes'] }} Likes.</button>
                        </form>
                        <form action="{{ route('main.review-listing', $listing) }}" method="get">
                            <button type="submit" class="btn btn-primary">Leave a review</button>
                        </form>
                      @endauth
                 </div>
                </div>
                <div class="card-body review-section">
                    <h1 style="text-align:center; font-size: 30px;">Reviews</h1>
                    @if ($reviews != null)
                    <div class="review-cards">
                    @foreach ($reviews as $review)
                        <div class="review-card">
                            @include('components.testimonial-review', [
                                'reviews' => $reviews,
                                'users' => $users
                            ])
                        </div>
                    @endforeach
                    </div>
                    @else
                        <p style="text-align: center; font-size: 20px;">Be the first to leave a review to help others</p>
                    @endif
                </div>
           </div>
        </div>
    </div>
</div>
@endsection