@extends('components.layout')
@section('error')
    <p>@section('error')</p>
@endsection
@section('content')

    <style>
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-control {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        
        .form-control-file {
            display: block;
        }
        
        .btn-primary {
            background-color: #007bff;
            color: white;
            padding: 10px 24px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
    <div class="container">
    <div class="col-md-12">
    <h1 style="font-size: 40px;margin-bottom: 30px;">Add a listing entry: </h1>
    <form action="{{ route('listing.store') }}" method="post" enctype="multipart/form-data" class="form">
    @csrf
    @method('POST')
    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" placeholder="Enter name" required class="form-control">
    </div>
    <div class="form-group">
        <label for="short-desc">Short Description:</label>
        <input type="text" name="short-desc" id="short-desc" placeholder="Enter a short description" required class="form-control">
    </div>
    <div class="form-group">
        <label for="long-desc">Long Description:</label>
        <textarea name="long-desc" id="long-desc" placeholder="Enter a detailed description" class="form-control"></textarea>
    </div>
    <div class="form-group">
        <label for="location">Location:</label>
        <input type="text" name="location" id="location" placeholder="Enter location" required class="form-control">
    </div>
    <div class="form-group">
        <label for="type">Type:</label>
        <select name="type" id="type" class="form-control">
            <option value="1">Hotel</option>
            <option value="2">Restaurant</option>
            <option value="3">Automotives</option>
            <option value="4">Healthcare</option>
            <option value="5">Destination</option>
        </select>
    </div>
    <div class="form-group">
        <label for="price-min">Min Price:</label>
        <input type="number" name="price_min" id="price_min" min="0" class="form-control">
    </div>
    <div class="form-group">
        <label for="price-max">Max Price:</label>
        <input type="number" name="price_max" id="price_max" class="form-control">
    </div>
    <div class="form-group">
        <label for="status">Available?</label>
        <input type="checkbox" name="status" id="status" class="form-check-input">
    </div>
    <div class="form-group">
        <label for="image">Image:</label>
        <input type="file" name="image_url" id="image_url" class="form-control-file">
    </div>
    <div class="form-group">
        <label for="num_entries">Number of sub-entries</label>
        <input type="number" class="form-control" name="num_entries" id="num_entries" min='0'>
    </div>
    <div class="subentry-handler" id="subentry-handler">

    </div>
    <!-- <div class="form-group">
        <label for="entryfirst">Subentry 1:</label>
        <input type="text" name="entryfirst" id="entryfirst" class="form-check-input">
    </div> -->
        <button type="submit" class="btn btn-primary">Add entry</button>
    </form>
    </div>
    </div>

<script>
    // JavaScript to handle dynamic input fields
    function createDivForNumberField(id) {
        const div = document.createElement('div');
        div.className = 'form-group col-md-3';
        div.appendChild(createNumberField(id));
        return div;
    }

    function createNumberField(id) {
        const input = document.createElement('input');
        input.type = 'number';
        input.name = 'entry_price'+id;
        input.id = 'entry_price'+id;
        input.min = 0;
        input.className = 'form-control';
        input.placeholder = 'Subentry Cost';
        return input;
    }

    function createDivforDivField(id) {
        const div2 = document.createElement('div');
        div2.className = 'form-group';
        div2.appendChild(createDivFortextField(id))
        div2.appendChild(createDivForNumberField(id));
        return div2;
    }

    function createDivFortextField(id) {
        const div = document.createElement('div');
        div.className = 'form-group col-md-9';
        div.appendChild(createTextField(id));
        return div;
    }

    function createTextField(id) {
        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'entry'+id;
        input.id = 'entry'+id;
        input.className = 'form-control';
        input.placeholder = 'Listing Subentry Name';
        return input;
    }

    document.addEventListener('DOMContentLoaded', function() {
            const numInputs = document.getElementById('num_entries');
            const inputContainer = document.getElementById('subentry-handler');

            // Function to update the number of text inputs
            function updateTextInputs() {
                // Get the number of text fields to create
                const count = parseInt(numInputs.value) || 0;
                if (count === 0) {
                    document.getElementById('price_min').disabled = false;
                    document.getElementById('price_max').disabled = false;
                } else {
                    document.getElementById('price_min').disabled = true;
                    document.getElementById('price_max').disabled = true;
                }
                // Clear existing inputs
                inputContainer.innerHTML = '';

                // Create new text input fields
                for (let i = 0; i < count; i++) {
                    inputContainer.appendChild(createDivforDivField(i + 1));
                }
            }

            // Add an event listener to the number input
            numInputs.addEventListener('input', updateTextInputs);

            // Initial call to populate the fields based on default value
            updateTextInputs();
        });
</script>
@endsection