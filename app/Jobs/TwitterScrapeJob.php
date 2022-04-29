<?php

namespace App\Jobs;

use App\Models\TwitterFollow;
use App\Models\TwitterList;
use App\Models\TwitterMedia;
use App\Models\TwitterTweets;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class TwitterScrapeJob implements ShouldQueue
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

        //stap 1 - Zorgen dat alle gevolgde gebruikers geupdate zijn in de database (twitter userid enz.)
        try {
            $accounts = TwitterFollow::select('username')->where('tw_id', null)->get();

            $followed = array();
            foreach ($accounts as $account) {
                $followed[] = $account->username;
            }

            $followed = implode(",", $followed);

            if (!empty($followed)) {
                $url = 'https://api.twitter.com/2/users/by?usernames=' . $followed . '&user.fields=created_at&expansions=pinned_tweet_id&tweet.fields=author_id,created_at';
                $usersdata = json_decode($this->makeRequestToTwitterApi($url));

                foreach ($usersdata->data as $user) {
                    $twitterfollow = TwitterFollow::where('username', $user->username)->first();
                    $twitterfollow->name = $user->name;
                    $twitterfollow->tw_id = $user->id;
                    $twitterfollow->tw_created_at = strftime("%Y-%m-%d %H:%M:%S", strtotime($user->created_at));
                    $twitterfollow->save();
                }
            }
        } catch (\Exception $e) {
            Log::error($e);
        }

        //stap 2 - Timeline ophalen van gevolgde gebruikers
        try {
            $accounts = TwitterFollow::where('tw_id', '!=', null)->get();
            foreach ($accounts as $account) {
                $url = 'https://api.twitter.com/2/users/' . $account->tw_id . '/tweets?tweet.fields=created_at&expansions=author_id,attachments.media_keys&media.fields=url&max_results=10';
                $tweets = json_decode($this->makeRequestToTwitterApi($url));

                foreach ($tweets->data as $tweet) {
                    //Media toevoegen aan tweets
                    if (!empty($tweet->attachments)) {
                        $media_keys = array();
                        foreach ($tweet->attachments->media_keys as $item) {
                            $media_keys[] = $item;
                        }
                        $media_keys = json_encode($media_keys);

                        foreach ($tweets->includes->media as $media) {
                            $twittermedia = TwitterMedia::firstOrCreate([
                                'media_key' => $media->media_key,
                                'type' => $media->type,
                                'url' => $media->url,
                            ]);
                        }

                    } else {
                        $media_keys = null;
                    }

                    //tweet toevoegen
                    $twittertweets = TwitterTweets::firstOrCreate([
                        'tw_id' => $tweet->id,
                        'author_id' => $tweet->author_id,
                        'text' => $tweet->text,
                        'tw_created_at' => strftime("%Y-%m-%d %H:%M:%S", strtotime($tweet->created_at)),
                        'tw_user_id' => $tweets->includes->users[0]->id,
                        'tw_username' => $tweets->includes->users[0]->username,
                        'tw_name' => $tweets->includes->users[0]->name,
                        'media' => $media_keys,
                        'bron' => 'follow_'.$account->id,
                    ]);

                    //media key reset
                    $media_keys = null;
                }

            }
        } catch (\Exception $e) {
            Log::error($e);
        }

        //Stap 3 - Lijsten ophalen van Twitter
        try {
            $lists = TwitterList::all();

            foreach ($lists as $list) {
                $listid = $list->list_id;

                $url = 'https://api.twitter.com/2/lists/' . $listid . '/tweets?tweet.fields=created_at&expansions=author_id,attachments.media_keys&media.fields=url&max_results=10';
                $tweets = json_decode($this->makeRequestToTwitterApi($url));

                //Media toevoegen aan tweets
                foreach ($tweets->data as $tweet) {
                    if (!empty($tweet->attachments)) {
                        $media_keys = array();
                        foreach ($tweet->attachments->media_keys as $item) {
                            $media_keys[] = $item;
                        }
                        $media_keys = json_encode($media_keys);

                        foreach ($tweets->includes->media as $media) {
                            $twittermedia = TwitterMedia::firstOrCreate([
                                'media_key' => $media->media_key,
                                'type' => $media->type,
                                'url' => $media->url,
                            ]);
                        }

                    } else {
                        $media_keys = null;
                    }

                    $twittertweets = TwitterTweets::firstOrCreate([
                        'tw_id' => $tweet->id,
                        'author_id' => $tweet->author_id,
                        'text' => $tweet->text,
                        'tw_created_at' => strftime("%Y-%m-%d %H:%M:%S", strtotime($tweet->created_at)),
                        'tw_user_id' => $tweets->includes->users[0]->id,
                        'tw_username' => $tweets->includes->users[0]->username,
                        'tw_name' => $tweets->includes->users[0]->name,
                        'media' => $media_keys,
                        'bron' => 'lijst_'.$listid,
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error($e);
        }


    }

    public function getBearerToken()
    {
        $consumer_api_key = rawurldecode(config('services.twitter_api.key'));
        $consumer_api_secret = rawurldecode(config('services.twitter_api.secret'));

        $base64_key = base64_encode($consumer_api_key . ':' . $consumer_api_secret);

        $url = 'https://api.twitter.com/oauth2/token?grant_type=client_credentials';

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "authorization: Basic " . $base64_key,
                "cache-control: no-cache",
                "content-type: application/x-www-form-urlencoded"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }

    public function makeRequestToTwitterApi($url)
    {
        $bearer = json_decode($this->getBearerToken());
        $access_token = $bearer->access_token;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer " . $access_token,
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }
}
