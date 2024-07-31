<?php

namespace App\Http\Controllers;

use App\Models\Auth;
use App\Models\Like;
use App\Models\User;
use App\Models\Listing;
use App\Models\News;
use App\Models\Command;
use App\Models\CommandDetail;
use App\Models\Listing\Subentry;
use App\Models\Comment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user() != null) {
            return to_route('main.homepage');
        }
        return view('auth.login');
    }

    public function logon(Request $request) {
        $data = $request->validate([
            "name" => "string|required",
            "email" => "email|string|required",
            "password" => "required"
        ]);

        $info = User::where('email', '=', $data['email'])->first();
        auth()->attempt($request->only('name', 'email', 'password'));
        if (!$info) {
            return back()->with('error', 'there was an error');
        } else {
            $request->session()->regenerate();
            if (!password_verify($request->password, $info->password)) {
                return back()->with('error', 'invalid password');
            } else {
                $request->session()->put('LoggedUser', $info->id);
                return to_route('main.homepage')->with('success', 'logged in successfully');
            }
        }
    }

    public function profile() {
        if (auth()->user() != null) {
            $user = User::where('id', '=', session('LoggedUser'))->first();
        } else {
            return to_route('auth.login');
        }

        $own_posts_ids = News::where('author', '=', auth()->user()->id)->get();
        $liked_listing_ids = Like::where('user_id', '=', auth()->user()->id)->get();
        $liked_listings = [];
        foreach ($liked_listing_ids as $liked_listing_id) {
            $liked_listing = Listing::where('id', '=', $liked_listing_id->listing)->first();
            array_push($liked_listings, $liked_listing);
        }

        return view('user.components.likes', [
            'user' => $user,
            'liked_listings' => $liked_listings,
            'own_posts_ids' => $own_posts_ids
        ]);
    }

    public function profile_posts() {
        if (auth()->user() != null) {
            $user = User::where('id', '=', session('LoggedUser'))->first();
        } else {
            return to_route('auth.login');
        }

        $own_posts_ids = News::where('author', '=', auth()->user()->id)->orderBy('updated_at', 'desc')->get();

        return view('user.components.posts', [
            'user' => $user,
            'own_posts_ids' => $own_posts_ids
        ]);
    }

    public function profile_commands() {
        if (auth()->user() != null) {
            $user = User::where('id', '=', session('LoggedUser'))->first();
        } else {
            return to_route('auth.login');
        }

        $own_commands_ids = Command::where('user_id', '=', auth()->user()->id)->orderBy('updated_at', 'desc')->get();
        $listings = Listing::all();

        return view('user.components.commands', [
            'user' => $user,
            'commands' => $own_commands_ids,
            'listings' => $listings
        ]);
    }

    public function profile_comments() {
        if (auth()->user() != null) {
            $user = User::where('id', '=', session('LoggedUser'))->first();
        } else {
            return to_route('auth.login');
        }

        $own_comments_ids = Comment::where('comment_author', '=', auth()->user()->id)->orderBy('updated_at', 'desc')->get();
        $posts = News::all();

        return view('user.components.comments', [
            'user' => $user,
            'comments' => $own_comments_ids,
            'posts' => $posts
        ]);
    }

    public function profile_command_details(Command $command) {
        if (auth()->user() == null) {
            return abort(403, 'unauthorized');
        }

        $user = User::where('id', '=', session('LoggedUser'))->first();
        $command_details = CommandDetail::where("origin_command", $command['id'])->orderBy('created_at', 'desc')->get();
        $listing = Listing::query()->get();
        $listing_subentry = Subentry::query()->get();
        
        return view('user.components.command-detail', [
            'user' => $user,
            'command_details' => $command_details,
            'listing' => $listing,
            'listing_subentry' => $listing_subentry
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user() != null) {
            return to_route('main.homepage');
        }
        return view('auth.register-page');
    }

    public function logout(Request $request) {
        if ($request->session()->has('LoggedUser')) {
            $request->session()->pull('LoggedUser');
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
        return to_route('main.homepage');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = password_hash($request->password, PASSWORD_DEFAULT);
        $user->remember_token = Str::random(10);
        $user->admin_id = null;
        $save = $user->save();

        if ($save) {
            return to_route('auth.login')->with('success', 'New user has been successfully created! You may now login.');
        } else {
            return back()->with('fail', 'Something went wrong, try again later');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Auth $auth)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Auth $auth)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Auth $auth)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Auth $auth)
    {
        //
    }
}
