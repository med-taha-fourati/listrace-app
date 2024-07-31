<style>
	.single-explore-img {
		object-fit: cover;
		max-height: 200px;
	}
</style>

<div class=" col-md-4 col-sm-6">
<div class="single-explore-item">
    <div class="single-explore-img">
    	<img src="{{ asset('storage/'.$listing_attrib->image_url) }}" alt="explore image">
    	<div class="single-explore-img-info">
    		<button onclick="window.location.href='#'">best rated</button>
    		<div class="single-explore-image-icon-box">
    			<ul>
    				<li>
    					<div class="single-explore-image-icon">
    						<i class="fa fa-arrows-alt"></i>
    					</div>
    				</li>
    				<li>
    					<div class="single-explore-image-icon">
    						<i class="fa fa-bookmark-o"></i>
    					</div>
    				</li>
    			</ul>
    		</div>
    	</div>
    </div>
<div class="single-explore-txt bg-theme-1">
	<h2><a href="{{ route('main.listing', $listing_attrib) }}">{{ $listing_attrib['name'] }}</a></h2>
	<p class="explore-rating-price">
		@if ($reviews != [])
		<?php 
			$sum = 0;
			$count = 0;
			foreach ($reviews as $review) {
				if ($review['listing_id'] == $listing_attrib['id']) {
					$sum += $review['stars'];
					$count++;
				}
			}
		?>
		@if ($count != 0)
		<span class="explore-rating">{{ floatval(($sum / $count)) }}</span>
		@else
		<span class="explore-rating">0.0</span>
		@endif
		<a href="#">{{ $count }} ratings</a> 
		@else
		<span class="explore-rating">0.0</span>
		<a href="#">0 ratings</a> 
		@endif
		<span class="explore-price-box">
			form
			<span class="explore-price">{{ $listing_attrib['price-min'] }}$-{{ $listing_attrib['price-max'] }}$</span>
		</span>
		 <a href="#"><?php 
		 	foreach ($types as $type) {
				if ($type['id'] == $listing_attrib['type']) echo $type['type_name'];
			}
		 ?></a>
	</p>
	<div class="explore-person">
		<div class="row">
			@if (count($reviews) != 0)
			<div class="col-sm-2">
				<div class="explore-person-img">
					<a href="#">
						<img src="assets/images/explore/person.png" alt="explore person">
					</a>
				</div>
			</div>
			
			<div class="col-sm-10">
				<p>
					<?php 
						$filtered_reviews = [];
						foreach ($reviews as $review) {
							if ($review['listing_id'] == $listing_attrib['id']) {
								array_push($filtered_reviews, $review);
							}
						}
						if (count($filtered_reviews) != 0) {
							echo $filtered_reviews[rand(0, $count-1)]['content'];
						} else {
							echo "<i>No reviews available</i>";
						}
					?>
				</p>
			</div>
			@endif
		</div>
	</div>
	<div class="explore-open-close-part">
		<div class="row">
			<div class="col-sm-5">
				<button class="close-btn" onclick="window.location.href='#'"><?php 
					if ($listing_attrib['status'] == 1) echo "Open now";
					else echo "Closed now";
				?></button>
			</div>
			<div class="col-sm-7">
				<div class="explore-map-icon">
					<a href="#"><i data-feather="map-pin"></i></a>
					<a href="#"><i data-feather="upload"></i></a>
					<a href="#"><i data-feather="heart"></i></a>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</div>