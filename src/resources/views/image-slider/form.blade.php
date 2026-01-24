@extends('core::layouts.admin')

@section('content')
    <form action="{{ $action }}" class="form-ajax" method="post">
        @if($model->exists)
            @method('PUT')
        @endif

        <div class="row">
            <div class="col-md-12">
                <a href="{{ $backUrl }}" class="btn btn-warning">
                    <i class="fas fa-arrow-left"></i> {{ __('image-slider::translation.back') }}
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> {{ __('image-slider::translation.save') }}
                </button>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-9">
                <x-card title="{{ __('image-slider::translation.information') }}">
                    {{ Field::text(__('image-slider::translation.name'), 'name', ['value' => $model->name]) }}
                </x-card>
            </div>

            <div class="col-md-3">
                <x-language-card :label="$model" :locale="$locale" />
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <x-card title="{{ __('image-slider::translation.banners') }}">
                    <ul id="banners" class="list-unstyled">
                        @foreach($model->items ?? [] as $index => $item)
                            @component('image-slider::image-slider.partials.banner-item', [
                                'marker' => $item->id ?? $index,
                                'item' => $item,
                            ])
                            @endcomponent
                        @endforeach
                    </ul>

                    <button type="button" class="btn btn-info add-banner">
                        <i class="fas fa-plus"></i> {{ __('image-slider::translation.add_banner') }}
                    </button>
                </x-card>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script type="text/html" id="banner-template" nonce="{{ csp_script_nonce() }}">
        @component('image-slider::image-slider.partials.banner-item', [
            'marker' => '__marker__',
            'banner' => null,
        ])
        @endcomponent
    </script>

    <script type="text/javascript" nonce="{{ csp_script_nonce() }}">
        $(function () {
            $("#banners").sortable();

            $("#banners").disableSelection();

            $(document).on('click', '.add-banner', function () {
                let temp = document.getElementById('banner-template').innerHTML;
                let length = ($("#banners li").length + 1);
                let newbanner = temp.replace(/__marker__/g, length);

                $("#banners").append(newbanner);
            });

            $("#banners").on('click', '.remove-banner', function (e) {
                e.preventDefault();
                let item = $(this);

                if (!item.closest('li').find('.banner-id').val()) {
                    item.closest('li').remove();
                    return;
                }

                Swal.fire({
                    title: '',
                    text: '{{ trans('image-slider::translation.are_you_sure_you_want_to_delete_this_banner') }}',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '{{ trans('core::translation.yes') }} !',
                    cancelButtonText: '{{ trans('core::translation.cancel') }} !',
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
        });
    </script>
@endsection
