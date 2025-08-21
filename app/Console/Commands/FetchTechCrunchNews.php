<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\rssFeeds;

class FetchTechCrunchNews extends Command
{
    protected $signature = 'rss:fetch-techcrunch';
    protected $description = 'Fetch latest TechCrunch news and store in DB';

    public function handle()
    {
        $controller = new RssFeeds();
        $controller->fetchTechCrunch();
        $this->info('TechCrunch news fetched successfully!');
    }
}

