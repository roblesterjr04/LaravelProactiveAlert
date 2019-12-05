<?php

return [
    'default' => 'default_keyset', // the key of a configured keyset below.

    'keysets' => [
        'default_keyset' => [
            'site_id' => env('PROACTIVE_SITE_ID'),
            'consumer_key' => env('PROACTIVE_CONSUMER_KEY'),
            'consumer_secret' => env('PROACTIVE_CONSUMER_SECRET'),
            'token' => env('PROACTIVE_TOKEN'),
            'token_secret' => env('PROACTIVE_TOKEN_SECRET'),
            'domain' => env('PROACTIVE_DOMAIN'),
        ],

        // Add more key sets here to use different instances of the alert API.
    ]
];
