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
    .confirm-container {
        display: block;
        border: 1px solid #ccc;
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 0.5rem;
    }
    .subentry-info {
        display: none;
    }
    .subentry-container {
        margin-top: 15px;
    }
    .subentry-item {
        display: flex;
        flex-direction: column;
        align-items: start;
        margin-bottom: 15px;
    }
    .remove-button {
        margin-top: 10px;
    }
    .date-fields {
        display: none;
        margin-top: 10px;
    }
</style>
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@elseif (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<div class="container">
    <div class="row">
        <div class="col-md-12">
           <div class="card">
                <div class="card-header">
                    <div class="title">
                        <a style="font-size: 40px;margin-right: 10px;" href="{{ route('main.listings') }}">&#8617;</a>
                        <h1 style="font-size: 40px;">{{ $listing['name'] }} Registration form</h1>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-md-12">
                        <form action="{{ route('command.store', $listing) }}" method="post">
                            @csrf
                            @method('POST')
                            <div class="confirm-container">
                            <h5 style="font-size:x-large;padding: 15px;">Tell us more about yourself: </h5>
                                <div class="form-group">
                                    <div class="form-group col-md-6">
                                        <label for="name">Name:</label>
                                        <input type="text" name="name" class="form-control">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="surname">Surname:</label>
                                        <input type="text" name="surname" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-group col-md-6">
                                        <label for="place_of_origin">Place of origin:</label>
                                        <input type="text" name="place_of_origin" class="form-control">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="date_of_birth">Birthday:</label>
                                        <input type="date" name="date_of_birth" class="form-control">
                                    </div>
                                </div>
                                <div id="subentry-container">
                                    @if ($listing_sub->count() != 0)
                                    <h5 style="font-size:x-large;padding: 15px;">Choose your subentries: </h5>
                                        <!-- <div id="subentry-item">
                                            <div class="form-group">
                                                <label for="subentry">Choose a subentry:</label>
                                                <select class="form-control subentry-selector" name="subentry[]">
                                                    <option value="">Select a subentry</option>
                                                    @foreach ($listing_sub as $subentry)
                                                        <option value="{{ $subentry['id'] }}" data-info="{{ $subentry['additional_info'] }}">{{ $subentry['subentry'] }} -- {{ $subentry['price'] }}$</option>
                                                    @endforeach
                                                </select>
                                                <div class="date-fields">
                                                    <div class="form-group">
                                                        <label for="begin-date">Date of arrival:</label>
                                                        <input type="date" class="form-control begin-date" name="begin-date[]">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="end-date">Date of departure:</label>
                                                        <input type="date" class="form-control end-date" name="end-date[]">
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-danger btn-sm remove-button">Remove</button>
                                            </div>
                                        </div> -->
                                    @else
                                    <div class="form-group">
                                        <h5 style="font-size:x-large;padding: 15px;">This listing has no subentries</h5>
                                        <div class="date-field">
                                            <div class="form-group">
                                                <label for="begin-date">Date of arrival:</label>
                                                <input type="date" class="form-control begin-date" name="begin-date[]">
                                            </div>
                                            <div class="form-group">
                                                <label for="end-date">Date of departure:</label>
                                                <input type="date" class="form-control end-date" name="end-date[]">
                                            </div>
                                            <input type="hidden" class="item-price" value="{{ $listing['price-min'] }}" name="item-price[]">
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                @if ($listing_sub->count() != 0)
                                    <button type="button" id="add-subentry" class="btn btn-primary">Add Subentry</button>
                                @endif

                                <div id="subentry-info-container" class="subentry-info">
                                    <p id="subentry-info-text"></p>
                                </div>
                                <hr>
                                <div class="col">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-danger">Submit command</button>
                                    </div>
                                </div>
                            </div>
                      </form>
                    </div>
                </div>
           </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const subentryContainer = document.getElementById('subentry-container');
        const addSubentryButton = document.getElementById('add-subentry');
        const subentryInfoContainer = document.getElementById('subentry-info-container');
        const subentryInfoText = document.getElementById('subentry-info-text');
        let subentryCount = document.querySelectorAll('.subentry-selector').length; // Track the number of subentry selectors

        // Function to handle the change event for subentry selectors
        function handleSubentryChange(event) {
            const selectedOption = event.target.options[event.target.selectedIndex];
            const info = selectedOption.getAttribute('data-info');
            const price = selectedOption.getAttribute('data-price');

            if (info) {
                subentryInfoText.textContent = info;
                subentryInfoContainer.style.display = 'block';
            } else {
                subentryInfoContainer.style.display = 'none';
            }

            // Show date fields for the selected subentry
            const dateFieldsContainer = event.target.parentElement.querySelector('.date-fields');
            if (dateFieldsContainer) {
                dateFieldsContainer.style.display = 'block';
            }

            // Update price data for total cost calculation
            const priceElement = event.target.parentElement.querySelector('.item-price');
            if (priceElement) {
                priceElement.value = price;
            }
        }

        // Attach the change event listener to existing subentry selectors
        document.querySelectorAll('.subentry-selector').forEach(selector => {
            selector.addEventListener('change', handleSubentryChange);
        });

        // Handle click event for the Add Subentry button
        addSubentryButton.addEventListener('click', function () {
            if (subentryCount >= 5) { // Limit the number of subentries (adjust as needed)
                alert('Maximum number of subentries reached');
                return;
            }

            subentryCount++;
            console.log(subentryCount);
            // Create a new subentry item
            const newSubentryItem = document.createElement('div');
            newSubentryItem.className = 'subentry-item';

            newSubentryItem.innerHTML = `
                <div class="form-group">
                    <label for="subentry">Choose a subentry:</label>
                    <select class="form-control subentry-selector" name="subentry[]">
                        <option value="">Select a subentry</option>
                        @foreach ($listing_sub as $subentry)
                            <option value="{{ $subentry['id'] }}" data-price="{{ $subentry['price'] }}">{{ $subentry['subentry'] }} -- {{ $subentry['price'] }}$</option>
                        @endforeach
                    </select>
                    <input type="hidden" class="item-price" value="" name="item-price[]">
                    <div class="date-fields" style="display: none;">
                        <div class="form-group">
                            <label for="begin-date">Date of arrival:</label>
                            <input type="date" class="form-control begin-date" name="begin-date[]">
                        </div>
                        <div class="form-group">
                            <label for="end-date">Date of departure:</label>
                            <input type="date" class="form-control end-date" name="end-date[]">
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger btn-sm remove-button">Remove</button>
                </div>
            `;

            // Add change event for the new select element
            newSubentryItem.querySelector('.subentry-selector').addEventListener('change', handleSubentryChange);

            // Add change event for begin and end dates
            newSubentryItem.querySelector('.begin-date').addEventListener('change', (e) => {
                updateTotalCost(newSubentryItem);
            });

            newSubentryItem.querySelector('.end-date').addEventListener('change', (e) => {
                updateTotalCost(newSubentryItem);
            });

            // Add click event for the remove button
            newSubentryItem.querySelector('.remove-button').addEventListener('click', function () {
                newSubentryItem.remove();
                subentryCount--;
                if (subentryCount === 0) {
                    subentryInfoContainer.style.display = 'none';
                }
                console.log(subentryCount);
            });

            subentryContainer.appendChild(newSubentryItem);
        });

        // Handle click event for the Remove Initial Subentry button
        subentryContainer.addEventListener('click', function (event) {
            if (event.target.classList.contains('remove-button')) {
                event.target.closest('.subentry-item').remove();
                subentryCount--;
                if (subentryCount === 0) {
                    subentryInfoContainer.style.display = 'none';
                }
            }
        });

        // Function to update the total cost
        function updateTotalCost(subentryItem) {
            const beginDate = subentryItem.querySelector('.begin-date').value;
            const endDate = subentryItem.querySelector('.end-date').value;
            const price = parseFloat(subentryItem.querySelector('.item-price').value);

            if (beginDate && endDate) {
                const totalDaysCounted = (new Date(endDate).getTime() - new Date(beginDate).getTime()) / 86400000;
                const totalCost = totalDaysCounted * price;

                let totalDaysElement = subentryItem.querySelector('.total-days');
                if (!totalDaysElement) {
                    totalDaysElement = document.createElement('div');
                    totalDaysElement.className = 'form-group total-days';
                    subentryItem.appendChild(totalDaysElement);
                }
                totalDaysElement.innerHTML = `
                    <p>${totalDaysCounted} days x ${price}$ = ${totalCost.toFixed(2)}$</p>
                `;
            }
        }
    });
</script>

@endsection
