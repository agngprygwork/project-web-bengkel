<?php

return [
    'merchant_id' => env('MIDTRANS_MERCHANT_ID'),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    'server_key' => env('MIDTRANS_SERVER_KEY'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'is_sanbox' => env('MIDTRANS_SANDBOX_MODE', true),

    'payment_methods' => [
        'credit_card',
        'bank_transfer',
        'qris',
        'gopay',
        'shopeepay',
        'other_ewallet'
    ],

    'bank_transfer_banks' => [
        'bca',
        'bni',
        'bri',
        'cimb',
        'mandiri',
        'permata'
    ],
];
