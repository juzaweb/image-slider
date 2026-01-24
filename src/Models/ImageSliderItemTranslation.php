<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://cms.juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\Modules\ImageSlider\Models;

use Juzaweb\Modules\Core\Models\Model;

class ImageSliderItemTranslation extends Model
{
    public $timestamps = false;

    protected $table = 'image_slider_item_translations';

    protected $fillable = [
        'image_slider_item_id',
        'locale',
        'title',
        'description',
    ];
}
