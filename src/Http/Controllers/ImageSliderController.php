<?php

namespace Juzaweb\Modules\ImageSlider\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Juzaweb\Modules\Core\Facades\Breadcrumb;
use Juzaweb\Modules\Core\Http\Controllers\AdminController;
use Juzaweb\Modules\ImageSlider\Http\DataTables\ImageSlidersDatatable;
use Juzaweb\Modules\ImageSlider\Http\Requests\ImageSliderActionsRequest;
use Juzaweb\Modules\ImageSlider\Http\Requests\ImageSliderRequest;
use Juzaweb\Modules\ImageSlider\Models\ImageSlider;
use Juzaweb\Modules\ImageSlider\Models\ImageSliderItem;

class ImageSliderController extends AdminController
{
    public function index(ImageSlidersDatatable $dataTable)
    {
        Breadcrumb::add(__('image-slider::translation.image_sliders'));

        $createUrl = action([static::class, 'create']);

        return $dataTable->render(
            'image-slider::image-slider.index',
            compact('createUrl')
        );
    }

    public function create()
    {
        Breadcrumb::add(__('image-slider::translation.image_sliders'), admin_url('imagesliders'));

        Breadcrumb::add(__('image-slider::translation.create_image_slider'));

        $locale = $this->getFormLanguage();
        $backUrl = action([static::class, 'index']);

        return view(
            'image-slider::image-slider.form',
            [
                'model' => new ImageSlider(),
                'action' => action([static::class, 'store']),
                'backUrl' => $backUrl,
                'locale' => $locale,
            ]
        );
    }

    public function edit(string $id)
    {
        Breadcrumb::add(__('image-slider::translation.image_sliders'), admin_url('imagesliders'));

        Breadcrumb::add(__('image-slider::translation.create_image_sliders'));

        $model = ImageSlider::findOrFail($id);
        $backUrl = action([static::class, 'index']);
        $locale = $this->getFormLanguage();

        $model->load(['items.translations', 'items.media']);

        return view(
            'image-slider::image-slider.form',
            [
                'action' => action([static::class, 'update'], [$id]),
                'model' => $model,
                'backUrl' => $backUrl,
                'locale' => $locale,
            ]
        );
    }

    public function store(ImageSliderRequest $request)
    {
        $locale = $this->getFormLanguage();
        $model = DB::transaction(
            function () use ($request, $locale) {
                $data = $request->validated();
                $model = new ImageSlider($data);
                $model->save();

                $index = 1;
                foreach ($request->input('items', []) as $item) {
                    $sliderItem = new ImageSliderItem($item);
                    $sliderItem->image_slider_id = $model->id;
                    $sliderItem->display_order = $index;
                    $sliderItem->setDefaultLocale($locale);
                    $sliderItem->save();

                    $sliderItem->attachOrUpdateMedia($item['image'], 'image');
                    $index++;
                }

                return $model;
            }
        );

        return $this->success([
            'redirect' => action([static::class, 'index']),
            'message' => __('image-slider::translation.slider_name_created_successfully', ['name' => $model->name]),
        ]);
    }

    public function update(ImageSliderRequest $request, string $id)
    {
        $model = ImageSlider::findOrFail($id);
        $locale = $this->getFormLanguage();

        $model = DB::transaction(
            function () use ($request, $model, $locale) {
                $data = $request->validated();
                $model->update($data);

                $itemIds = [];
                $index = 1;
                foreach ($request->input('items', []) as $item) {
                    $sliderItem = ImageSliderItem::firstOrNew(['id' => $item['id'] ?? null]);
                    $sliderItem->image_slider_id = $model->id;
                    $sliderItem->display_order = $index;
                    $sliderItem->setDefaultLocale($locale);
                    $sliderItem->fill($item);
                    $sliderItem->save();

                    $sliderItem->attachOrUpdateMedia($item['image'], 'image');
                    $itemIds[] = $sliderItem->id;
                    $index++;
                }

                $model->items()
                    ->whereNotIn('id', $itemIds)
                    ->delete();

                return $model;
            }
        );

        return $this->success([
            'redirect' => action([static::class, 'index']),
            'message' => __('image-slider::translation.slider_name_updated_successfully', ['name' => $model->name]),
        ]);
    }

    public function bulk(ImageSliderActionsRequest $request)
    {
        $action = $request->input('action');
        $ids = $request->input('ids', []);

        $models = ImageSlider::whereIn('id', $ids)->get();

        foreach ($models as $model) {
            if ($action === 'activate') {
                $model->update(['active' => true]);
            }

            if ($action === 'deactivate') {
                $model->update(['active' => false]);
            }

            if ($action === 'delete') {
                $model->delete();
            }
        }

        return $this->success([
            'message' => __('image-slider::translation.bulk_action_performed_successfully'),
        ]);
    }
}
