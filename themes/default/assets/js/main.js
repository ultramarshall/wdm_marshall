

$.asm = {};
$.asm.panels = 1;

var select2;

function stopLooding(parent){
	$(parent).unblock();
}

function looding(tipe, parent){
	if (tipe=='dark'){
		$(parent).block({
			message: '<img class="m-auto" src="http://localhost/ailinmall/themes/default/assets/images/loader.svg" width="80px" height="80px"/>',
			overlayCSS: {
				backgroundColor: '#1B2024',
				opacity: 0.2,
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
            message: '<img class="m-auto" src="http://localhost/ailinmall/themes/default/assets/images/loader.svg" width="80px" height="80px"/>',
            overlayCSS: {
                backgroundColor: '#fff',
                opacity: 0.2,
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

function pesan_toastr(pesan, tipe, title, posisi, progress){
	if (posisi === undefined) posisi = "toast-bottom-right";
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
	if (tipe=='danger' || tipe=='warning' || tipe=='err'){
		Command: toastr.error(pesan,title)
	}else if (tipe=='ajax'){
		Command: toastr.ajax(pesan,title)
	}else{
		Command: toastr.info(pesan,title)
	}
}
	
$(function() {	
	
	var object = {};
    object[csrf_token_name] = Cookies.get(csrf_cookie_name);
	// console.log(Cookies.get(csrf_cookie_name));
    $.ajaxSetup({
        data: object
    });
    $(document).ajaxComplete(function () {
        object[csrf_token_name] = Cookies.get(csrf_cookie_name);
		$('input[name="'+csrf_token_name+'"]').val(Cookies.get(csrf_cookie_name));
        $.ajaxSetup({
            data: object
        });
    });
	
	$('form').submit(function() {
		object[csrf_token_name] = Cookies.get(csrf_cookie_name);
		$('input[name="'+csrf_token_name+'"]').val(Cookies.get(csrf_cookie_name));
		return true;
	});
	
	$("#slide_left").click(function(){
		if ($.asm.panels === 1) {
			 $.asm.panels = 2;
			  $('#pullout-6').animate({
					left: 0,
			  });
		} else if ($.asm.panels === 2) {
			 $.asm.panels = 1;
			$('#pullout-6').animate({
				left: -303,
			});
		}
	})
	
	$(document).on('change','.rupiah', function(){
		var jml=$(this).val().replace(/,/g,"")
		var nilai=parseFloat(jml);
		var value=accounting.formatMoney(nilai,'',0);
		$(this).val(value);
	});
	
	$("#datatables_filter").addClass("pull-right");
	$("#datatables_paginate").addClass("pull-right");
	// $("#datatables_filter").find("input[type='search']").attr("style","width:300px;");
	
	// $("[data-toggle = 'tooltip']").tooltip();
	
	 // start code for full screen
    $('.full_screen').on('click', function() {

        if (screenfull.enabled) {
            screenfull.toggle();
        }
    });
});

function rupiah(target){
	var jml=target.value.replace(/,/g,"")
	var nilai=parseInt(jml);
	var value=accounting.formatMoney(nilai);
	target.value=value;
};
	
function _maxLength(e,c)
{
	if(!e&&!e.getAttribute&&!e.value)
	{return}
	
	var f=parseInt(e.getAttribute("maxlength"),10);
	if(isNaN(f))
		{f=0}
	var d=e.parentNode.getElementsByTagName("input");
	if(d&&d[0])
		{var b=d[0];
		$('#span_'+c).html(b.value);
		}
	if(!b&&!b.value)
		{return}
	var a=e.value.length;
	if(a>f)
		{e.value=e.value.substring(0,f);b.value=0;
		$('#span_'+c).html(0);
		}
	else
		{b.value=f-a;
		$('#span_'+c).html(b.value);
		}
}

 function wheretoplace(){
	var myLeft = $(this).offset.top;
	alert(myLeft);
	if (myLeft<500) return 'top';
	return 'bottom';
}
function loader() {
	_maxLength;
	$("[data-toggle='tooltip']").tooltip();
	// $(".btn, .peta").popover({
	// 	trigger:'hover',
	// 	placement:"top",
	// 	html:"true",
	// 	container: 'body',
	// });
	$(".info-help").popover(
		{
		trigger:'click',
		placement:"top",
		animation: "true",
		html:"true",
		container: 'body',
	});
	$('.info-help').on('click', function (e) {
        $('.info-help').not(this).popover('hide');
    });
	
	
	$(document).on('click', function (e) {
		$('[data-toggle="popover"],[data-original-title]').each(function () {
			if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {                
				(($(this).popover('hide').data('bs.popover')||{}).inState||{}).click = false  // fix for BS 3.3.6
			}

		});
	});
	
	$(".datepicker").datetimepicker({
		timepicker:false,
		format:'d-m-Y',
		closeOnDateSelect:true,
		validateOnBlur:true,
		 mask:false
	});
	// $(".datetimepicker").datetimepicker({
		// format:'d-m-Y H:i',
		// closeOnDateSelect:false,
		// validateOnBlur:true,
		// mask:false
	// });
	$('.colorpicker-default').colorpicker({
		format: 'hex'
	});
	
	$('.colorpicker-default').colorpicker().on('changeColor', function(ev){
		$(this).css("background-color",ev.color.toHex());
		// bodyStyle.backgroundColor = ev.color.toHex();
    });
	
	$(".select2").select2({
		allowClear: false,
		width:'style'
	});
	
	$(".select3").select2({
		allowClear: false,
		width:'style',
		minimumResultsForSearch: Infinity
	});
	
	// $("[data-toggle = 'tooltip']").attr('data-original-title', 'New title').tooltip('show');
	
	 // $('.tokenfield').tokenfield();
	
    // output initial serialised data
	var updateOutput = function(e)
	{
		// console.log(e);
		var list   = e.length ? e : $(e.target),
			output = list.data('output');
		if (window.JSON) {
			if( typeof output != 'undefined' || output != null ){
				output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
			}
		} else {
			output.val('JSON browser support required for this demo.');
		}
	};

	// activate Nestable for list 2
	$('#nestable').nestable({
		group: 1
	})
	.on('change', updateOutput);
	
	$('#nestable-menu').on('click', function(e)
	{
		var target = $(e.target),
			action = target.data('action');
		if (action === 'expand-all') {
			$('.dd').nestable('expandAll');
		}
		if (action === 'collapse-all') {
			$('.dd').nestable('collapseAll');
		}
	});
	updateOutput($('#nestable').data('output', $('#nestable-output')));
	
	$(document).on('click','button.dd-expand',function(){
		$(this).hide();
	})
	$(document).on('click','button.dd-collapse',function(){
		$('button.dd-expand').show();
	})
	/*$(document).on('click','.btn', function(){
		var data_old = $(this).html();
		$(this).html("mohon tunggu...");
		$(this).attr("disabled","disabled");
	})*/
}

function selectCheck() {
	$('input[type="checkbox"]').click(function(){	
		var $checked = $(this).is(':checked');
		var $target = $(this).attr('target');
		var $subs = $(this).attr('sub-target');
		if($subs) {
			$target = $(this).attr('value');
			var $checkbox = $('input[data-parent="'+$target+'"]');
		} else {
			var $checkbox = $('input[name="'+$target+'"]');
		}
		$('input[type="checkbox"]').next().removeClass('input-error');
		$('input[type="radio"]').next().removeClass('input-error');		
		if($checked) {			
			$checkbox.prop('checked', 1);					
			$($checkbox).parents('.data tr').addClass('active');					
		}
		else {
			$checkbox.prop('checked', 0);	
			$($checkbox).parents('.data tr').removeClass('active');				
		}
	});
	
	$("li.delete").on("click", null, function(){
		var url= $(this).attr('url');
		var ket = Globals.confirm_del_one;
		$('p.question').html(ket);
		$('#confirmDelete').modal('show');
		$('#confirm').on('click', function(){
			//pesan_toastr('Mohon Tunggu','info','Prosess','toast-top-center');
			window.location.href=url;
		});
    });
	
	$('[target-radio], label[target], radio-name[target]').click(function(e){			
		var $target = $(this).attr('target-radio');
		var $type = $(this).attr('target-type');
		var $checkbox = $('input[data-name="'+$target+'"]');
		var $checked = $($checkbox).is(':checked');
		if($type == 'multiple')
		var $checkbox = $('input[name="'+$target+'"]');
		$('input[type="checkbox"]').next().removeClass('input-error');
		$('input[type="radio"]').next().removeClass('input-error');
		if($(e.target).is('.switch *, a[href]')) {
		} else {
			$('tr').removeClass('active');	
			if($checked) {
				$checkbox.prop('checked', 0);					
			}
			else {
				$checkbox.prop('checked', 1);	
				if($('tr')) $(this).addClass('active');
			}
		}
	});	
	
	$(".tool-help").click(function(){
		// looding($(this).parent());
		var parent = $(this).parent();
		var data={'id':modul_name};
		var target_combo = $(this);
		var url = "ajax/get_help";
		cari_ajax_combo("post", parent, data, target_combo, url, "load_help");
	})
}

function load_help(hasil){
	$("#modal_general").find(".modal-body").html(hasil.combo);
		$("#modal_general").modal("show");
}

function loadTable(url, display, idtbl) {
	if (idtbl === undefined) idtbl = "datatables";
	if (display === undefined) display = 0;
	if (url === undefined) url = "";
	if(url.length>5) {		
        var tr = true;
        var file = url;
	} else  {
		var tr = false;
        var file = null;
	}
	if(display>0){
		var numRec=display;
	}else{
		var numRec=10;
	}
	
	$('table#' + idtbl).show();
	if ($.isFunction($.fn.dataTable)) {
		oTable = $('table#' + idtbl).dataTable({
			responsive: true,
			"iDisplayLength": numRec,
			"processing": tr,
			"bServerSide": tr,
			"autoWidth": true,
			"sAjaxSource": file, 
			"bAutoWidth": false,
			"bScrollCollapse": true,
			"aLengthMenu": [[5, 10, 15, 25, 50, 100, 200, 500, 1000, -1], [5, 10, 15, 25, 50, 100, 200, 500, 1000, "All"]],
			"oLanguage": {
				"sProcessing": "",
				"sLengthMenu": Globals.sLengthMenu,
				"sZeroRecords": Globals.sZeroRecords,
				"sInfo": Globals.sInfo,
				"sInfoEmpty": Globals.sInfoEmpty,
				"sInfoFiltered": Globals.sInfoFiltered,
				"sSearch": Globals.sSearch,
				"oPaginate": {
					"sFirst": Globals.sFirst,
					"sPrevious": Globals.sPrevious,
					"sNext": Globals.sNext,
					"sLast": Globals.sLast,
				},
			},
			"fnDrawCallback": function( oSettings ) {
				selectCheck();
			}
		});
		
		$('table#' + idtbl + ' tbody').on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
			}
			else {
				oTable.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
			}
			// var data = oTable.fnGetData( this );
			// alert(data);
		});
		
		$('table#' + idtbl + ' th input[type="checkbox"]').parents('th').unbind('click.DT');
		if ($.isFunction($.fn.chosen) ) {
			$("select").chosen({disable_search_threshold: 10});
		}				
	}
}

function stopEnterKey(e){
	var evt = (e) ? e:((e) ? e : nuull);
	var node = (e.target) ? e.target : ((e.srcElement) ? e.srcElement : null);
	if ((e.keyCode==13) && (node.type == "text")) {return false;}
}

$('body').on('keydown', 'input:not(.notmove), select', function(e) {
	var self = $(this)
	  , form = self.parents('form:eq(0)')
	  , focusable
	  , next
	  , prev
	  ;

	if (e.shiftKey) {
		if (e.keyCode == 13) {
			focusable =   form.find('input,a,select,button').filter(':visible');
			prev = focusable.eq(focusable.index(this)-1); 

			if (prev.length) {
				prev.focus();
			} else {
				form.submit();
			}
			return false;
		}
	}
	else{
		if (e.keyCode == 13) {
			focusable = form.find('input,a,select,button').filter(':visible');
			next = focusable.eq(focusable.index(this)+1);
			if (next.length) {
				next.focus();
			} else {
				form.submit();
			}
			return false;
		}else if (e.keyCode == 40) {	
			focusable = form.find("input[name='" + $(this).attr("name") + "']").filter(':visible');
			next = focusable.eq(focusable.index(this)+1);
			if (next.length) {
				next.focus();
			} else {
				next = focusable.eq(focusable.index(0));
				next.focus();
			}
			return false;
		}else if (e.keyCode == 38) {	
			focusable = form.find("input[name='" + $(this).attr("name") + "']").filter(':visible');
			prev = focusable.eq(focusable.index(this)-1); 
			if (prev.length) {
				prev.focus();
			} else {
				next = focusable.eq(focusable.index(0));
				next.focus();
			}
			return false;
		}
	}
});

function set_setting(){
	var disc_standart=Globals.confirm_del_one;
}
$(document).off('keydown#barang_no');

$("table").on("click",".detail-img",function(){
	var kel="product";
	var nm_pic=$(this).attr("data-id");
	var data={"kel":kel,"nm_pic":nm_pic};
	var url=base_url + "ajax/get-detail-gambar-" + kel;
	looding($(this).parent());
	$.ajax({
		type:"POST",
		url:url,
		data:data,
		success:function(msg){
			stopLooding($(this).parent());
			$("#modal_general").find(".modal-body").html(msg);
			$("#modal_general").modal("show");
		},
		failed: function(msg){
			stopLooding($(this).parent());
			pesan_toastr('Error Load Database','err','Error','toast-top-center');
		},
		error: function(msg){
			stopLooding($(this).parent());
			pesan_toastr('Error Load Database','err','Error','toast-top-center');
		},
	});
	return false;
});

function show_spinner(id){
	$("#" + id).html(spinner);
}

function close_spinner(id){
	$("#" + id).html("");
}

function cari_ajax_combo(tipe, parent, data, target_combo, url, proses_result, sts_loading, pesan, title_msg){
	url = base_url + url;
	
	if(typeof(pesan) == "undefined")
		pesan='Error Load Database';
	if(typeof(title_msg) == "undefined")
		title_msg='Error';
	
	if(typeof(sts_loading) == "undefined")
		sts_loading=true;
	
	if (sts_loading)
		looding('light',parent);
	// looding('light',parent);
	if(typeof(proses_result) == "undefined")
		proses_result="";
	else if(proses_result.length==0){
		proses_result="";
	}
	$.ajax({
		type:tipe,
		url:url,
		data:data,
		dataType: "json",
		success:function(result){
			if (proses_result.length==0)	
				target_combo.html(result.combo)
			else
				window[proses_result](result);
			
			if (sts_loading)
				stopLooding(parent);
		},
		error:function(msg){
			// console.log(msg);
			if (sts_loading)
				stopLooding(parent);
			pesan_toastr(pesan, 'err', title_msg, 'toast-top-center');
		},
		complate:function(){
		}
	})
}

function cari_ajax(data, target, url){
	looding('light',$("#"+target));
	$.ajax({
		type:"post",
		url:url,
		data:data,
		success:function(result){	
			$("#"+target).html(result);
		},
		error:function($msg){
			pesan_toastr('Error Load Database','err','Error','toast-top-center');
		},
		complate:function(){
			stopLooding($("#"+target));
		}
	})
}

function remove_install(t,iddel,kel){
	if(typeof(kel) == "undefined")
		var kel='';
	
	if(confirm("Are you sure you want to permanently delete this transaction ?\nThis action cannot be undone")){
		var ri = t.parentNode.parentNode.rowIndex;
		looding('light',t);
		var form = {"iddel":iddel,"kel":kel}; 
		var url=base_url + modul_name +  '/del_child';
		if (iddel>"0"){
			$.ajax({
				type: "POST",
				url: url,
				data: form,
				dataType:'json',
				success: function(result){
					if (result.sts=='0'){
						pesan_toastr('Gagal Proses','err','Error','toast-top-center');
					}else{
						t.parentNode.parentNode.parentNode.deleteRow(ri-1);
						pesan_toastr(result.ket,'info','Info','toast-top-center');
					}
					stopLooding(t);
				},
				failed: function(msg){
					pesan_toastr('Gagal Proses','err','Error','toast-top-center');
					stopLooding(t);
				},
				error: function(msg){
					pesan_toastr('Gagal Proses','err','Error','toast-top-center');
					stopLooding(t);
				},
			});
		}else{
			t.parentNode.parentNode.parentNode.deleteRow(ri-1);
			pesan_toastr('Berhasil dihapus','info','Info','toast-top-center');
			stopLooding(t);
		}
	}
	return false;
}

$("#contextual-help-link-wrap").click(function(){
	var sts=$(this).attr('data-sts');
	if (sts=="0"){
		$(this).attr('data-sts','1');
		$("#screen-options-link-wrap").attr('data-sts','0');
		$("#contextual-help-wrap").show(500);
		$("#contextual-options-wrap").hide();
		$("#screen-options-link-wrap").hide();
	}else{
		$(this).attr('data-sts','0');
		$("#contextual-help-wrap").hide(500);
		$("#screen-options-link-wrap").show();
	}
})

$("#screen-options-link-wrap").click(function(){
	$("#contextual-options-wrap").toggle(500);
	var sts=$(this).attr('data-sts');
	if (sts=="0"){
		$(this).attr('data-sts','1');
		$("#screen-help-link-wrap").attr('data-sts','0');
		$("#contextual-options-wrap").show(500);
		$("#contextual-help-wrap").hide();
		$("#contextual-help-link-wrap").hide();
	}else{
		$(this).attr('data-sts','0');
		$("#contextual-options-wrap").hide(500);
		$("#contextual-help-link-wrap").show();
	}
})

$(document).on('click','span.btn-add',function(){
	loading(true);
	var url=base_url + 'ajax/add-option-combo';
	var attr = $(this).attr('data-param');
	var param='';
	if (typeof attr !== typeof undefined && attr !== false) {
	  param=attr;
	}

	$.ajax({
		type:"post",
		url:url,
		data:{target:$(this).attr('data-target'),combo:$(this).attr('data-combo'),label:$(this).attr('data-label'),fld:$(this).attr('data-fld'),param:param},
		success:function(result){
			loading(false);
			$("#modal_umum").find(".modal-body").html(result);
			$("#modal_umum").modal("show");
		},
		failed:function(msg){
			loading(false);
			pesan_toastr('Error Load Database','err','Error','toast-top-center');
		},
		error:function(msg){
			loading(false);
			pesan_toastr('Error Load Database','err','Error','toast-top-center');
		},
		complate:function(){
			loading(false);
		}
	})
})

$(document).on('click','span#proses_add_combo',function(){
	loading(true);
	var tombol = $(this);
	tombol.addClass('disabled');
	tombol.children('i').removeClass();
	tombol.children('i').addClass('fa fa-refresh fa-spin');
	var url=base_url + 'ajax/save-option-combo';
	$.ajax({
		type:"post",
		url:url,
		data:$("#form_input_modal").serialize(),
		dataType:'json',
		success:function(result){
			// console.log(result);
			var options, index, select, option;
			
			loading(false);
			select = document.getElementById(result.post.combo);
			if (result.post.id>0){
				select.options.add(new Option(result.post.txt_input, result.post.id));
				$("#" + result.post.combo).val(result.post.id).change();
			}
			$("#modal_umum").modal("hide");
		},
		failed:function(msg){
			loading(false);
			pesan_toastr('Error Load Database','err','Error','toast-top-center');
		},
		error:function(msg){
			loading(false);
			pesan_toastr('Error Load Database','err','Error','toast-top-center');
		},
		complete:function(){
			loading(false);
			tombol.children('i').removeClass();
			tombol.children('i').addClass('fa fa-save');
			tombol.removeClass('disabled');
		}
	})
})

function terbilang(bilangan){
	bilangan    = String(bilangan);
    var kalimat="";
    var angka   = new Array('0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0');
    var kata    = new Array('','Satu','Dua','Tiga','Empat','Lima','Enam','Tujuh','Delapan','Sembilan');
    var tingkat = new Array('','Ribu','Juta','Milyar','Triliun');
    var panjang_bilangan = bilangan.length;
     
    /* pengujian panjang bilangan */
    if(panjang_bilangan > 15){
        kalimat = "Diluar Batas";
    }else{
        /* mengambil angka-angka yang ada dalam bilangan, dimasukkan ke dalam array */
        for(i = 1; i <= panjang_bilangan; i++) {
            angka[i] = bilangan.substr(-(i),1);
        }
         
        var i = 1;
        var j = 0;
         
        /* mulai proses iterasi terhadap array angka */
        while(i <= panjang_bilangan){
            subkalimat = "";
            kata1 = "";
            kata2 = "";
            kata3 = "";
             
            /* untuk Ratusan */
            if(angka[i+2] != "0"){
                if(angka[i+2] == "1"){
                    kata1 = "Seratus";
                }else{
                    kata1 = kata[angka[i+2]] + " Ratus";
                }
            }
             
            /* untuk Puluhan atau Belasan */
            if(angka[i+1] != "0"){
                if(angka[i+1] == "1"){
                    if(angka[i] == "0"){
                        kata2 = "Sepuluh";
                    }else if(angka[i] == "1"){
                        kata2 = "Sebelas";
                    }else{
                        kata2 = kata[angka[i]] + " Belas";
                    }
                }else{
                    kata2 = kata[angka[i+1]] + " Puluh";
                }
            }
             
            /* untuk Satuan */
            if (angka[i] != "0"){
                if (angka[i+1] != "1"){
                    kata3 = kata[angka[i]];
                }
            }
             
            /* pengujian angka apakah tidak nol semua, lalu ditambahkan tingkat */
            if ((angka[i] != "0") || (angka[i+1] != "0") || (angka[i+2] != "0")){
                subkalimat = kata1+" "+kata2+" "+kata3+" "+tingkat[j]+" ";
            }
             
            /* gabungkan variabe sub kalimat (untuk Satu blok 3 angka) ke variabel kalimat */
            kalimat = subkalimat + kalimat;
            i = i + 3;
            j = j + 1;
        }
         
        /* mengganti Satu Ribu jadi Seribu jika diperlukan */
        if ((angka[5] == "0") && (angka[6] == "0")){
            kalimat = kalimat.replace("Satu Ribu","Seribu");
        }
    }
	kalimat +='Rupiah';
	return kalimat;
}

$(document).on('click','.preview_file',function(){
	var url=$(this).data('url');
	var kel=$(this).data('target');
	var file=$(this).data('file');
	var parent=$(this).closest('table');
	looding('light',parent);
	$.ajax({
		type:"post",
		url:url,
		data:{'url':url,'kel':kel,'file':file},
		success:function(result){
			stopLooding(parent);
			$("#modal_general").find(".modal-body").html(result);
			$("#modal_general").find("#myModalLabel").html("Preview File "+file);
			$("#modal_general").modal("show");
		},
		failed:function(msg){
			stopLooding(parent);
			pesan_toastr('Error Load Database','err','Error','toast-top-center');
		},
		error:function(msg){
			stopLooding(parent);
			pesan_toastr('Error Load Database','err','Error','toast-top-center');
		},
		complate:function(){
			stopLooding(parent);
		}
	})
})


function showMyImage(fileInput, gambar) {
	var files = fileInput.files;
	for (var i = 0; i < files.length; i++) {           
		var file = files[i];
		var imageType = /image.*/;     
		if (!file.type.match(imageType)) {
			continue;
		}           
		var img=document.getElementById(gambar);            
		img.file = file;    
		var reader = new FileReader();
		reader.onload = (function(aImg) { 
			return function(e) { 
				aImg.src = e.target.result; 
			}; 
		})(img);
		reader.readAsDataURL(file);
	}    
}

function fullScreen(theURL) {
	window.open(theURL, '', 'fullscreen=yes, scrollbars=auto' );
}