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
     * Boot the service provider.
     *
     * @return void
     */
    public function boot() {

        $this->setupConfig();
    }

    /**
     * Setup the config.
     *
     * @return void
     */
    protected function setupConfig() {

        $source = realpath(__DIR__ . '/../config/zendesk.php');

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('zendesk.php')]);
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('zendesk');
        }

        $this->mergeConfigFrom($source, 'zendesk');
    }


}
