<?php

namespace Juzaweb\Modules\ImageSlider\Http\DataTables;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Juzaweb\Modules\Core\DataTables\Action;
use Juzaweb\Modules\Core\DataTables\BulkAction;
use Juzaweb\Modules\Core\DataTables\Column;
use Juzaweb\Modules\Core\DataTables\DataTable;
use Juzaweb\Modules\ImageSlider\Models\ImageSlider;

class ImageSlidersDatatable extends DataTable
{
    protected string $actionUrl = 'image-sliders/bulk';

    public function query(ImageSlider $model): Builder
    {
        return $model->newQuery();
    }

    public function getColumns(): array
    {
        return [
			Column::checkbox(),
			Column::id(),
			Column::actions(),
			Column::editLink('name', admin_url('image-sliders/{id}/edit'), __('image-slider::translation.name')),
			Column::createdAt()
		];
    }

    public function actions(Model $model): array
    {
        return [
            Action::edit(admin_url("image-sliders/{$model->id}/edit"))->can('image-sliders.edit'),
            Action::delete()->can('image-sliders.delete'),
        ];
    }

    public function bulkActions(): array
    {
        return [
            BulkAction::delete()->can('image-sliders.delete'),
        ];
    }
}
