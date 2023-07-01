{
    crud.field('type').onChange(function(field) {
        
        if(field.value == 'bundle') {
            crud.field('products').show().require();
        } else {
            crud.field('products').hide();
            $("a[tab_name='item']").parent().hide();
        }
    }).change();
}(window.jQuery);