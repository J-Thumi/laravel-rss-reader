<?php

namespace App\Http\Controllers;

use App\Models\News;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class rssFeeds extends Controller
{

    public function showGoogleNews(Request $request)
    {
     // Default: show last 1 day
        $daysAgo = $request->input('days', 1);

        // Example: Technology category (could be dynamic)
        $category = $request->input('category', 'technology');

        $rssUrl = "https://news.google.com/rss/search?q={$category}&hl=en-US&gl=US&ceid=US:en";
        $response = Http::get($rssUrl);
        $rss = simplexml_load_string($response->body());

        $cutoffDate = Carbon::now()->subDays($daysAgo);
        $items = [];

        foreach ($rss->channel->item as $item) {
            $published = Carbon::parse((string) $item->pubDate);

            if ($published->greaterThanOrEqualTo($cutoffDate)) {
                $items[] = [
                    'title' => (string) $item->title,
                    'link' => (string) $item->link,
                    'published_at' => $published,
                    'description' => (string) $item->description,
                ];
            }
        }

        $page = $request->input('page', 1);
        $perPage = 12;
        $offset = ($page - 1) * $perPage;

        $paginatedItems = new LengthAwarePaginator(
            array_slice($items, $offset, $perPage),
            count($items),
            $perPage,
            $page,
            ['path' => route('google-news', ['category' => $category, 'days' => $daysAgo])]
        );

        return view('google-news', [
            'items' => $paginatedItems,
            'daysAgo' => $daysAgo,
            'category' => $category
        ]);


    }
    public function fetchTechCrunch()
    {
        $response = Http::get('https://techcrunch.com/feed/');
        $rss = simplexml_load_string($response->body());

        foreach ($rss->channel->item as $item) {
            $link = (string) $item->link;

            // Skip if already exists
            if (News::where('link', $link)->exists()) {
                continue;
            }

            // Fetch article HTML
            $html = Http::get($link)->body();
            preg_match('/<meta property="og:image" content="([^"]+)"/', $html, $matches);
            $imageUrl = $matches[1] ?? null;

            $localImagePath = null;
            if ($imageUrl) {
                $filename = 'rss/' . Str::random(20) . '.jpg';
                $imgData = Http::get($imageUrl)->body();
                Storage::disk('public')->put($filename, $imgData);
                $localImagePath = Storage::url($filename);
            }

            News::create([
                'title' => (string) $item->title,
                'description' => (string) $item->description,
                'link' => $link,
                'image' => $localImagePath,
                'published_at' => \Carbon\Carbon::parse($item->pubDate),
            ]);
        }

        return 'News fetched successfully!';
    }

    public function showNews()
    {
        $items = News::latest('published_at')->paginate(6);
        return view('rss', compact('items'));
    }
}
