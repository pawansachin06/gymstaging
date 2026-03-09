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

    'google' => [
        'maps' => [
            'key' => env('GOOGLE_MAPS_API_KEY', env('GOOGLE_MAPS_GEOCODING_API_KEY', '')),
        ],
    ],

    'stripe' => [
        'model' => App\Models\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'live' => [
            'account_id' => env('STRIPE_ACCOUNT_ID', ''),
            'client_id' => env('STRIPE_KEY', ''),
            'client_secret' => env('STRIPE_SECRET'),
            'webhook_secret' => env('STRIPE_WEBHOOK_SECRET', ''),
        ],
        'sandbox' => [
            'account_id' => env('STRIPE_ACCOUNT_ID_SANDBOX', ''),
            'client_id' => env('STRIPE_CLIENT_ID_SANDBOX', ''),
            'client_secret' => env('STRIPE_CLIENT_SECRET_SANDBOX', ''),
            'webhook_secret' => env('STRIPE_WEBHOOK_SECRET_SANDBOX', ''),
        ],
    ],

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'setting' =>  [
        [
              'action' => 'contact_us', // Google reCAPTCHA required paramater
              'threshold' => 0.2, // score threshold
              'score_comparision' => false // if this is true, the system will do score comparsion against your threshold for the action
          ],
          [
              'action' => 'signup',
              'threshold' => 0.2,
              'score_comparision' => true
          ],
      ]
];
