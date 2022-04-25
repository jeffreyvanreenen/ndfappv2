<?php

namespace App\Http\Controllers;

class FacebookApiController extends Controller
{
    public function index()
    {
        $url = 'https://graph.facebook.com/namensdefamilie/feed?fields=id,name,message,story,created_time,link,description,caption,attachments{media,type,subattachments}&limit=100';
        dd($this->makeRequestToFacebookApi($url));
    }

    public function getBearerToken()
    {
        $facebook_app_id = rawurldecode(config('services.facebook_api.id'));
        $facebook_app_secret = rawurldecode(config('services.facebook_api.secret'));

        $url = 'https://graph.facebook.com/oauth/access_token?client_id='.$facebook_app_id.'&client_secret='.$facebook_app_secret.'&grant_type=client_credentials';

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET",
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

    public function makeRequestToFacebookApi($url)
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
