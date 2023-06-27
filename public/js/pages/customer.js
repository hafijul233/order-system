{
    crud.field('allowed_login').onChange(function (field) {
        crud.field('password').show(field.value == '1').wrapper.addClass('required');
        crud.field('password_confirmation').show(field.value == '1').wrapper.addClass('required');
    }).change();
}
(window.jQuery);