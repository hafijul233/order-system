{
    crud.field('allowed_login').onChange(function (field) {
        crud.field('password')
            .require(field.value == '1')
            .show(field.value == '1');
        
        crud.field('password_confirmation')
            .require(field.value == '1')
            .show(field.value == '1');
            
    }).change();
}
(window.jQuery);