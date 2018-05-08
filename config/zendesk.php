<?php

/*
 * This file is part of Laravel Pusher.
 *
 * (c) Pusher, Ltd (https://pusher.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

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
        'subdomain' => 'your-subdomain',

        'domain' => 'your-domain',

        'username' => 'your-username',

        'token' => 'your-token',

        'status' => 'on || off',
    ],

    'test' => [

        'subdomain' => 'your-subdomain',

        'domain' => 'your-domain',

        'username' => 'your-username',

        'token' => 'your-token',

        'status' => 'on || off',
    ],


];


//ZENDESK_TEST_DOMAIN=https://nomoretest.zendesk.com/api/v2/
//ZENDESK_TEST_SUBDOMAIN=nomoretest
//ZENDESK_TEST_USERNAME=martinvintherp@gmail.com
//ZENDESK_TEST_TOKEN=FWteGHbFX64hTFdzGquHUjd6Jt2juKTSLTmRBvss
//ZENDESK_TEST_STATUS=on