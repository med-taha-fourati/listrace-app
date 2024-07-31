@extends('user.profile')
@section('content2')
    <style>
        .listing-img {
            width: 100px;
            height: 100px;
            border-radius: 0.5rem;
        }
        img {
            object-fit: cover;
        }
    </style>
    <div class="row">
        <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Listing</th>
                            <th>Details</th>
                            <th>Price</th>
                            <th>Cancel?</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($commands as $command)
                            <form action="{{ route('command.destroy', $command) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <tr id="{{ $command['id'] }}">
                                    <td>
                                        <?php 
                                            foreach ($listings as $listing) {
                                                if ($listing['id'] == $command['listing']) echo $listing['name'];
                                            }
                                        ?>
                                    </td>
                                    <?php
                                        $command_details = App\Models\CommandDetail::query()
                                            ->where('origin_command', $command['id'])
                                            ->whereNotNull('origin_listing_subentry')
                                            ->first();
                                        if ($command_details != null) {
                                            ?> <td>
                                                        <a href="{{ route('auth.command-details', $command) }}" class="btn btn-primary">View Details</a>
                                                    </td>
                                                <?php
                                        } else {
                                            echo "<td>No details found</td>";
                                        }
                                    ?>
                                    <?php 
                                        $command_details = App\Models\CommandDetail::query()
                                            ->where('origin_command', $command['id'])
                                            ->whereNotNull('origin_listing_subentry')
                                            ->first();

                                        if ($command_details != null) {
                                            ?> <td>
                                                        see details for more info
                                                    </td>
                                                <?php
                                        } else {
                                            foreach ($listings as $listing) {
                                                if ($listing['id'] == $command['listing']) echo "<td>".$listing['price-min']."$</td>";
                                            }
                                        }
                                    ?>
                                    <td>
                                        <button type="submit" class="btn btn-danger">Cancel</button>
                                    </td>
                                </tr>
                            </form>
                        @endforeach
                    </tbody>
                </table>
        </div>
    </div>
@endsection