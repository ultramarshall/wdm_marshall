<div class="modal-body">
	<table class="table table-hover" id="datatablesx">
		<thead>
			<tr>
				<th width="10%" style="text-align:center;">No.</th>
				<th>Name</th>
				<th width="15%" >Action</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i=1;
			foreach($field as $key=>$row)
			{ 
				if ($kel=='owner'){
					$nama=$row->name;
				}else{
					$nama=$row->periode_name;
				}
				$value_chek=$nama.'#'.$row->id;
				?>
				<tr class="pilih" style="cursor:pointer;" value="<?php echo $value_chek;?>" data-dismiss="modal">
					<td style="text-align:center;"><?php echo $i++	;?>.</td>
					<td><?php echo $nama;?></td>
					<td style="text-align:center;"><span class="btn btn-info pilih" value="<?php echo $value_chek;?>" data-dismiss="modal"><?php echo lang('msg_tbl_select');?></span></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
  </div>
  <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
  </div>

<script type="text/javascript">
	var kel='<?php echo $kel;?>';
	$(".pilih").click(function(){
		var jml_pil=0;
		var nil='';
		nil=$(this).attr('value');
		var data=nil.split('#');
		if (kel=="owner"){
			add_install_owner(data[1], data[0]);
		}else{
			add_install_period(data[1], data[0]);
		}
	});
	loadTable('',0,'datatablesx');
</script>