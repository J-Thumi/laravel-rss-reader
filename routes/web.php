<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Fetch RSS feed (example: TechCrunch)
    $response = Http::get('https://techcrunch.com/feed/');

    // Convert RSS (XML) to SimpleXMLElement
    $rss = simplexml_load_string($response->body());

    // Convert to array of items
    $items = [];
    foreach ($rss->channel->item as $item) {
        $items[] = [
            'title' => (string) $item->title,
            'link'  => (string) $item->link,
            'date'  => (string) $item->pubDate,
            'desc'  => (string) $item->description,
        ];
    }

    return view('rss', compact('items'));
});
