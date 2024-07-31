<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Listing\Subentry;
use App\Models\Type;
use App\Models\Admin\Admin;
use App\Models\Listing;
use App\Models\Command;
use App\Models\CommandDetail;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function panel() {
        if (auth()->user() == null) {
            return abort(403, 'unauthorized');
        }

        if (auth()->user()->admin_id == null) {
            return abort(403, 'unauthorized');
        }
        $commands = Command::query()->orderBy('created_at', 'desc')->get();
        $listings = Listing::query()->orderBy('created_at', 'desc')->get();
        $users = User::query()->orderBy('created_at', 'desc')->get();
        $command_details = CommandDetail::query()->orderBy('created_at', 'desc')->get();
        return view('admin.panel', [
            'commands' => $commands,
            'listings' => $listings,
            'users' => $users,
            'command_details' => $command_details
        ]);
    }

    public function command_details(Command $command) {
        if (auth()->user() == null) {
            return abort(403, 'unauthorized');
        }

        if (auth()->user()->admin_id == null) {
            return abort(403, 'unauthorized');
        }
        $command_details = CommandDetail::where("origin_command", $command['id'])->orderBy('created_at', 'desc')->get();
        $listing = Listing::query()->get();
        $listing_subentry = Subentry::query()->get();
        
        return view('admin.detail', [
            'command_details' => $command_details,
            'listing' => $listing,
            'listing_subentry' => $listing_subentry
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user() == null) {
            return abort(403, 'unauthorized');
        }
        if (auth()->user()->admin_id == null) {
            return abort(403, 'unauthorized');
        }
        $users = User::query()->orderBy('created_at', 'desc')->get();
        return view('admin.make_admin', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user() == null) {
            return abort(403, 'unauthorized');
        }

        if (auth()->user()->admin_id == null) {
            return abort(403, 'unauthorized');
        }
        return view('admin.submit-entry');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $user)
    {
        if (auth()->user() == null) {
            return abort(403, 'unauthorized');
        }

        if (auth()->user()->admin_id == null) {
            return abort(403, 'unauthorized');
        }

        $data = [
            "name" => $user->name,
            "email" => $user->email,
            "password" => $user->password
        ];

        //dd($data);
        //dd($user->id);
        $req = Admin::create($data);

        User::where('id', $user->id)->update(['admin_id' => $req->id]);
        return to_route('admin.panel')->with('success', 'user has been turned into an admin successfully');
    }

    public function remove_admin(User $user) {
        if (auth()->user() == null) {
            return abort(403, 'unauthorized');
        }

        if (auth()->user()->admin_id == null) {
            return abort(403, 'unauthorized');
        }

        Admin::where('id', $user->admin_id)->delete();
        User::where('id', $user->id)->update(['admin_id' => null]);
        return to_route('admin.panel')->with('success', 'admin has been removed successfully');
    }

    public function listing_delete() {
        if (auth()->user() == null) {
            return abort(403, 'unauthorized');
        }

        if (auth()->user()->admin_id == null) {
            return abort(403, 'unauthorized');
        }

        $listings = Listing::query()->orderBy('created_at', 'desc')->get();
        $types = Type::query()->orderBy('created_at', 'desc')->get();
        return view('admin.delete-entry', [
            'entries' => $listings,
            'type' => $types
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        //
    }
}
