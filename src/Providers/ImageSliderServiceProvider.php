<?php

namespace Juzaweb\ImageSlider\Providers;

use Juzaweb\ImageSlider\Actions\MenuAction;
use Juzaweb\Support\ServiceProvider;

class ImageSliderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerAction([
            MenuAction::class
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
