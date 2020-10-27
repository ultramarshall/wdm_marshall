<div class="modal fade bs-example-modal-sm" id="id_tambah_data_anggota" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width:auto;margin:20px;">
		<div class="modal-content">
			  <div class="modal-body">
				<table class="table" id="datatables">
					<thead>
						<tr>
						<th style="text-align:center;width:4%;"><input type="checkbox" id="check_all_master" target='check_item[]'></th>
						<th style="text-align:center;width:6%;">No.</th>
						<th>Nama</th>
						<th style="width:20%;" >Panggilan</th>
						<th style="width:15%;" >HP</th>
						<th style="width:15%;" >Groups</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i=1;
						foreach($field as $key=>$row)
						{ 
							$edit=form_hidden('id[]',$row->id);
							$value_chek=$row->id.'#'.$row->nama.'#'.$row->panggilan.'#'.$row->no_hp.'#'.$row->email;
							?>
							<tr>
								<td style="text-align:center;"><input type="checkbox" name="check_item[]" value="<?php echo $value_chek;?>'" class="checkbox_contact"></td>
								<td style="text-align:center"><?php echo $i.$edit;?></td>
								<td><?php echo $row->nama;?></td>
								<td><?php echo $row->panggilan;?></td>
								<td><?php echo $row->no_hp;?></td>
								<td>-</td>
							</tr>
						<?php 
							++$i;
						}
						?>
					</tbody>
				</table>
			  </div>
			  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="proses_select"><i class="fa fa-search"></i> <?php echo lang('msg_tbl_select');?></button>
			  </div>
		  </div>
	  </div>
</div>

<script type="text/javascript">

	$(function() {
		$("#proses_select").click(function(){
			var jml_pil=0;
			var nil='';
			var myCheckboxes = new Array();
			$(".checkbox_contact").each(function() {
				if (this.checked){
					nil=$(this).val();
					myCheckboxes.push(nil);
					this.checked = false;
					++jml_pil;
					var data=nil.split('#');
					add_install(data[0], data[1], data[2], data[3], data[4]);
				}
			});
			$('#check_all_master').checked=false;
			$('#id_tambah_data_anggota').modal('hide');      
		});
		
		loadTable();
	});
</script>