{{-- enum --}}
@php
    $entity_model = $field['model'] ?? $field['baseModel'] ?? $crud->model;

    $field['value'] = old_empty_or_null($field['name'], '') ??  $field['value'] ?? $field['default'] ?? '';

    $possible_values = (function() use ($entity_model, $field) {
        $fieldName = $field['baseFieldName'] ?? $field['name'];
        // if developer provided the options, use them, no ned to guess.
        if(isset($field['options'])) {
            return $field['options'];
        }

        // if we are in a PHP version where PHP enums are not available, it can only be a database enum
        if(! function_exists('enum_exists')) {
            $options = $entity_model::getPossibleEnumValues($fieldName);
            return array_combine($options, $options);
        }

        // developer can provide the enum class so that we extract the available options from it
        $enumClassReflection = isset($field['enum_class']) ? new \ReflectionEnum($field['enum_class']) : false;

        if(! $enumClassReflection) {
            // check for model casting
            $possibleEnumCast = (new $entity_model)->getCasts()[$fieldName] ?? false;
            if($possibleEnumCast && class_exists($possibleEnumCast)) {
                $enumClassReflection = new \ReflectionEnum($possibleEnumCast);
            }
        }

        if($enumClassReflection) {
            $options = array_map(function($item) use ($enumClassReflection) {
                return $enumClassReflection->isBacked() ? [$item->getBackingValue() => $item->name] : $item->name;
            },$enumClassReflection->getCases());
            $options = is_multidimensional_array($options) ? array_replace(...$options) : array_combine($options, $options);
        }

        if(isset($field['enum_function']) && isset($options)) {
            $options = array_map(function($item) use ($field, $enumClassReflection) {
                if ($enumClassReflection->hasConstant($item)) {
                    return $enumClassReflection->getConstant($item)->{$field['enum_function']}();
                }
                return $item;
            }, $options);
            return $options;
        }

        // if we have the enum options return them
        if(isset($options)) {
            return $options;
        }

        // no enum options, can only be database enum
        $options = $entity_model::getPossibleEnumValues($field['name']);
        return array_combine($options, $options);
    })();


    if(function_exists('enum_exists') && !empty($field['value']) && $field['value'] instanceof \UnitEnum)  {
        $field['value'] = $field['value'] instanceof \BackedEnum ? $field['value']->value : $field['value']->name;
    }
@endphp

@include('crud::fields.inc.wrapper_start')
    <label>{!! $field['label'] !!}</label>
    @include('crud::fields.inc.translatable_icon')
    <select
        name="{{ $field['name'] }}"
        @include('crud::fields.inc.attributes')
        >

        @if ($entity_model::isColumnNullable($field['name']))
            <option value="">-</option>
        @endif

            @if (count($possible_values))
                @foreach ($possible_values as $key => $possible_value)
                    <option value="{{ $key }}"
                        @if ($field['value']==$key)
                            selected
                        @endif
                    >{{ $possible_value }}</option>
                @endforeach
            @endif
    </select>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
@include('crud::fields.inc.wrapper_end')
