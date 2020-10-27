$(function(){
	$("form").submit(function(e){
		looding('light',$(this));
	})
})
	
function pesan_toastr(pesan, tipe, title, posisi, progress){
	if (posisi === undefined) posisi = "toast-top-center";
    if (progress === undefined) progress = true;
	
	toastr.options = {
	  "closeButton": true,
	  "debug": false,
	  "newestOnTop": false,
	  "progressBar": progress,
	  "positionClass": posisi,
	  "preventDuplicates": false,
	  "onclick": null,
	  "showDuration": "300",
	  "hideDuration": "5000",
	  "timeOut": "5000",
	  "extendedTimeOut": "5000",
	  "showEasing": "swing",
	  "hideEasing": "linear",
	  "showMethod": "fadeIn",
	  "hideMethod": "fadeOut"
	}
	if (tipe=='err'){
		Command: toastr.error(pesan,title)
	}else if (tipe=='ajax'){
		Command: toastr.ajax(pesan,title)
	}else{
		Command: toastr.info(pesan,title)
	}
}

function stopLooding(parent){
	$(parent).unblock();
}


function looding(tipe, parent){
	if (tipe=='dark'){
		$(parent).block({
			message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>',
			overlayCSS: {
				backgroundColor: '#1B2024',
				opacity: 0.85,
				cursor: 'wait'
			},
			css: {
				border: 0,
				padding: 0,
				backgroundColor: 'none',
				color: '#fff'
			}
		});
	}else{
		 $(parent).block({
            message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>',
            overlayCSS: {
                backgroundColor: '#fff',
                opacity: 0.8,
                cursor: 'wait'
            },
            css: {
                border: 0,
                padding: 0,
                backgroundColor: 'none'
            }
        });
	}
}

