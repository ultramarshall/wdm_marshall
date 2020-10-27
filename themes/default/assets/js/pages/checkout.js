$(document).ready(function(){
	$('#province').select2({minimumResultsForSearch: -1});
	$('#city').select2({minimumResultsForSearch: -1});
    $('#subdistrict').select2({minimumResultsForSearch: -1});
	$('#kurir, #kurir_detail').select2({minimumResultsForSearch: -1});
});

$('#province').on('change', function() {
    id = $(this).val();
    $('#group-subdistrict').addClass('d-none');
    $('#group-city').removeClass('d-none');
    rajaongkir.kota(id, '#city');
})

$('#city').on('change', function() {
    var id = $(this).val();
    $('#group-subdistrict').removeClass('d-none');
    rajaongkir.kecamatan(id, '#subdistrict');
    $("#id_kota").val(id);
})

$('#subdistrict').on('change', function() {
    $('#group-address').removeClass('d-none');
})

$('#check-addr').on('change', function(){
    var check = $(this).prop('checked');
    if (check === false) {
        $('#form-dropship').css('height','auto')
    } else {
        $('#form-dropship').css('height','0px')
    }
})

$('#kurir').on('change', function(){
    $.ajax({
        url: modul_name + '/service-courier',
        data: { 
            weight : $('#total_weight').val(),
            destination : $('#destination').val(),
            kurir : $("#kurir option:selected").val()
        },
        type: "POST",
        success: function(result) {
            data = JSON.parse(result).cost;
            var arr = new Array();
            $.each(data, function(i, item) {
                var new_data = {id: item.cost[0].value, text: item.service + ' (' +item.description + ')'};
                arr.push(new_data);
            });
            $('#kurir_detail').empty();
            $('#kurir_detail').select2({data:arr});

            var ongkir = data[0].cost[0].value;
            $('#ongkir').text(accounting.formatMoney(ongkir, 'Rp ', 0));
            var total_harga = parseInt($('#cart_total').val()) + parseInt(ongkir);
            $('.checkout_total').text(accounting.formatMoney(total_harga, 'Rp ', 0))
        }
    })
})

$('#kurir_detail').on('change', function(){
    var ongkir = $("#kurir_detail option:selected").val();
    var total_harga = parseInt($('#cart_total').val()) + parseInt(ongkir);
    $('#ongkir').text(accounting.formatMoney(ongkir, 'Rp ', 0));
    $('.checkout_total').text(accounting.formatMoney(total_harga, 'Rp ', 0))
})

$('#pay-button').click(function (event) {
    // $(this).attr("disabled", "disabled");
    var ongkos_kirim = $("#kurir_detail option:selected").val();
    var total_harga = $('#cart_total').val();
    // var product_qty = parseInt($('#product_qty').val());
    // console.log(product_qty);
    $.ajax({
        url: base_url + 'payment/token',
        cache: false,
        type: "POST",
        data: { 
            ongkos_kirim : ongkos_kirim,
            total_harga : total_harga
        },
        success: function(data) {

            var resultType = document.getElementById('result-type');
            var resultData = document.getElementById('result-data');
            function changeResult(type,data){
                $("#result-type").val(type);
                $("#result-data").val(JSON.stringify(data));
                //resultType.innerHTML = type;
                //resultData.innerHTML = JSON.stringify(data);
            }
            snap.pay(data, {

                onSuccess: function(result){
                    changeResult('success', result);
                    $("#payment-form").submit();
                },
                onPending: function(result){
                    changeResult('pending', result);
                    $("#payment-form").submit();
                },
                onError: function(result){
                    changeResult('error', result);
                    $("#payment-form").submit();
                }
            });
        }
    });

    event.preventDefault();
});