<?php

// SSLCommerz configuration

return [
    'projectPath' => env('PROJECT_PATH'),
    'apiDomain' => env("API_DOMAIN_URL", "https://sandbox.sslcommerz.com"),
    'apiCredentials' => [
        'store_id' => env("STORE_ID"),
        'store_password' => env("STORE_PASSWORD"),
    ],
    'apiUrl' => [
        'make_payment' => "/gwprocess/v4/api.php",
        'transaction_status' => "/validator/api/merchantTransIDvalidationAPI.php",
        'order_validate' => "/validator/api/validationserverAPI.php",
        'refund_payment' => "/validator/api/merchantTransIDvalidationAPI.php",
        'refund_status' => "/validator/api/merchantTransIDvalidationAPI.php",
    ],
    'connect_from_localhost' => env("IS_LOCALHOST", true),
    'success_url' => '/user/sslcommerz-success',
    'failed_url' => '/user/sslcommerz-failed',
    'cancel_url' => '/user/sslcommerz-cancel',
    'ipn_url' => '/user/sslcommerz-ipn',
];
