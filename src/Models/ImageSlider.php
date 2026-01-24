<?php

namespace Juzaweb\Modules\ImageSlider\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Juzaweb\Modules\Core\Models\Model;
use Juzaweb\Modules\Core\Traits\HasAPI;
use Juzaweb\Modules\Core\Traits\UsedInFrontend;

class ImageSlider extends Model
{
    use HasAPI, HasUuids, UsedInFrontend;

    protected $table = 'image_sliders';

    protected $fillable = [
        'name',
    ];

    public function items()
    {
        return $this->hasMany(ImageSliderItem::class, 'image_slider_id');
    }

    public function scopeWhereInFrontend(Builder $builder, bool $cache): Builder
    {
        return $builder
            ->with(
                [
                    'items' => function($query) use ($cache) {
                        $query->whereFrontend();
                    }
                ]
            );
    }
}
