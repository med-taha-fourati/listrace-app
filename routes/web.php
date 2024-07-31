<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommandController;
use App\Http\Controllers\CommandDetailController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\CommentController;
use App\Models\Reviews;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return to_route('main.homepage');
});

Route::group(['prefix' => 'admin'], function () {
    Route::get('/makeadmin', [AdminController::class, 'index'])->name('admin.index');
    Route::put('/makeadmin/{user}/make', [AdminController::class, 'store'])->name('admin.make');
    Route::get('/', [AdminController::class, 'panel'])->name('admin.panel');
    Route::get('/add', [AdminController::class, 'create'])->name('admin.add-entry');
    Route::put('/{command}/edit', [CommandController::class, 'update'])->name('command.update');
    Route::get('/listings', [AdminController::class, 'listing_delete'])->name('admin.delete-entry');
    Route::get('/details/{command}', [AdminController::class, 'command_details'])->name('admin.show-detail');
});

Route::delete('/command/delete/{command}', [CommandController::class, 'destroy'])->name('command.destroy');

Route::get('/listings', [ListingController::class, 'listings'])->name('main.listings');
Route::get('/listing/{listing}', [ListingController::class, 'show'])->name('main.listing');
Route::post('/listing/{listing}/command', [CommandController::class, 'store'])->name('command.store');
Route::put('/listing/{listing}/like', [ListingController::class, 'like'])->name('listing.like');
Route::get('/listing/command/{listing}', [CommandDetailController::class, 'confirmal'])->name('command.confirm');

Route::get('/news', [NewsController::class, 'index'])->name('main.posts');
Route::get('/news/comments/{news}', [CommentController::class, 'index'])->name('main.comments');
Route::post('/news', [NewsController::class, 'store'])->name('news.store');

Route::get('/reviews', [ReviewsController::class, 'create'])->name('main.review');
Route::get('/review/{listing}', [ReviewsController::class, 'create'])->name('main.review-listing');
Route::post('/review/{listing}', [ReviewsController::class, 'store'])->name('reviews.store');
Route::post('/reviews', [ReviewsController::class, 'store'])->name('reviews.store-listingless');

Route::get('/login', [AuthController::class, 'index'])->name('auth.login');
Route::get('/register', [AuthController::class, 'create'])->name('auth.create');
Route::post('/logon', [AuthController::class, 'logon'])->name('auth.logon');
Route::post('/register', [AuthController::class, 'store'])->name('auth.register');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::get('/homepage', [ListingController::class, 'index'])/*function () {
    return view('main.homepage');
})*/->name('main.homepage');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/profile', function () {
        return to_route('auth.profile');
    });
    Route::get('/profile/likes', [AuthController::class, 'profile'])->name('auth.profile');
    Route::get('/profile/news', [AuthController::class, 'profile_posts'])->name('auth.posts');
    Route::put('/profile', [AuthController::class, 'update'])->name('auth.update');
    Route::get('/profile/commands', [AuthController::class, 'profile_commands'])->name('auth.commands');
    Route::get('/profile/comments', [AuthController::class, 'profile_comments'])->name('auth.comments');
    Route::get('/profile/command/{command}/details', [AuthController::class, 'profile_command_details'])->name('auth.command-details');
    Route::delete('/profile/comments/{comment}/delete', [CommentController::class, 'destroy'])->name('comment.destroy');
});

Route::post('/add', [ListingController::class, 'store'])->name('listing.store');
Route::delete('/{listing}/delete', [ListingController::class, 'destroy'])->name('listing.destroy');
Route::delete('/profile/post/{news}/delete', [NewsController::class, 'destroy'])->name('delete.post');
Route::delete('/profile/commands/{command}/delete', [CommandController::class, 'destroy'])->name('command.destroy');
Route::post('/comment/add/{news}', [CommentController::class, 'store'])->name('comments.store');