$('#l_fakultas_no').on('change', function() {
	var package = {
		id: $('#l_fakultas_no').val()
	}
   
   
    $.ajax({
        type     : 'post',
        url      : base_url + 'data-mahasiswa/get-jurusan',
        data     : package,
        success  : function(response) {
            $('#l_jurusan_no').html(response)
        }
    });
})