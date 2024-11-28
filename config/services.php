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

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'stripe' => [ 'secret' => env('51Q1JAvRugefEodTIul3f0S855lUtvGJTBSeZq6dUuDLcyXZfX9mS2tSpHXcI12UiWSsXsdI47pom27v3V5rgz20E00jsfwkeNL'), 
    'public' => env('51Q1JAvRugefEodTI5VbU9wTiEpN9VTJiUqhZudobzS3M7s4Z6g2XQexjh5iEdwiaqwSG2e4B3XGLNJYi5X9lOyEw00Bs13TeX0'), ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

];
