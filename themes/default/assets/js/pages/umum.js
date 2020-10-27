var cart = {
    add: function(data) { 

        $.ajax({
	        type     : 'post',
	        url      : base_url + 'cart/add-cart',
	        data     : { 
	            id: data.id,
	            qty: data.qty,
	            price: data.price,
	            name: data.name,
	            varian: data.varian,
	        },
	        success  : function(response) {
	            pesan_toastr('Sukses','info','Prosess','toast-bottom-right');
	            $('.total-cart').remove();
	            $('.item-cart').append('<span class="total-cart badge bg-red badge-mini text-white" style="right: 20px; top: 3px">'+JSON.parse(response)[1]+'</span>');
	            $('.sub').empty();
	            $('.sub').append(JSON.parse(response)[2]);
	        }
	    });
    },
    update: function(data) { 
    	looding('light', $('#item'));
        $.ajax({
	        type     : 'post',
	        url      : base_url + 'cart/update-cart',
	        data     : { 
	            row_id: data.row_id,
	            qty: data.qty,
	        },
	        success  : function(response) {
	            $('.total-cart').remove();
	            $('.item-cart').append('<span class="total-cart badge bg-red badge-mini text-white" style="right: 20px; top: 3px">'+JSON.parse(response)[1]+'</span>');
	            $('.sub').empty();
	            $('.sub').append(JSON.parse(response)[2]);
				$(document).find('#item').empty()
				$(document).find('#item').append(JSON.parse(response)[4])
		    	stopLooding($('#item'))
	        }
	    });
    },
    delete: function(data) {
    	looding('light', $('#item'));
    	$.ajax({
	        type     : 'post',
	        url      : base_url + 'cart/remove-cart',
	        data     : { rowid: data.rowid },
	        success  : function(response) {
	        	if (JSON.parse(response)[1] === 0) {
	        		$('.item-cart').find('.badge').remove();
	        		$('.sub').empty();
		            $('.sub').append(JSON.parse(response)[3]);
	        	} else {
	        		$('.item-cart').find('badge').remove();
		            $('.item-cart').append('<span class="total-cart badge bg-red badge-mini text-white" style="right: 20px; top: 3px">'+JSON.parse(response)[1]+'</span>');
	        	}
				$(document).find('#item').empty();
				$(document).find('#item').append(JSON.parse(response)[2]);
		    	stopLooding($('#item'))
	        }
	    });
    }
};

rajaongkir = {
	kota: function(id_provinsi, target_combo) {
		looding('dark', $(document).find(target_combo).closest('.form-group'))
		$.ajax({
	        type     : 'post',
	        url      : base_url + 'address/get-city',
	        data     : { 
	            id: id_provinsi
	        },
	        success  : function(response) {
	        	city = JSON.parse(response).rajaongkir.results;
		    	var data = new Array();
	        	$.each(city, function(i, item) {
				    var new_data = {id: item.city_id, text: item.city_name};
				    data.push(new_data);
				});
				$(document).find(target_combo).empty();
				$(document).find(target_combo).select2({data:data});
				stopLooding($(document).find(target_combo).closest('.form-group'));
	        }
	    });
	},
	kecamatan: function(id_kota, target_combo) {
		looding('dark', $(document).find(target_combo).closest('.form-group'))
		$.ajax({
	        type     : 'post',
	        url      : base_url + 'address/get-subdistrict',
	        data     : { 
	            id: id_kota
	        },
	        success  : function(response) {
	        	city = JSON.parse(response).rajaongkir.results;
		    	var data = new Array();
	        	$.each(city, function(i, item) {
				    var new_data = {id: item.subdistrict_id, text: item.subdistrict_name};
				    data.push(new_data);
				});
				$(document).find(target_combo).empty();
				$(document).find(target_combo).select2({data:data});
				stopLooding($(document).find(target_combo).closest('.form-group'));
	        }
	    });
	},
}

$(document).on('click', '.treeview', function(){
	active = $(this).index()
})


$('#back-login').click(function(e){
	e.preventDefault();
	window.location = base_url+'auth';
	return false;
});