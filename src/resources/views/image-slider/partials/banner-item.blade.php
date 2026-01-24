<li>
    <div class="row banner-item">
        <input type="hidden" class="banner-id" name="items[{{ $marker }}][id]" value="{{ $item->id ?? '' }}">

        <div class="col-md-3">
            {{ Field::image(__('image-slider::translation.banner'), "items[{$marker}][image]", ['value' => $item->image ?? '']) }}
        </div>

        <div class="col-md-8">
            {{ Field::text(__('image-slider::translation.title'), "items[{$marker}][title]", ['value' => @$item->title]) }}

            {{ Field::textarea(__('image-slider::translation.description'), "items[{$marker}][description]", ['value' => @$item->description]) }}

            <div class="form-group">
                <label class="form-label">{{ __('image-slider::translation.link') }}</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="items[{{ $marker }}][link]" autocomplete="off"
                        value="{{ @$item->link }}">
                    <div class="input-group-append">
                        <span class="input-group-text" id="basic-addon2">
                            <input type="checkbox" name="items[{{ $marker }}][new_tab]" value="1"
                                @if (@$item->new_tab == 1) checked @endif>
                            {{ __('image-slider::translation.open_in_new_tab') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-1">
            <a href="#" class="text-danger remove-banner">
                <i class="fas fa-times-circle"></i>
            </a>
        </div>
    </div>
</li>
