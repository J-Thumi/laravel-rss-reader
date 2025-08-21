<?php

use App\Http\Controllers\rssFeeds;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/techcrunch', [rssFeeds::class,'showNews'])->name('techcrunch');
Route::get('/google', [rssFeeds::class,'showGoogleNews'])->name('google-news');

