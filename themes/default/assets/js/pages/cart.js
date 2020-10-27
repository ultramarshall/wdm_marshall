$(document).on('click', '#btn-kode-promo', function(){
    kode_promo = $('#code').val();
    url = base_url + 'cart/check-promo-code';
    cari_ajax({kode: kode_promo}, 'kode-promosi', url);
})

$(document).on('click', '#btn-qty', function() {
    var el = $(this).attr('data-action');
    var rowid = $(this).attr('data-id');
    var qty = $(this).closest('div').find('#qty')
    if(el == "max") {
        quantity = (parseInt(qty.val())+1);
        qty.val(quantity);
        cart.update({row_id: rowid,qty: parseInt(quantity)});
    }
    if(el == "min" && parseInt(qty.val())!=1){
        quantity = (parseInt(qty.val())-1);
        qty.val(quantity);
        cart.update({row_id: rowid,qty: parseInt(quantity)});
    }
    update_total()
});

$(document).on('click', '.delete-item', function() {
    var rowid = $(this).attr('data-id');
    cart.delete({
        rowid: rowid,
    });
    update_total()
});

function update_total() {
    show_spinner('subtotal')
    $.ajax({
        type     : 'post',
        url      : base_url + 'cart/update-total',
        success  : function(response) {
            var total = accounting.formatMoney(response);
            close_spinner('subtotal')
            $('#subtotal').text('Rp ' + total);
        }
    });
}

