{
    crud.field('addressable[addressable_type]').onChange(function (field) {
            crud.field('name')
                .require(field.value == 'App\\Models\\Company');
    }).change();
} (window.jQuery);