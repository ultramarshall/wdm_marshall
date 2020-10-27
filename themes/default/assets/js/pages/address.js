$(document).ready(function() {
    $('.province').select2();
    $('.city').select2();
    $('.subdistric').select2();
});

$('.province').on('change', function() {
    id = $(this).val();
    $('#group-subdistrict').addClass('d-none');
    $('#group-city').removeClass('d-none');
    rajaongkir.kota(id, '#city');
})


$('.city').on('change', function() {
    var id = $(this).val();
    $('#group-subdistrict').removeClass('d-none');
    rajaongkir.kecamatan(id, '#subdistrict');
})

$(document).on('change', 'input[type=checkbox]', function() {
    var prop = $(this);
    var checked = prop.prop('checked');

    if (checked){
        $('.apa').prop('checked',false);
         $('.apa').parent().parent().parent().css('background','rgba(0, 0, 0, 0.43)');
        prop.prop('checked',true)
        prop.parent().parent().parent().css('background','hotpink');
    }
    else{
        prop.parent().parent().parent().css('background','rgba(0, 0, 0, 0.43)');
    }
});

$(document).on('click', '.simpan', function(){
    var url = modul_name + "/save-address";
    cari_ajax({
        provinsi: parseInt($("#province").val()),
        kota: parseInt($("#city").val()),
        kecamatan: parseInt($("#subdistrict").val()),
        kode_pos: $("#kode_pos").val(),
        alamat_rumah: $("#address_detail").val(),
    }, "addr", url);
    $('.modal-backdrop').remove();
    $('.modal').modal('hide');
    location.reload();
})

$(document).on('change', '.apa', function(){
    $.ajax({
        url: modul_name + '/is-default',
        type: 'post',
        dataType: 'json',
        data: { id : $(this).attr('data-id') },
        success: function(result) {
            console.log(result)
        },
        error: function(msg){
            console.log(msg)
        },
        complete: function(){
            // console.log('complete')
        }
    })
})