<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://cms.juzaweb.com
 */

namespace Juzaweb\Modules\ImageSlider\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageSliderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
			'name' => ['required'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.image' => ['required', 'string'],
            'items.*.title' => ['required', 'string'],
            'items.*.description' => ['nullable', 'string'],
            'items.*.link' => ['required', 'string'],
		];
    }
}
