<?php

namespace Juzaweb\ImageSlider\Http\Datatable;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;
use Juzaweb\Abstracts\DataTable;
use Juzaweb\ImageSlider\Models\Slider;

class SliderDatatable extends DataTable
{
    /**
     * Columns datatable
     *
     * @return array
     */
    public function columns()
    {
        return [
            'name' => [
                'label' => trans('juim::content.name'),
                'formatter' => [$this, 'rowActionsFormatter']
            ],
            'created_at' => [
                'label' => trans('juzaweb::app.created_at'),
                'width' => '15%',
                'align' => 'center',
                'formatter' => function ($value, $row, $index) {
                    return jw_date_format($row->created_at);
                }
            ]
        ];
    }

    /**
     * Query data datatable
     *
     * @param array $data
     * @return Builder
     */
    public function query($data)
    {
        $query = Slider::query();

        if ($keyword = Arr::get($data, 'keyword')) {
            $query->where('name', 'like', '%'. $keyword .'%');
        }

        if ($status = Arr::get($data, 'status')) {
            if (!is_null($status)) {
                $query->where('status', '=', $status);
            }
        }

        return $query;
    }

    public function bulkActions($action, $ids)
    {
        switch ($action) {
            case 'delete':
                Slider::destroy($ids);
                break;
        }
    }
}
