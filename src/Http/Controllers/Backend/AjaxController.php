<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\ImageSlider\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Juzaweb\Http\Controllers\BackendController;
use Juzaweb\ImageSlider\Models\Slider;

class AjaxController extends BackendController
{
    public function getSliders(Request $request)
    {
        $search = $request->get('search');

        $query = Slider::query();
        $query->select([
            'id',
            'name as text'
        ]);

        if ($search) {
            $query->where('name', 'like', '%'. $search .'%');
        }

        $paginate = $query->paginate(10);
        $data['results'] = $query->get();

        if ($paginate->nextPageUrl()) {
            $data['pagination'] = ['more' => true];
        }

        return response()->json($data);
    }
}
