function loadTable(url, display, idtbl) {
	console.log(display);
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