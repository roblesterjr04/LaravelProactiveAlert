<?php

return [
    'default' => 'default_keyset', // the key of a configured keyset below.

    'keysets' => [
        'default_keyset' => [ //This key
            'site_id' => env('PROACTVE_SITE_ID'),
            'app_key' => env('PROACTIVE_APP_KEY'),
            'app_secret' => env('PROACTIVE_APP_SECRET'),
            'token' => env('PROACTIVE_TOKEN'),
            'token_secret' => env('PROACTIVE_TOKEN_SECRET')
        ]
    ]
]
