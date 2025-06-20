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

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],


    'bird' => [
        'key' => env('MESSAGEBIRD_API_KEY', 'NOT_SET'),
    ],


    'stripe' => [
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],


    'stripe_prices' => [
            "Vétérinaire" => "price_1Qt7FALfFfjrGNYJkNbSgTSl",
            "Dentiste animalier" => "prod_RmUqEQkRsrnVlW",
            "Ostéopathe" => "prod_RmUr72NHAXbaR3",
            "Physiothérapeute animalier" => "prod_RmUrFOWJcbfhKi",
            "Kinésiologue animalier" => "prod_RmUrU7SbI7lkmK",
            "Nutritionniste animalier" => "prod_RmUsnD415OlxQ9",
            "Toiletteur" => "prod_RmUsRMXNRsHHmR",
            "Chenil" => "prod_RmUsNDeXySC6yq",
            "Éleveur spécialisé" => "prod_RmUtIB4QpJEBRM",
            "Éducateur canin" => "prod_RmUtRwopc1w4p8",
            "Pet Sitter" => "prod_RmUtlWScnSd12c",
        ],





];
