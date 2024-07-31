<?php

namespace App\Http\Controllers;

use App\Models\Command;
use App\Models\CommandDetail;
use App\Models\Listing;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon as SupportCarbon;

class CommandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Listing $listing) {
        if (auth()->user()->id == null) {
            return to_route('auth.login')->with('error', 'You must be logged in to send a travel request');
        }

        // Validate command details
        $data = $request->validate([
            'name' => 'required|string',
            'surname' => 'required|string',
            'place_of_origin' => 'required|string',
            'date_of_birth' => 'required|date',
            'subentry.*' => 'required|exists:subentries,id', // Ensure selected subentries are valid
            'begin-date.*' => 'required|date|date_format:Y-m-d',
            'end-date.*' => 'required|date|after_or_equal:begin-date.*',
            'item-price.*' => 'required'
        ]);

        // Create the Command entry
        $command = Command::create([
            "listing" => $listing->id,
            "user_id" => auth()->user()->id,
            "accepted" => 0, // Use the first date as the command's end date
        ]);

        // Loop through subentries and create CommandDetail entries
        if ($request->subentry != null) {
            $name = $data['name'];
            foreach ($request->subentry as $index => $subentryId) {
                $begin_date = Carbon::parse($data['begin-date'][$index]);
                $end_date = Carbon::parse($data['end-date'][$index]);
                $day_difference = $begin_date->diffInDays($end_date);
                CommandDetail::create([
                    'origin_command' => $command->id,
                    'origin_listing' => $listing->id,
                    'origin_listing_subentry' => $subentryId,
                    'name' => $name,
                    'surname' => $data['surname'],
                    'place_of_origin' => $data['place_of_origin'],
                    'date_of_birth' => $data['date_of_birth'],
                    'begin_date' => $data['begin-date'][$index],
                    'end_date' => $data['end-date'][$index],
                    'calculated_price' => $day_difference * $data['item-price'][$index]
                ]);
            }
        } else {
            $begin_date = Carbon::parse($data['begin-date'][0]);
            $end_date = Carbon::parse($data['end-date'][0]);
            $day_difference = $begin_date->diffInDays($end_date);
            CommandDetail::create([
                'origin_command' => $command->id,
                'origin_listing' => $listing->id,
                'origin_listing_subentry' => NULL,
                'name' => $data['name'],
                'surname' => $data['surname'],
                'place_of_origin' => $data['place_of_origin'],
                'date_of_birth' => $data['date_of_birth'],
                'begin_date' => $data['begin-date'][0],
                'end_date' => $data['end-date'][0],
                'calculated_price' => $day_difference * $data['item-price'][0]
            ]);
        }

        return to_route('main.homepage')->with('success', 'Your travel request has been sent successfully');
    }

    /*
    public function store(Request $request, Listing $listing)
    {
        if (auth()->user()->id == null) {
            return to_route('auth.login')->with('error', 'you must be logged in to send a travel request');
        }

        $data2 = $request->validate([
            'begin-date' => 'required|date',
            'end-date' => 'required|date|after:begin-date',
        ]);

        $data = [
            "listing" => $listing->id,
            "user_id" => auth()->user()->id,
            "accepted" => 0,
            "beginning_date" => $data2['begin-date'],
            "end_date" => $data2['end-date'],
        ];

        Command::create($data);
        return to_route('main.homepage')->with('sucess', 'your travel request has been sent successfully');
    }*/

    /**
     * Display the specified resource.
     */
    public function show(Command $command)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Command $command)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Command $command)
    {
        if (auth()->user()->admin_id != null) {
            $command->accepted = 1;
            $command->save();

            return to_route('admin.panel')->with('success', 'travel has been accepted successfully');
        } else {
            return abort(403, 'unauthorized');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Command $command)
    {
        if (!auth()->check()) {
            return to_route('auth.login')->with('error', 'You must be logged in to delete commands');
        }
        $command->delete();
        return back()->with('success', 'command has been deleted');
    }
}
