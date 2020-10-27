
$(document).ready(function(){
	cari_ajax({}, "x-content", modul_name + '/filter-product-by');
})

$("#prange").ionRangeSlider({
	skin: "round",
	type: "int",
	grid: false,
	max: 1,
	values: [0, 20000, 50000, 100000, 300000, 500000, 1000000, 5000000, 10000000],
	prefix: "Rp ",
	force_edges: true,
	onFinish: function (data) {
		cari_ajax({from: data.from_value, to: data.to_value}, "x-content", modul_name + '/filter-product-by');
	},
});

/*$(document).on('click', '#key', function(){
	cari_ajax({}, "x-content", modul_name + '/filter-product-by');
})*/





