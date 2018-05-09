<?php

/*
 * This file is part of Laravel Pusher.
 *
 * (c) Pusher, Ltd (https://pusher.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

//declare(strict_types=1);

namespace NomorePackage\Zendeskclient;

use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;

/**
 * This is the Pusher service provider class.
 *
 * @author Vincent Klaiber <hello@vinkla.com>
 */
class ZendeskServiceProvider extends ServiceProvider {




    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/zendesk.php' => config_path('zendesk.php'),
        ]);

//         use the vendor configuration file as fallback
//         $this->mergeConfigFrom(
//             __DIR__.'/config/config.php', 'skeleton'
//         );
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register() {}

    public function provides() {
        return ['zendesk'];
    }
}
