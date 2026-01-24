<?php

use Juzaweb\Modules\Core\Facades\RouteResource;
use Juzaweb\Modules\ImageSlider\Http\Controllers\ImageSliderController;

RouteResource::admin('image-sliders', ImageSliderController::class);
