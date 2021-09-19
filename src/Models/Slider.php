<?php

namespace Juzaweb\ImageSlider\Models;

use Illuminate\Database\Eloquent\Model;
use Juzaweb\Traits\ResourceModel;

class Slider extends Model
{
    use ResourceModel;

    protected $fieldName = 'name';
    protected $table = 'juim_sliders';
    protected $fillable = [
        'name',
        'content'
    ];

    protected $casts = [
        'content' => 'array'
    ];
}
