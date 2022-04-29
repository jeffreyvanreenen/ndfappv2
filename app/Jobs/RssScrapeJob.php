<?php

namespace App\Jobs;

use App\Models\RssItem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\RSSfeed;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class RssScrapeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $rss_feeds = RSSfeed::all();

        foreach ($rss_feeds as $rss_feed) {


            $xml = simplexml_load_file($rss_feed->url, 'SimpleXMLElement', LIBXML_NOCDATA);
            $source = $xml->channel->title;

            foreach ($xml->channel->item as $item) {
                try {
                    if (!empty($item->pubDate)) {
                        $pubDate = strftime("%Y-%m-%d %H:%M:%S", strtotime($item->pubDate));
                        $date = Carbon::now()->subHours(48);
                        if ($date >= $pubDate) {
                            continue;
                        }
                    } else {
                        $pubDate = null;
                        continue;
                    }

                    if (!empty($item->author)) {
                        $author = $item->author;
                    } else {
                        $author = $source;
                    }

                    $artikel = RssItem::firstOrCreate([
                        'title' => $item->title,
                        'link' => $item->link,
                    ],
                        [
                            'pubDate' => $pubDate,
                            'link' => $item->link,
                            'description' => $item->description,
                            'author' => $author,
                            'source' => $source,
                        ]);

                    //Updated at updaten
                    $rss_feed->touch();

                } catch (\Exception $e) {
                    Log::error($e);
                    continue;
                }
            }
        }
    }
}
