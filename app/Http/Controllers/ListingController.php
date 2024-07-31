<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Type;
use App\Models\Like;
use App\Models\Listing\Subentry;
use App\Models\Reviews;
use App\Models\User;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('main.homepage');
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
        if (auth()->user() == null) {
            return abort(403, 'unauthorized');
        }

        if (auth()->user()->admin_id == null) {
            return abort(403, 'unauthorized');
        }

        // get each sublisting from the request

        $data = $request->all();
        //dd($data['image_url']);
        // request the image path
        //dd($request->file('image_url'));
        $imageName = time() . '.' . $request->file('image_url')->getClientOriginalExtension();
        //dd($request->file('image_url'));//->store('images');
        
        // $path will be the fully qualified path to the file, including filename.
        try {
            $request->file('image_url')->storeAs('public', $imageName);
        } catch (\Exception $e) {
            return to_route('admin.submit-entry')->with('error', 'image upload failed');
        }
        
        $data['image_url'] = $imageName;
        $min = $request->price_min;
        $max = $request->price_max;
        if ($min == null) {
            $t = $data['entry_price1'];
            for ($i = 2; $i <= $data['num_entries']; $i++) {
                if ($data['entry_price'.$i] < $t) $t = $data['entry_price'.$i];
            }
            $min = $t;
        }

        if ($max == null) {
            $t = $data['entry_price1'];
            for ($i = 2; $i <= $data['num_entries']; $i++) {
                if ($data['entry_price'.$i] > $t) $t = $data['entry_price'.$i];
            }
            $max = $t;
        }

        $data['price-min'] = $min;
        $data['price-max'] = $max;
        //dd($request);
        //dd($request->status);
        switch ($request->status) {
            case 'on':
                $data['status'] = 1;
                break;
            default:
                $data['status'] = 0;
                break;
        }
        if (Type::query()->where('id', '=', $data['type']) == null) {
            return to_route('admin.submit-entry')->with('error', "invalid type");
        }

        $new_listing = Listing::create($data);

        for ($i = 1; $i <= $data['num_entries']; $i++) {
            Subentry::create([
                'listing_id' => $new_listing->id,
                'subentry' => $data['entry'.$i],
                'price' => $data['entry_price'.$i]
            ]);
        }

        return to_route('main.homepage')->with('success', 'listing has been created successfully');
    }

    public function like(Listing $listing) {
        if (auth()->user() == null) {
            return to_route('auth.login')->with('error', 'you need to login in order to perform that action');
        }
        //dd($listing->id);
        if (Like::query()->where('listing', '=', $listing->id)->where('user_id', '=', auth()->user()->id)->first() != null) {
            return back()->with('error', 'Post is already liked');
        }
        
        // todo : add a new entry to a table for likes for the user
        Like::create([
            'listing' => $listing->id,
            'user_id' => auth()->user()->id
        ]);

        $listing->likes = Like::query()->where('listing', '=', $listing->id)->count();
        $listing->save();

        return back()->with('success', 'thanks for your feedback');
    }

    public function listings(Request $request) {
        //dd($request);
        $req_type = $request->input('type');
        $req_location = $request->input('location');

        $listings = Listing::query()
            ->orderBy('updated_at', 'desc')
            ->where('location', 'like', '%'.$req_location.'%');

        if ($req_type) {
        //if ($req_type == 0) $req_type = null; // no.
            $listings = $listings->where('type', '=', $req_type);
        }

        $reviews = Reviews::query()->get();
        $listings = $listings->paginate(10);

        $collected_reviews = [];
        foreach ($reviews as $review) {
            array_push($collected_reviews, $review);
        }

        $types = Type::query()->get();
        //dd($listings);
        return view('main.listings', [
            'listings' => $listings,
            'types' => $types,
            'reviews' => $collected_reviews
        ]);
    }
    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
        if ($listing == null) {
            return abort(404, 'listing not found');
        }
        $reviews = Reviews::where('listing_id', $listing->id)->get();
        $users = User::query()->get();
        return view('main.listing', [
            'listing' => $listing,
            'reviews' => $reviews,
            'users' => $users
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Listing $listing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing)
    {
        if (auth()->user() == null) {
            return abort(403, 'unauthorized');
        }

        if (auth()->user()->admin_id == null) {
            return abort(403, 'unauthorized');
        }

        $listing->delete();
        return to_route('admin.delete-entry')->with('success', 'listing has been deleted successfully');
    }
}
