$(document).ready(function(){
	$('.select_2').select2();
	$.datetimepicker.setLocale('id');
});
$(document).on('click', '#add', function(){
	$('tbody tr:first').clone().appendTo('tbody');
	$('.select_2').select2();
	a = $(document).find('.input-table').find('tbody tr:last td:first').find('.select2:last').remove()
	update_values()

});
$(document).on('change', '.select_2', function() {
	update_values()
})
function update_values() {
	row = $(document).find('.input-table').find('tbody tr')
	values = new Array();
	for (var i = 0; i < row.length; i++) { 
		values.push(parseInt($(document).find('.input-table').find('tbody tr:eq('+i+') td:first .select_2').val()))
	}
	$('#l_flashsale_product').val(values)
}

$(document).on('click', '.delete', function(){
	$(this).closest('tr').remove()
	update_values();

})


