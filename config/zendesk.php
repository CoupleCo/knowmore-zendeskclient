<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the connections below you wish to use as
    | your default connection for all work. Of course, you may use many
    | connections at once using the manager class.
    |
    */

    'default' => 'test',

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