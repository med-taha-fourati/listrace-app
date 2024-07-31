@extends('components.layout')
@section('content')

<!-- foreach listing show it here -->
<style>
    .explore-content {
        padding: 20px;
    }
    .explore-banner {
        margin-bottom: 20px;
    }
    .pagination-container {
        display: flex;
        justify-content: center;
        padding: 10px;
        font-size: large;
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
        @if ($listings->count() != 0)
            <div class="explore-banner" style="text-align: center;">
                <h1 style="font-size: 50px;">Explore Listings</h1>
                <p style="font-size: 30px;">Here are some of the listings available</p>
            </div>
            <div class="pagination-container">
                <p>{{ $listings->links() }}</p>
            </div>
            @foreach ($listings as $listing_attrib)
                    @include('components.listing-card', [
                        'listing_attrib' => $listing_attrib,
                        'reviews' => $reviews
                    ])
                @endforeach
            <!--<div class="container">
                
            </div>-->
        @else
            <div class="col-md-12" style="text-align: center;">
                <h3>No listings found :C</h3>
                <p>Come back next time when there are deals available</p>
            </div>
        @endif
    </div>
</div>

@endsection