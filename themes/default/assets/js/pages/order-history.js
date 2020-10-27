$(document).ready(function(){
	$("#status-pembayaran").trigger("click");
	
});

$(document).on('click','.nav-link', function(){
	var url = modul_name + "/get-history";
	var type = $(this).attr('id');
	cari_ajax({type: type },"order", url);
});

$(document).on('click', '.view-details', function (evt) {
    var order_id = $(this).attr('id').split("-").pop(-1);
    console.log(order_id);

    var color = $(this).css('color');
    if (color === "rgb(0, 86, 179)") {
    	$(this).css({ 'color': 'red' });
        $('#form-detail-item-' + order_id).css('height','auto');
    } else {
    	$(this).css({ 'color': 'rgb(0, 86, 179)' });
        $('#form-detail-item-' + order_id).css('height','0px');
    }
	evt.preventDefault();
});