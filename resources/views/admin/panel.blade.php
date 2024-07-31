@extends('components.layout')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 style="font-size: 40px;margin-bottom: 30px;">Commands</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Listing</th>
                            <th>User</th>
                            <th>Status</th>
                            <th>Details</th>
                            <th>Price</th>
                            <th>Accept?</th>
                            <th>Delete?</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($commands as $command)
                            
                                @csrf
                                @method('PUT')
                                <tr id="{{ $command['id'] }}">
                                    <form action="{{ route('command.update', $command) }}" method="post">
                                    <td>
                                        <?php
                                        foreach ($listings as $listing) {
                                            if ($listing['id'] == $command['listing']) echo $listing['name'];
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        foreach ($users as $user) {
                                            if ($user['id'] == $command['user_id']) echo $user['name'];
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo ($command['accepted'] == 0) ? "pending" : "accepted";
                                        ?>
                                    </td>
                                    <?php
                                        $command_details = App\Models\CommandDetail::query()
                                            ->where('origin_command', $command['id'])
                                            ->whereNotNull('origin_listing_subentry')
                                            ->first();
                                        if ($command_details != null) {
                                            ?> <td>
                                                        <a href="{{ route('admin.show-detail', $command) }}" class="btn btn-primary">View Details</a>
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
                                    @if ($command['accepted'] == 0)
                                        <td>
                                            <button class="btn btn-primary" type="submit">Accept!</button>
                                        </td>
                                    @else
                                        <td>
                                            Already Accepted
                                        </td>
                                    @endif
                                    </form>
                                    <td>
                                        <form action="{{ route('command.destroy', $command) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" type="submit">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection