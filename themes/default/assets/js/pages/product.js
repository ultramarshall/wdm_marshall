$(document).ready(function(){
    var slider = $('#lightSlider').lightSlider({
        gallery: true,
        item: 1,
        thumbItem: 5,
        slideMargin: 0,
        speed: 500,
        auto: true,
        loop: true,
        onSliderLoad: function() {
            $('#lightSlider').removeClass('cS-hidden');
        }
    });


    url = base_url + 'ajax/comment';
    cari_ajax({id: $('#idnya').val()}, 'comment', url);


    
});

$(document).on('click', '#btn-qty', function() {
    el = $(this).attr('data-value');
    if(el == "max")
        $('#qty').val((parseInt($('#qty').val())+1))
    if(el == "min" && parseInt($('#qty').val())!=1)
        $('#qty').val((parseInt($('#qty').val())-1))
})


$(document).on('click', '.btn-add-cart', function(e) {
    cart.add({
        id: parseInt($('#idnya').val()),
        qty: parseInt($('#qty').val()),
        price: parseInt($('#price').val()),
        name: $('#name').val(),
        varian: $(document).find('.checked-active').attr('data-varian'),
        url: base_url + 'cart/add-cart'
    });
})

 $(document).on('click', '.o-varian', function(){
    $('.o-varian').prop('checked', false);
    $('.btn-varian').removeClass('checked-active');
    $(this).prop('checked', true);
    $(this).next().addClass('checked-active');
});



 

