	<div class="testimonial-description">
		<div class="testimonial-info">
			<div class="testimonial-img">
				<img src="{{ asset('assets/images/clients/c1.png') }}" alt="clients">
			</div><!--/.testimonial-img-->
			<div class="testimonial-person">
				<h2><?php 
                    foreach ($users as $user) {
                        if ($user['id'] == $review['user_id']) {
                            echo $user['name'];
                            break;
                        }
                    }
                ?></h2>
				<div class="testimonial-person-star">
                    @for ($i = 0; $i < $review['stars']; $i++)
					    <i class="fa fa-star"></i>
                    @endfor
				</div>
			</div><!--/.testimonial-person-->
		</div><!--/.testimonial-info-->
		<div class="testimonial-comment">
			<p>
				{{ $review['content'] }}
			</p>
		</div><!--/.testimonial-comment-->
	</div><!--/.testimonial-description-->