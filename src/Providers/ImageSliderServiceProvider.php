<?php

namespace Juzaweb\ImageSlider\Providers;

use Juzaweb\CMS\Facades\ActionRegister;
use Juzaweb\CMS\Support\ServiceProvider;
use Juzaweb\ImageSlider\ImageSliderAction;

class ImageSliderServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        ActionRegister::register(ImageSliderAction::class);
    }
}
