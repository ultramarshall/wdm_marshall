<?php echo $map['js']; ?>
<input type="text" id="myPlaceTextBox" class="form-control" />
<?php echo $map['html'];?>

<script>
	function get_position_map(lat, lang){
		$("#l_lat").val(lat);
		$("#l_lng").val(lang);
	}

	function clearOverlays() {
		for (var i = 0; i < markers_map.length; i++ ) {
			markers_map[i].setMap(null);
		}
		markers_map = [];
	}
</script>