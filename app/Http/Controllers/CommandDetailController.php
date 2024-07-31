<?php

namespace App\Http\Controllers;

use App\Models\CommandDetail;
use Illuminate\Http\Request;
use App\Models\Listing;
use App\Models\Listing\Subentry;

class CommandDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function confirmal(Listing $listing) {
        $listing_sub = Subentry::query()->where('listing_id', $listing->id)->get();
        return view('components.confirm', compact('listing', 'listing_sub'));
    }

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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CommandDetail $commandDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CommandDetail $commandDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CommandDetail $commandDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CommandDetail $commandDetail)
    {
        //
    }
}
