

$(document).ready(function() {
    $("#l_varian").tagsinput({
        trimValue: true,
        confirmKeys: [9, 188],
    });
	$('.bootstrap-tagsinput').addClass('w-100');
    $('.bootstrap-tagsinput').find('input[type=text]').on('keydown', function(event){
        if (event.which == 9) {
            $('#l_varian').tagsinput('add', $(this).val(), {preventPost: true});
        	$(this).val('');
            return false;
        }
        if (event.which == 13) {
			$('.trumbowyg-editor').focus();
        	return false;
        }
    })
})


