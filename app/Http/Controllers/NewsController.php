<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::query()->orderBy('updated_at', 'desc')->get();
        $users = User::all();
        return view('main.news', compact('news', 'users'));
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
        $data = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image_url' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        if (!auth()->check()) {
            return to_route('auth.login')->with('error', 'You need to be logged in to create a post');
        }

        $data['headline'] = $data['title'];
        $data['author'] = auth()->id();
        //dd($request->file('image_url'));

        if ($request->image_url != null) {
            $imageName = time() . 'post.' . $request->file('image_url')->getClientOriginalExtension();
            //dd($request->file('image_url'));//->store('images');
            
            // $path will be the fully qualified path to the file, including filename.
            $data['image_url'] = $imageName;
            try {
                $request->file('image_url')->storeAs('public/posts', $imageName);
            } catch (\Exception $e) {
                return dd($e); //back()->with('error', 'image upload failed');`
            }
        } else {
            $data['image_url'] = null;
        }

        News::create($data);
        return to_route('main.posts')->with('success', 'News post created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        if (!auth()->check()) {
            return back()->with('error', 'You need to be logged in to delete a post');
        }

        if ($news->author != auth()->id()) {
            return back()->with('error', 'You are not authorized to delete this post');
        }
        
        // delete file too
        if ($news->image_url != null) {
            $file_to_be_deleted = $news->image_url;
        
            if (File::exists(public_path('storage/posts/'.$file_to_be_deleted))) {
                File::delete(public_path('storage/posts/'.$file_to_be_deleted));
            }
        }

        $news->delete();

        return back()->with('success', 'News post deleted successfully');
    }
}
