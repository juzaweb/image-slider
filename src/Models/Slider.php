<?php

namespace Juzaweb\ImageSlider\Models;

use Illuminate\Database\Eloquent\Model;
use Juzaweb\Traits\ResourceModel;

/**
 * Juzaweb\ImageSlider\Models\Slider
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Slider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider query()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereFilter($params = [])
 * @mixin \Eloquent
 */
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
