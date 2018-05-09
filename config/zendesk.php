<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Zendesk connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the connections setup for your application. Example
    | configuration has been included, but you may add as many connections as
    | you would like.
    |
    */

    'live' => [

        'subdomain' => env('ZENDESK_SUBDOMAIN'),

        'domain' => env('ZENDESK_DOMAIN'),

        'username' => env('ZENDESK_USERNAME'),

        'token' => env('ZENDESK_TOKEN'),

        'status' => env('ZENDESK_STATUS'),
    ],

    'test' => [

        'subdomain' => env('ZENDESK_TEST_SUBDOMAIN'),

        'domain' => env('ZENDESK_TEST_DOMAIN'),

        'username' => env('ZENDESK_TEST_USERNAME'),

        'token' => env('ZENDESK_TEST_TOKEN'),

        'status' => env('ZENDESK_TEST_STATUS'),
    ],


];