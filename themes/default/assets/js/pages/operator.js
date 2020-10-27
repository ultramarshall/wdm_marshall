$(function(){
	$("#l_kel_place, #q_l_kel_place").change(function(){		
		var id = $(this).attr('id');
		var parent = $(this).parent();
		var nilai = $(this).val();
		var data={'id':nilai};
		if (id=='l_kel_place')
			var target_combo = $("#l_id_place");
		else
			var target_combo = $("#q_l_id_place");
		var url = modul_name + "/get_place_operator";
		cari_ajax_combo("post", parent, data, target_combo, url);
		if (id=='l_kel_place')
			$("#select2-l_id_place-container").html("");
	})
});


$(document).ready(function() {
	$("#l_id_place_parent").removeClass("input-group");
})