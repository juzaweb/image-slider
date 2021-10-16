<?php

namespace Juzaweb\ImageSlider\Http\Controllers\Backend;

use Illuminate\Support\Facades\Validator;
use Juzaweb\ImageSlider\Http\Datatable\SliderDatatable;
use Juzaweb\Traits\ResourceController;
use Juzaweb\ImageSlider\Models\Slider;
use Juzaweb\Http\Controllers\BackendController;

class SliderController extends BackendController
{
    use ResourceController;

    protected $viewPrefix = 'juim::slider';

    protected function validator(array $attributes)
    {
        $validator = Validator::make($attributes, [
            'name' => 'required|string|max:250',
        ]);

        return $validator;
    }

    protected function getDataTable()
    {
        return new SliderDatatable();
    }
    
    public function parseDataForSave(array $attributes)
    {
        $titles = $attributes['title'] ?? [];
        $links = $attributes['link'] ?? [];
        $images = $attributes['image'];
        $descriptions = $attributes['description'] ?? [];
        $newTab = $attributes['new_tab'] ?? [];

        $content = [];
        foreach ($titles as $key => $title) {
            $content[] = [
                'title' => $title,
                'link' => $links[$key] ?? null,
                'image' => $images[$key] ?? null,
                'description' => $descriptions[$key] ?? null,
                'new_tab' => $newTab[$key] ?? 0,
            ];
        }
    
        $attributes['content'] = $content;

        return $attributes;
    }

    protected function getModel()
    {
        return Slider::class;
    }

    protected function getTitle()
    {
        return trans('juim::content.sliders');
    }
}
