@php
    $horizontalTabs = $crud->getTabsType()=='horizontal' ? true : false;
    $tabWithError = (function() use ($crud) {
        if(! session()->get('errors')) {
            return false;
        }
        foreach(session()->get('errors')->getBags() as $bag => $errorMessages) {
            foreach($errorMessages->getMessages() as $fieldName => $messages) {
                if(array_key_exists($fieldName, $crud->getCurrentFields()) && array_key_exists('tab', $crud->getCurrentFields()[$fieldName])) {
                    return $crud->getCurrentFields()[$fieldName]['tab'];
                }
            }
        }
        return false;
    })();
@endphp

@if ($crud->getFieldsWithoutATab()->filter(function ($value, $key) { return $value['type'] != 'hidden'; })->count())
<div class="card">
    <div class="card-body row">
    @include('crud::inc.show_fields', ['fields' => $crud->getFieldsWithoutATab()])
    </div>
</div>
@else
    @include('crud::inc.show_fields', ['fields' => $crud->getFieldsWithoutATab()])
@endif

<div class="tab-container {{ $horizontalTabs ? '' : 'container'}} mb-2">

    <div class="nav-tabs-custom {{ $horizontalTabs ? '' : 'row'}}" id="form_tabs">
        <ul class="nav {{ $horizontalTabs ? 'nav-tabs' : 'flex-column nav-pills'}} {{ $horizontalTabs ? '' : 'col-md-3' }}" role="tablist">
            @foreach ($crud->getTabs() as $k => $tab)
                <li role="presentation" class="nav-item">
                    <a href="#tab_{{ Str::slug($tab) }}"
                        aria-controls="tab_{{ Str::slug($tab) }}"
                        role="tab"
                        tab_name="{{ Str::slug($tab) }}"
                        data-toggle="tab"
                        class="nav-link {{ isset($tabWithError) && $tabWithError ? ($tab == $tabWithError ? 'active' : '') : ($k == 0 ? 'active' : '') }}"
                        >{{ $tab }}</a>
                </li>
            @endforeach
        </ul>

        <div class="tab-content p-0 {{$horizontalTabs ? '' : 'col-md-9'}}">

            @foreach ($crud->getTabs() as $k => $tab)
            <div role="tabpanel" class="tab-pane {{ isset($tabWithError) && $tabWithError ? ($tab == $tabWithError ? ' active' : '') : ($k == 0 ? ' active' : '') }}" id="tab_{{ Str::slug($tab) }}">

                <div class="row">
                @include('crud::inc.show_fields', ['fields' => $crud->getTabFields($tab)])
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>

@push('crud_fields_styles')
    <style>
        .nav-tabs-custom {
            box-shadow: none;
        }
        .nav-tabs-custom > .nav-tabs.nav-stacked > li {
            margin-right: 0;
        }

        .tab-pane .form-group h1:first-child,
        .tab-pane .form-group h2:first-child,
        .tab-pane .form-group h3:first-child {
            margin-top: 0;
        }

        /*
            when select2 is multiple and it's not on the first displayed tab the placeholder would
            not display correctly because the element was not "visible" on the page (hidden by tab)
            thus getting `0px` width. This makes sure that the placeholder element is always 100% width
            by preventing the select2 inline style (0px) from applying using !important
        */
        .select2-search__field {
            width: 100% !important;
        }
    </style>
@endpush

