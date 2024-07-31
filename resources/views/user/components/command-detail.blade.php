@extends('user.profile')
@section('content2')
<div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 style="font-size: 40px;margin-bottom: 30px;"><a style="font-size: 40px;margin-right: 10px;" href="{{ url()->previous() }}">&#8617;</a>Command Details</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Listing Name</th>
                            <th>Listing Subentry Name</th>
                            <th>Name</th>
                            <th>Surname</th>
                            <th>Place of origin</th>
                            <th>Date of birth</th>
                            <th>Date of arrival</th>
                            <th>Date of departure</th>
                            <th>Calculated Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($command_details as $command)
                            <tr id="{{ $command['id'] }}">
                                <td><?php 
                                    foreach ($listing as $l) {
                                        if ($l['id'] == $command['origin_listing']) {
                                            echo $l['name'];
                                            break;
                                        }
                                    }
                                ?></td>
                                <td><?php 
                                    foreach ($listing_subentry as $l) {
                                        if ($l['id'] == $command['origin_listing_subentry']) {
                                            echo $l['subentry'];
                                            break;
                                        }
                                    }
                                ?></td>
                                <td>{{ $command['name'] }}</td>
                                <td>{{ $command['surname'] }}</td>
                                <td>{{ $command['place_of_origin'] }}</td>
                                <td>{{ $command['date_of_birth'] }}</td>
                                <td>{{ $command['begin_date'] }}</td>
                                <td>{{ $command['end_date'] }}</td>
                                <td>{{ $command['calculated_price'] }}$</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection