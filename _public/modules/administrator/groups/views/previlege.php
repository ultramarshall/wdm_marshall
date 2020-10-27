<script>
	function _toggleCheckBoxes(td){
		if(td){
			if(td.checked){
				td.checked = false;
			}else{
				td.checked = true;
			}
		
			var tr = td.parentNode;
			if(tr && tr.cells){
				var l = tr.cells.length - 1;
				for(var i = 1 ; i <= l ; i++){
					var tmpTd = tr.cells[i];
					var checkbox = tmpTd.childNodes[1];
					if(checkbox){
						checkbox.checked = td.checked;
					}
				}
			}
		}
	}
</script>
	<table class="table"><thead><tr>
	<th><?php echo lang('msg_field_modul');?></th>
	<th width="10%" align="center"><?php echo lang('msg_field_read');?></th>
	<th width="10%" align="center"><?php echo lang('msg_field_add');?></th>
	<th width="10%" align="center"><?php echo lang('msg_field_edit');?></th>
	<th width="10%" align="center"><?php echo lang('msg_field_delete');?></th>
	<th width="10%" align="center"><?php echo lang('msg_field_print');?></th>
	</tr></thead><tbody>
<?php
	$i=0;
	$arrow='<i class="fa fa-angle-double-right"></i> ';
	$spacy=str_repeat('&nbsp;',1*4);
	// var_dump($data['field']);
	foreach($field as $row)
	{
		$read_checked='';
		$add_checked='';
		$edit_checked='';
		$delete_checked='';
		$print_checked='';
		$send_checked='';
		
		
		if ($row['sts']['read']=='1') { $read_checked='checked';}
		if ($row['sts']['add']=='1') { $add_checked='checked';}
		if ($row['sts']['edit']=='1') { $edit_checked='checked';}
		if ($row['sts']['delete']=='1') { $delete_checked='checked';}
		if ($row['sts']['print']=='1') { $print_checked='checked';}
		if ($row['sts']['send']=='1') { $send_checked='checked';}
		
		$lbl = url_title(strtolower(str_replace('-','_',$row['link'])));
		$title = lang('msg_mdl_'.$lbl);
		if (empty($title))
			$title=$row['label'];
		
	?>
		<tr>
			<td onclick="_toggleCheckBoxes(this)" style="cursor:pointer;text-align:left;"><strong><input type="hidden" name="id_edit_group[]" value="<?php echo $row['sts']['id'];?>"><input type="hidden" name="id_menu[]" value="<?php echo $row['id'];?>"><?php echo $title;?></strong></td>
			<td><input class="pointer" type="hidden" name="read_<?php echo $i;?>" value="0" /><input class="pointer" type="checkbox" name="read_<?php echo $i;?>" value="1" <?php echo $read_checked;?>></td>
			<td><input class="pointer" type="hidden" name="add_<?php echo $i;?>" value="0" /><input class="pointer" type="checkbox" name="add_<?php echo $i;?>" value="1" <?php echo $add_checked;?>></td>
			<td><input class="pointer" type="hidden" name="edit_<?php echo $i;?>" value="0" /><input class="pointer" type="checkbox" name="edit_<?php echo $i;?>" value="1" <?php echo $edit_checked;?>></td>
			<td><input class="pointer" type="hidden" name="delete_<?php echo $i;?>" value="0" /><input class="pointer" type="checkbox" name="delete_<?php echo $i;?>" value="1" <?php echo $delete_checked;?>></td>
			<td><input class="pointer" type="hidden" name="print_<?php echo $i;?>" value="0" /><input class="pointer" type="checkbox" name="print_<?php echo $i;?>" value="1" <?php echo $print_checked;?>></td>
		</tr>
	<?php
		if (count($row['submenu'])>0)
		{
			++$i;
			foreach($row['submenu'] as $sub)
			{	
				$read_checked='';
				$add_checked='';
				$edit_checked='';
				$delete_checked='';
				$print_checked='';
				$send_checked='';
				
				if ($sub['sts']['read']=='1') { $read_checked='checked';}
				if ($sub['sts']['add']=='1') { $add_checked='checked';}
				if ($sub['sts']['edit']=='1') { $edit_checked='checked';}
				if ($sub['sts']['delete']=='1') { $delete_checked='checked';}
				if ($sub['sts']['print']=='1') { $print_checked='checked';}
				if ($sub['sts']['send']=='1') { $send_checked='checked';}
				
				$lbl = url_title(strtolower(str_replace('-','_',$sub['link'])));
				$title = lang('msg_mdl_'.$lbl);
				if (empty($title))
							$title=$sub['label'];
			?>
				<tr>
					<td onclick="_toggleCheckBoxes(this)" style="cursor:pointer;text-align:left;"><input type="hidden" name="id_edit_group[]" value="<?php echo $sub['sts']['id'];?>"><input type="hidden" name="id_menu[]" value="<?php echo $sub['id'];?>"><?php echo  $spacy . $arrow . $spacy . $title;?></td>
					<td><input class="pointer" type="hidden" name="read_<?php echo $i;?>" value="0" /><input class="pointer" type="checkbox" name="read_<?php echo $i;?>" value="1" <?php echo $read_checked;?>></td>
					<td><input class="pointer" type="hidden" name="add_<?php echo $i;?>" value="0" /><input class="pointer" type="checkbox" name="add_<?php echo $i;?>" value="1" <?php echo $add_checked;?>></td>
					<td><input class="pointer" type="hidden" name="edit_<?php echo $i;?>" value="0" /><input class="pointer" type="checkbox" name="edit_<?php echo $i;?>" value="1" <?php echo $edit_checked;?>></td>
					<td><input class="pointer" type="hidden" name="delete_<?php echo $i;?>" value="0" /><input class="pointer" type="checkbox" name="delete_<?php echo $i;?>" value="1" <?php echo $delete_checked;?>></td>
					<td><input class="pointer" type="hidden" name="print_<?php echo $i;?>" value="0" /><input class="pointer" type="checkbox" name="print_<?php echo $i;?>" value="1" <?php echo $print_checked;?>></td>
				</tr>
			<?php
				if (count($sub['submenu'])>0)
				{
					++$i;
					foreach($sub['submenu'] as $sub2)
					{	
						$read_checked='';
						$add_checked='';
						$edit_checked='';
						$delete_checked='';
						$print_checked='';
						$send_checked='';
						
						if ($sub2['sts']['read']=='1') { $read_checked='checked';}
						if ($sub2['sts']['add']=='1') { $add_checked='checked';}
						if ($sub2['sts']['edit']=='1') { $edit_checked='checked';}
						if ($sub2['sts']['delete']=='1') { $delete_checked='checked';}
						if ($sub2['sts']['print']=='1') { $print_checked='checked';}
						if ($sub2['sts']['send']=='1') { $send_checked='checked';}
						
						$lbl = url_title(strtolower(str_replace('-','_',$sub2['link'])));
						$title = lang('msg_mdl_'.$lbl);
						if (empty($title))
							$title=$sub2['label'];
		
					?>
						<tr>
							<td onclick="_toggleCheckBoxes(this)" style="cursor:pointer;text-align:left;"><input type="hidden" name="id_edit_group[]" value="<?php echo $sub2['sts']['id'];?>"><input type="hidden" name="id_menu[]" value="<?php echo $sub2['id'];?>"><?php echo  $spacy . $spacy . $spacy . $arrow . $spacy . $title;?></td>
							<td><input class="pointer" type="hidden" name="read_<?php echo $i;?>" value="0" /><input class="pointer" type="checkbox" name="read_<?php echo $i;?>" value="1" <?php echo $read_checked;?>></td>
							<td><input class="pointer" type="hidden" name="add_<?php echo $i;?>" value="0" /><input class="pointer" type="checkbox" name="add_<?php echo $i;?>" value="1" <?php echo $add_checked;?>></td>
							<td><input class="pointer" type="hidden" name="edit_<?php echo $i;?>" value="0" /><input class="pointer" type="checkbox" name="edit_<?php echo $i;?>" value="1" <?php echo $edit_checked;?>></td>
							<td><input class="pointer" type="hidden" name="delete_<?php echo $i;?>" value="0" /><input class="pointer" type="checkbox" name="delete_<?php echo $i;?>" value="1" <?php echo $delete_checked;?>></td>
							<td><input class="pointer" type="hidden" name="print_<?php echo $i;?>" value="0" /><input class="pointer" type="checkbox" name="print_<?php echo $i;?>" value="1" <?php echo $print_checked;?>></td>
						</tr>
					<?php
					++$i;
					}
				}else{
					++$i;
				}
			}
		}else{
			++$i;
		}
	}
	?>
	</tbody></table>