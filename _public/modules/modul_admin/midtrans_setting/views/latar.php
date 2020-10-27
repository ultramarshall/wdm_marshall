<table class="display table table-bordered table-striped table-hover" id="tbl_background">
	<thead>
		<tr>
			<th width="10%">No.</th>
			<th width="15%">Uplaod</th>
			<th>Nama File</th>
			<th width="10%">Status</th>
			<th width="8%">Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$no=0;
		if (isset($latar)){
		foreach($latar as $key=>$row){
			$data=form_hidden(array('judul[]'=>$row['judul'],'nama[]'=>$row['nama'],'size[]'=>$row['size']));
			$aktif=form_dropdown('aktif[]', array('-',0=>'Tidak',1=>'Aktif'), $row['aktif'],'class="form-control" style="width:100%;"');
			?>
			<tr>
				<td class="text-center">
					<i class="icon icon-square-up pointer text-success up" title="Naik"></i> &nbsp;
					<i class="icon icon-square-down pointer text-warning down" title="Turun"></i>
				</td>
				<td><?=form_upload("latar_img[]").$data;?></td>
				<td><img src="<?=slide_url($row['nama']);?>" width="100"></td>
				<td><?=$aktif;?></td>
				<td class="text-center"><i class="fa fa-trash-o"></i></td>
			</tr>
		<?php }
		}
	$latar = form_upload("latar_img[]");
	$data=form_hidden(array('judul[]'=>'','nama[]'=>'','size[]'=>''));		
	$aktif=form_dropdown('aktif[]', array('-',0=>'Tidak',1=>'Aktif'), 1,'class="form-control" style="width:100%;"');	
		?>
	</tbody>
</table>
<br/>
<span class="btn btn-primary pull-right" id="addSlide"> Tambah </span><br/>

<script type="text/javascript">
	var latar='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$latar));?>';
	var data='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$data));?>';
	var aktif='<?php echo addslashes(preg_replace("/(\r\n)|(\n)/mi","",$aktif));?>';
</script>