$(function(){
	$("#addSlide").click(function(){		
		var row = $("table#tbl_background tbody");
		row.append('<tr><td class="text-center"><i class="icon icon-square-up pointer text-success up" title="Naik"></i> &nbsp;<i class="icon icon-square-down pointer text-warning down" title="Turun"></i></td><td>'+data+latar+'</td><td>&nbsp;</td><td>'+aktif+'</td><td class="text-center"><i class="fa fa-trash-o pointer "></i></td></tr>');
	})
	
	$(document).on("click", ".fa-trash-o", function(){
		var r = confirm("Yakin akan dihapus ?");
		if (r)
			$(this).closest("tr").remove();
	})
	
	$(document).on('click','.up, .down', function(){
		var row = $(this).parents("tr:first");
		$(".up,.down").show();
		if ($(this).is(".up")) {
			row.insertBefore(row.prev());
		} else {
			row.insertAfter(row.next());
		}
		// $("tbody tr:last .down").hide();
		$(this).closest('table').find('tbody tr:last').find('.down').hide();
		$(this).closest('table').find('tbody tr:first').find('.up').hide();
	});
});