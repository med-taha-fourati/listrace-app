<!-- {{ route('main.listings') }} -->
<form action="{{ route('main.listings') }}" method="get">
<div class="welcome-hero-serch-box">
	<div class="welcome-hero-form">
		<div class="single-welcome-hero-form">
            <h3>what?</h3>
            <input type="search" id="type" list="suggestions" name="types" placeholder="Ex: Hotel, restaurant, etc..."/>
            <datalist id="suggestions">
                <option data-value="1" value="Hotel"></option>
                <option data-value="2" value="Restaurant"></option>
                <option data-value="3" value="Automotives"></option>
                <option data-value="4" value="Healthcare"></option>
                <option data-value="5" value="Destination"></option>
            </datalist>
            <input type="hidden" name="type" id="truetype">

			<div class="welcome-hero-form-icon">
				<i class="flaticon-list-with-dots"></i>
			</div>
		</div>
		<div class="single-welcome-hero-form">
			<h3>location</h3>
				<input type="text" placeholder="Ex: london, newyork, rome" name="location" />
			<div class="welcome-hero-form-icon">
				<i class="flaticon-gps-fixed-indicator"></i>
			</div>
		</div>
	</div>
	<div class="welcome-hero-serch">
		<button class="welcome-hero-btn" id="submit" type="submit">
			 search  <i data-feather="search"></i> 
		</button>
	</div>
</form>

<script>
    let input = document.querySelector('input[list="suggestions"]');
    input.addEventListener('input', (e) => {
        let value = e.target.value;
        let datalist = document.querySelector('datalist#suggestions');
        let selected = datalist.querySelector(`option[value="${value}"]`);
        // document.querySelector('input#truetype').value = "";
        if (selected) {
            let dataValue = selected.dataset.value;
            console.log('selected value is:', dataValue);
            document.querySelector('input#truetype').value = dataValue;
        } else {
            document.querySelector('input#truetype').value = "";
        }
    });
</script>