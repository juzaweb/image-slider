<?php

namespace Juzaweb\Modules\ImageSlider\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Juzaweb\Modules\Core\FileManager\Traits\HasMedia;
use Juzaweb\Modules\Core\Models\Model;
use Juzaweb\Modules\Core\Traits\HasAPI;
use Juzaweb\Modules\Core\Traits\Translatable;
use Juzaweb\Modules\Core\Traits\UsedInFrontend;
use Juzaweb\Modules\Core\Translations\Contracts\Translatable as TranslatableContract;

class ImageSliderItem extends Model implements TranslatableContract
{
    use HasAPI, Translatable, HasUuids, HasMedia, UsedInFrontend;

    protected $table = 'image_slider_items';

    protected $fillable = [
        'image_slider_id',
        'new_tab',
        'link',
        'display_order',
    ];

    protected $casts = [
        'new_tab' => 'boolean',
    ];

    public $translatedAttributes = [
        'title',
        'description',
        'locale',
    ];

    public $mediaChannels = [
        'image',
    ];

    protected $appends = [
        'image',
    ];

    public function slider(): BelongsTo
    {
        return $this->belongsTo(ImageSlider::class, 'image_slider_id');
    }

    public function scopeWhereInFrontend(Builder $builder, bool $cache): Builder
    {
        return $builder->withTranslation()
            ->with(['media' => function ($query) use ($cache) {
                if ($cache) {
                    $query->cacheFor(3600);
                }
            }])
            ->orderBy('display_order', 'asc');
    }

    public function getImageAttribute(): ?string
    {
        return $this->getFirstMediaUrl('image');
    }
}
