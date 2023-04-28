{{-- icon picker input --}}
@php
    // if no iconset was provided, set the default iconset to Font-Awesome
    $field['iconset'] = $field['iconset'] ?? 'fontawesome';
@endphp

@include('crud::fields.inc.wrapper_start')
    <label>{!! $field['label'] !!}</label>
    @include('crud::fields.inc.translatable_icon')

    <div>
        <button type="button" class="btn btn-light iconpicker btn-sm btn-block py-2" data-rows="4" data-cols="6" role="icon-selector"></button>
        <input
            type="hidden"
            name="{{ $field['name'] }}"
            data-iconset="{{ $field['iconset'] }}"
            bp-field-main-input
            data-init-function="bpFieldInitIconPickerElement"
            value="{{ old_empty_or_null($field['name'], '') ??  $field['value'] ?? $field['default'] ?? '' }}"
            @include('crud::fields.inc.attributes')
        >
    </div>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
@include('crud::fields.inc.wrapper_end')

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}

    {{-- The chosen font --}}
    @switch ($field['iconset'])
        @case('ionicon')
            @loadOnce('packages/bootstrap-iconpicker/icon-fonts/ionicons-1.5.2/css/ionicons.min.css')
            @break
        @case('weathericon')
            @loadOnce('packages/bootstrap-iconpicker/icon-fonts/weather-icons-1.2.0/css/weather-icons.min.css')
            @break
        @case('mapicon')
            @loadOnce('packages/bootstrap-iconpicker/icon-fonts/map-icons-2.1.0/css/map-icons.min.css')
            @break
        @case('octicon')
            @loadOnce('packages/bootstrap-iconpicker/icon-fonts/octicons-2.1.2/css/octicons.min.css')
            @break
        @case('typicon')
            @loadOnce('packages/bootstrap-iconpicker/icon-fonts/typicons-2.0.6/css/typicons.min.css')
            @break
        @case('elusiveicon')
            @loadOnce('packages/bootstrap-iconpicker/icon-fonts/elusive-icons-2.0.0/css/elusive-icons.min.css')
            @break
        @case('meterialdesign')
            @loadOnce('packages/bootstrap-iconpicker/icon-fonts/material-design-1.1.1/css/material-design-iconic-font.min.css')
            @break
        @default
            @loadOnce('packages/bootstrap-iconpicker/icon-fonts/font-awesome-5.12.0-1/css/all.min.css')
            @break
    @endswitch

    {{-- FIELD EXTRA CSS --}}
    @push('crud_fields_styles')
        {{-- Bootstrap-Iconpicker --}}
        @loadOnce('packages/bootstrap-iconpicker/bootstrap-iconpicker/css/bootstrap-iconpicker.min.css')
    @endpush

    {{-- FIELD EXTRA JS --}}
    @push('crud_fields_scripts')
        {{-- Bootstrap-Iconpicker --}}
        @loadOnce('packages/bootstrap-iconpicker/bootstrap-iconpicker/js/bootstrap-iconpicker.bundle.min.js')

        {{-- Bootstrap-Iconpicker - set hidden input value --}}
        @loadOnce('bpFieldInitIconPickerElement')
        <script>
            function bpFieldInitIconPickerElement(element) {
                var $iconset = element.attr('data-iconset');
                var $iconButton = element.siblings('button[role=icon-selector]');
                var $icon = element.attr('value');

                // we explicit init the iconpicker on the button element.
                // this way we can init the iconpicker in InlineCreate as in future provide aditional configurations.
                    $($iconButton).iconpicker({
                        iconset: $iconset,
                        icon: $icon
                    });

                    element.siblings('button[role=icon-selector]').on('change', function(e) {
                        $(this).siblings('input[type=hidden]').val(e.icon).trigger('change');
                    });

                    element.on('CrudField:enable', function(e) {
                        $iconButton.removeAttr('disabled');
                    });

                    element.on('CrudField:disable', function(e) {
                        $iconButton.attr('disabled', 'disabled');
                    });
            }
        </script>
        @endLoadOnce
    @endpush
