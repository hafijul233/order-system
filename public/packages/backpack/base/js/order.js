{
    function loadCustomer(id) {
        $.get(APP_URL + `/api/customer-detail/${id}`, function (response) {
            console.log(response);

            let name = $('#orderable_name');
            name.val('');
            name.prop('readonly', false);
            name.val(response.data?.name);

            let email = $('#orderable_email');
            email.val('');
            email.prop('readonly', false);
            email.val(response.data?.email);

            let phone = $('#orderable_phone');
            phone.val('');
            phone.prop('readonly', false);
            phone.val(response.data?.phone);
        });
    }

    $(document).ready(() => {
        $("select[name*='customer_id']").change(() => {

            $("select[name*='company_id']").empty().trigger('change');

            let customer_id = $("select[name*='customer_id']").val();
            if (customer_id) {
                loadCustomer(customer_id);
            }
        });
    });
}
(window.jQuery);
