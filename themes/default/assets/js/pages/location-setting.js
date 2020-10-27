$(document).ready(function(){
	// $('#l_kota').closest('.form-inline').hide()
	// $('#l_kecamatan').closest('.form-inline').hide()
});

$('#l_provinsi').on('change', function() {
    id = $(this).val();
    rajaongkir.kota(id, '#l_kota');
    $('#l_kota').closest('.form-inline').show()
})

$('#l_kota').on('change', function() {
    id = $(this).val();
    rajaongkir.kecamatan(id, '#l_kecamatan');
	$('#l_kecamatan').closest('.form-inline').show()
})