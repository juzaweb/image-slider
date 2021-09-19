@extends('juzaweb::layouts.backend')

@section('content')

    @component('juzaweb::components.form_resource', [
        'model' => $model
    ])

        <div class="row">
            <div class="col-md-12">

            <div class="form-group">
                <label class="col-form-label" for="name">@lang('juzaweb::app.name')</label>
                <input type="text" name="name" class="form-control" id="name" value="{{ $model->name }}" autocomplete="off" required>
            </div>

                    <ul id="banners" class="mt-5">
                        @if($model->content)
                            @php
                                $banners = $model->content ?? [];
                            @endphp
                            @foreach($banners as $index => $banner)
                                @php
                                    $banner = (object) $banner;
                                @endphp
                                <li>
                                    <div class="row banner-item">
                                        <div class="col-md-3">
                                            @component('juzaweb::components.form_image', [
                                                'label' => trans('juim::app.banner'),
                                                'name' => 'image[]',
                                                'value' => $banner->image ?? ''
                                            ])@endcomponent
                                        </div>

                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label class="form-label">{{ trans('juzaweb::app.title') }}</label>
                                                <input type="text" class="form-control" name="title[]" autocomplete="off" value="{{ @$banner->title }}">
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label">{{ trans('juzaweb::app.description') }}</label>
                                                <textarea class="form-control" name="description[]">{{ @$banner->description }}</textarea>
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label">{{ trans('juzaweb::app.link') }}</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" name="link[]" autocomplete="off" value="{{ @$banner->link }}">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="basic-addon2"><input type="checkbox" name="new_tab[]" value="1" @if(@$banner->new_tab == 1) checked @endif> {{ trans('juzaweb::app.open_new_tab') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                <div class="col-md-1">
                                    <a href="javascript:void(0)" class="text-danger remove-banner"><i class="fa fa-times-circle"></i></a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                @endif
            </ul>

                    <div class="text-right mt-5">
                        <a href="javascript:void(0)" class="add-banner">{{ trans('juzaweb::app.add_new_banner') }}</a>
                    </div>
                </div>

        </div>
    @endcomponent

<template id="banner-template">
    <li>
        <div class="row banner-item">
            <div class="col-md-3">
                @component('juzaweb::components.form_image', [
                    'label' => trans('juim::app.banner'),
                    'name' => 'image[]'
                ])@endcomponent
            </div>

            <div class="col-md-8">
                <div class="form-group">
                    <label class="form-label">{{ trans('juzaweb::app.title') }}</label>
                    <input type="text" class="form-control" name="title[]" autocomplete="off" value="">
                </div>

                <div class="form-group">
                    <label class="form-label">{{ trans('juzaweb::app.description') }}</label>
                    <textarea class="form-control" name="description[]"></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">{{ trans('juzaweb::app.link') }}</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="link[]" autocomplete="off">
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2"><input type="checkbox" class="link-new-tab" value="1"> {{ trans('juzaweb::app.open_new_tab') }}</span>
                            <input type="hidden" name="new_tab[]" class="new-tab" value="0">
                        </div>
                    </div>
                </div>
                <input type="hidden" name="image[]" id="image-{length}">
            </div>

            <div class="col-md-1">
                <a href="javascript:void(0)" class="text-danger remove-banner">
                    <i class="fa fa-times-circle fa-2x"></i>
                </a>
            </div>
        </div>
    </li>
</template>

<script type="text/javascript">

    $("#banners").sortable();

    $("#banners").disableSelection();

    $("body").on('click', '.add-banner', function () {
        let temp = document.getElementById('banner-template').innerHTML;
        let length = $("#banners li").length + 1;
        let newbanner = replace_template(temp, {
            'length': length
        });

        $("#banners").append(newbanner);
        $('.load-media').filemanager('image', {prefix: '/admin-cp/file-manager'});
    });

    $("#banners").on('click', '.remove-banner', function () {
        let item = $(this);
        Swal.fire({
            title: '',
            text: '{{ trans('mymo::app.are_you_sure_you_want_to_delete_this_banner') }}',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '{{ trans('juzaweb::app.yes') }} !',
            cancelButtonText: '{{ trans('juzaweb::app.cancel') }} !',
        }).then((result) => {
            if (result.value) {
                item.closest('li').remove();
            }
        });
    });

    $("#banners").on('change', '.link-new-tab', function () {
        if ($(this).is(':checked')) {
            $(this).closest('.input-group-append').find('.new-tab').val(1);
        }
        else {
            $(this).closest('.input-group-append').find('.new-tab').val(0);
        }
    });
</script>
@endsection
