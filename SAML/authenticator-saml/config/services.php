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

    'idp' => [
        'idp_login' => env('IDP_LOGIN'),
        'idp_registered' => env('IDP_REGISTERED'),
        'idp_logout' => env('IDP_LOGOUT'),
    ],

    'totp' => [
        'totp_api_login' => env('TOTP_API_LOGIN'),
        'totp_api_authenticator' => env('TOTP_API_AUTHENTICATOR'),
        'totp_api_verify' => env('TOTP_API_VERIFY'),
        'totp_project_name' => env('TOTP_PROJECT_NAME'),
    ],

];
