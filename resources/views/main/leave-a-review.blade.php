@extends('components.layout')
@section('content')
<style>
    .form-container {
        margin-top: 50px;
    }
    .rating-container {
        display: flex;
        justify-content: left;
        align-items: center;
    }
    .rate {
    float: right;
    height: 46px;
    padding: 0 10px;
}
.rate:not(:checked) > input {
    position:absolute;
    top:-9999px;
}
.rate:not(:checked) > label {
    float:right;
    width:1em;
    overflow:hidden;
    white-space:nowrap;
    cursor:pointer;
    font-size:30px;
    color:#ccc;
}
.rate:not(:checked) > label:before {
    content: '★ ';
}
.rate > input:checked ~ label {
    color: #ffc700;    
}
.rate:not(:checked) > label:hover,
.rate:not(:checked) > label:hover ~ label {
    color: #deb217;  
}
.rate > input:checked + label:hover,
.rate > input:checked + label:hover ~ label,
.rate > input:checked ~ label:hover,
.rate > input:checked ~ label:hover ~ label,
.rate > label:hover ~ input:checked ~ label {
    color: #c59b08;
}
</style>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if ($listing != null)
                    <form class="form-container" action="{{ route('reviews.store', $listing) }}" method="POST">
                @else
                    <form class="form-container" action="{{ route('reviews.store-listingless') }}" method="POST">    
                @endif
                    @csrf
                    @method("POST")
                    <h1 style="text-align:center; font-size: 30px;">Leave a Review</h1>
                    <p style="text-align: center; font-size: 20px;">Your reviews help shape the quality of the website and our services</p>
                    <div class="form-group rating-container">
                        <label for="rating">Rating</label>
                        <div class="rate">
                          <input type="radio" id="star5" name="rate" value="5" />
                          <label for="star5">5 stars</label>
                          <input type="radio" id="star4" name="rate" value="4" />
                          <label for="star4">4 stars</label>
                          <input type="radio" id="star3" name="rate" value="3" />
                          <label for="star3">3 stars</label>
                          <input type="radio" id="star2" name="rate" value="2" />
                          <label for="star2">2 stars</label>
                          <input type="radio" id="star1" name="rate" value="1" />
                          <label for="star1">1 star</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="comment">Comment</label>
                        <textarea name="comment" class="form-control" id="comment" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-danger">Submit review</button>
                    </div>
                </form>
            </div>
        </div>
@endsection