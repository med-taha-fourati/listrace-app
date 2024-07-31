<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Reviews;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Listing $listing)
    {
        if (!auth()->check()) return to_route('auth.login')->with('error', 'You must be logged in to leave a review.');
        //dd($listing->getAttributes());
        if ($listing->getAttributes() == []) return view('main.leave-a-review', [
            'listing' => null
        ]);
        else return view('main.leave-a-review', [
            'listing' => $listing
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Listing $listing)
    {
        if (!auth()->check()) return to_route('auth.login')->with('error', 'You must be logged in to leave a review.');
        
        $data = $request->all();

        $data['user_id'] = auth()->id();
        $data['listing_id'] = $listing->id != null ? $listing->id : null;

        if ($data['rate'] < 1) return back()->with('error', 'Please rate the listing.');
        $data['stars'] = $data['rate'];
        $data['content'] = $data['comment'];

        Reviews::create($data);
        return to_route('main.homepage')->with('success', 'Review submitted successfully. Thank you!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reviews $reviews)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reviews $reviews)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reviews $reviews)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reviews $reviews)
    {
        //
    }
}
