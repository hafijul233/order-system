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

function calculatePayableAmount(subTotal) {
    let eleSubTotal = $("#item-subtotal");
    let eleSalesTax = $("#item-tax");
    let eleDiscount = $("#item-discount");
    let eleTotalAmount = $("#item-total-amount");

    eleSubTotal.val(parseFloat(subTotal).toFixed(2));
    eleTotalAmount.val(parseFloat(subTotal).toFixed(2));

}

function calculateOrderSummary() {
    const itemContainer = $(".container-repeatable-elements");

    var products = itemContainer.find(".repeatable-element");

    $("#item-total-item").val(products.length);

    var subtotal = 0;

    $(products).each(function(index, eleProductRow) {
        
        eleProductRow = $(eleProductRow);
    
        let eleProductSubTotal = eleProductRow.find(".product-subtotal");

        let productUnitPrice = parseFloat(eleProductRow.find('.product-unit-price').val());
        
        let productQty = parseFloat(eleProductRow.find('.product-quantity').val());
        
        let productBill = (productUnitPrice * productQty).toFixed(2);
        
        eleProductSubTotal.val(productBill);
        
        subtotal += parseFloat(productBill);
    });
    
    console.log(subtotal);

    calculatePayableAmount(subtotal);
}

function loadProductData(element, id) {
    
    const productRow = $(element).parent().parent();

    let eleProductName = productRow.find(".product-name");
    
    let eleProductUnitPrice = productRow.find('.product-unit-price');
    
    let eleProductDefaultQty = productRow.find('.product-quantity');

    $.get(APP_URL + `/api/product-detail/${id}`, function (response) {
        
        const productData = response.data;
        
        eleProductName.val(productData.name);
        
        eleProductUnitPrice.val(parseFloat(productData.price).toFixed(2));
        
        eleProductDefaultQty.val(productData.default_quantity ?? 1.00);
        
        calculateOrderSummary();
    });
}

{
    $(document).ready(() => {
        $("select[name*='customer_id']").change(() => {

            $("select[name*='company_id']").empty().trigger('change');

            let customer_id = $("select[name*='customer_id']").val();
            if (customer_id) {
                loadCustomer(customer_id);
            }
        });

        $(".add-repeatable-element-button").addClass("font-weight-bold btn-block p-2 mt-3");
    });

}
(window.jQuery);
