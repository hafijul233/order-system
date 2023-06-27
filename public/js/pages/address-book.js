{
    crud.field('addressable[addressable_type]').onChange(function (field) {
        if(field.value == 'App\\Models\\Company') {
            crud.field('name').wrapper.addClass('required');
        } else {
            crud.field('name').wrapper.removeClass('required');
        }
    }).change();
} (window.jQuery);