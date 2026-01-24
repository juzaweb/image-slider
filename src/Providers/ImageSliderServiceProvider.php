<?php

namespace Juzaweb\Modules\ImageSlider\Providers;

use Illuminate\Support\Facades\File;
use Juzaweb\Modules\Core\Facades\Menu;
use Juzaweb\Modules\Core\Providers\ServiceProvider;

class ImageSliderServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        //

        $this->booted(
            function () {
                $this->registerMenus();
            }
        );
    }

    public function register(): void
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/migrations');
        $this->app->register(RouteServiceProvider::class);
    }

    protected function registerMenus(): void
    {
        if (File::missing(storage_path('app/installed'))) {
            return;
        }

        Menu::make('image-sliders', function () {
            return [
                'title' => __('image-slider::translation.image_sliders'),
                'parent' => 'appearance',
            ];
        });
    }

    protected function registerConfig(): void
    {
        $this->publishes([
            __DIR__ . '/../config/config.php' => config_path('image-slider.php'),
        ], 'image-slider-config');
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'image-slider');
    }

    protected function registerTranslations(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'image-slider');
        $this->loadJsonTranslationsFrom(__DIR__ . '/../resources/lang');
    }

    protected function registerViews(): void
    {
        $viewPath = resource_path('views/modules/image-slider');

        $sourcePath = __DIR__ . '/../resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', 'image-slider-module-views']);

        $this->loadViewsFrom($sourcePath, 'image-slider');
    }
}
