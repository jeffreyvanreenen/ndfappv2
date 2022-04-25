<?php

namespace App\Http\Controllers;

use App\Jobs\RssScrapeJob;
use App\Jobs\TwitterScrapeJob;
use App\Models\RSSfeed;
use App\Models\RssItem;
use App\Models\SourceCatagory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\RssfeedSourcecategorie;


class RSSfeedsController extends Controller
{
    public function index()
    {
        $rsses = RSSfeed::orderBy('title')->with('SourceCategories')->get();
        return Inertia::render('Bronnen/Rss/Index')->with('rsses', $rsses);
    }

    public function create()
    {
        $sourcecategorys = SourceCatagory::orderBy('name')->get();

        return Inertia::render('Bronnen/Rss/Create')->with('sourcecategorys', $sourcecategorys);

    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'url' => 'required|active_url|unique:r_s_sfeeds',
            'sourcecategorys' => 'nullable|array',
        ]);

        try {
            $xml = simplexml_load_file($request->url, 'SimpleXMLElement', LIBXML_NOCDATA);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Geen XML Bestand!');
        }

        $omschrijving = $xml->channel->title;

        if ($xml->channel->image->url != null) {
            $logo = $xml->channel->image->url;
        } else {
            $logo = 'https://pbs.twimg.com/profile_images/578844000267816960/6cj6d4oZ_400x400.png';
        }

        if ($xml->channel->description != null) {
            $description = $xml->channel->description;
        } else {
            $description = null;
        }

        if ($xml->channel->language != null) {
            $language = $xml->channel->language;
        } else {
            $language = null;
        }

        if ($xml->channel->copyright != null) {
            $copyright = $xml->channel->copyright;
        } else {
            $copyright = null;
        }

        if ($xml->channel->pubDate != null) {
            $pubDate = $xml->channel->pubDate;
        } else {
            $pubDate = null;
        }

        if ($xml->channel->lastBuildDate != null) {
            $lastBuildDate = $xml->channel->lastBuildDate;
        } else {
            $lastBuildDate = null;
        }

        $rssfeed = new RSSfeed;
        $rssfeed->image_url = $logo;
        $rssfeed->title = $omschrijving;
        $rssfeed->description = $description;
        $rssfeed->language = $language;
        $rssfeed->pubDate = strftime("%Y-%m-%d %H:%M:%S", strtotime($pubDate));
        $rssfeed->lastBuildDate = strftime("%Y-%m-%d %H:%M:%S", strtotime($lastBuildDate));
        $rssfeed->copyright = $copyright;
        $rssfeed->url = $request->url;
        $rssfeed->save();

        foreach ($request->sourcecategorys as $sourcecategory) {
            $rssfeedsourcecatagory = new RssfeedSourcecategorie;
            $rssfeedsourcecatagory->rssfeed_id = $rssfeed->id;
            $rssfeedsourcecatagory->source_categorie_id = $sourcecategory;
            $rssfeedsourcecatagory->save();
        }


        return redirect()->route('rss.index')->with('message', 'Succesvol toegevoegd!');
    }

    public function show($RSSfeed)
    {
        $items = RssItem::where('source', $RSSfeed)->orderByDesc('pubDate')->get();

        return Inertia::render('Bronnen/Rss/Show')->with('items', $items)->with('curpage', $RSSfeed);

    }

    public function edit(RSSfeed $RSSfeed)
    {
        //
    }

    public function update(Request $request, RSSfeed $RSSfeed)
    {
        //
    }

    public function destroy(RSSfeed $RSSfeed)
    {
        //
    }

    public function scrape()
    {
       $feeds = RSSfeed::all();
        foreach ($feeds as $feed) {
            $this->dispatch(new RssScrapeJob($feed->id));
       }
        $this->dispatch(new TwitterScrapeJob());
    }
}
