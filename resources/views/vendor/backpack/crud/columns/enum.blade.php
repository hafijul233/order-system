@php
    $column['value'] = $column['value'] ?? data_get($entry, $column['name']);
    if(function_exists('enum_exists') && !empty($column['value']))  {
        if($column['value'] instanceof \UnitEnum) {
            $column['value'] = isset($column['enum_function']) ? $column['value']->{$column['enum_function']}() : ($column['value'] instanceof \BackedEnum ? $column['value']->value : $column['value']->name);
        }else{
            if(isset($column['enum_class'])) {
                $enumClassReflection = new \ReflectionEnum($column['enum_class']);
                if ($enumClassReflection->hasConstant($column['value'])) {
                    $enumClass = $enumClassReflection->getConstant($column['value']);
                }
                
                $column['value'] = isset($column['enum_function']) ? $enumClass->{$column['enum_function']}() : $column['value'];
            }
        }
    }
@endphp

@include(isset($column['options']) ? 'crud::columns.select_from_array' : 'crud::columns.text')