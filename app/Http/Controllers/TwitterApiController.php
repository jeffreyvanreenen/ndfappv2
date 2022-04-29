<?php

namespace App\Http\Controllers;

use App\Models\TwitterList;
use App\Models\TwitterMedia;
use Illuminate\Http\Request;
use App\Models\TwitterFollow;
use App\Models\TwitterTweets;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class TwitterApiController extends Controller
{
    public function index()
    {
        $lijsten = TwitterList::all();
        $accounts = TwitterFollow::all();

        return Inertia::render('Twitter/Index')->with('lijsten', $lijsten)->with('accounts', $accounts);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required_without:listid|string|nullable|unique:twitter_follows',
            'listid' => 'required_without:username|numeric|nullable|unique:twitter_lists',
        ]);

        if(!empty($request->username))
        {
            $follow = new TwitterFollow;
            $follow->username = $request->username;
            $follow->save();
        }

        if(!empty($request->listid))
        {
            $list = new TwitterList;
            $list->list_id = $request->listid;
            $list->save();
        }

        return Redirect::route('twitter.index')->with('message','Succesvol toegevoegd!');;
    }
}
