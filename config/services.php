<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'sms' => [
        'api_url' => env('SMS_API_URL'),
        'api_key' => env('SMS_API_KEY'),
        'sender_id' => env('SMS_API_SENDER_ID')
    ],

    'bkash_pgw' => [
        'api_url' => env('BKASH_PGW_API_URL'),
        'app_key' => env('BKASH_PGW_APP_KEY'),
        'app_secret' => env('BKASH_PGW_APP_SECRET'),
        'username' => env('BKASH_PGW_USERNAME'),
        'password' => env('BKASH_PGW_PASSWORD'),
        'token_lifetime' => 3600,
        'callback_url' => env('BKASH_PGW_CALLBACK_URL', 'https://bafskbus.ideasolutionbd.com'),
    ],

];
