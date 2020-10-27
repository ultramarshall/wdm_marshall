$(document).ready(function(){
	cari_ajax({}, "target", modul_name + '/load-data');
})

$(document).on('click', '#btn-oke', function(){
	cari_ajax({txt: $('#txt').val()}, "target", modul_name + '/load-data');
})

