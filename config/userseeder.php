<?php

use Illuminate\Support\Carbon;

return [

    'users' => [
        '1' => [
            'name' => env('USERSEEDER_1_NAME'),
            'email' => env('USERSEEDER_1_EMAIL'),
            'password' => env('USERSEEDER_1_PASSWORD'),
            'azure_id' => env('USERSEEDER_1_AZURE_ID'),
            'active' => env('USERSEEDER_1_ACTIVE'),
        ],

        '2' => [
            'name' => env('USERSEEDER_2_NAME'),
            'email' => env('USERSEEDER_2_EMAIL'),
            'password' => env('USERSEEDER_2_PASSWORD'),
            'azure_id' => env('USERSEEDER_2_AZURE_ID'),
            'active' => env('USERSEEDER_2_ACTIVE'),
        ],
    ],

    ];
