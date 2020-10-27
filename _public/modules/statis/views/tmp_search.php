<?php
	$data=array();
	$id=0;
	if (isset($dat_edit['fields'])){
		$data=$dat_edit['fields'];
	}
	
?>
	<table class="table table-condensed" cellspacing="0" cellpadding="0" border="0" width="100%">
	<?php echo form_hidden('sts_query','1'); ?>
		<?php
		foreach($master['__search'] as $key=>$row)
		{
			?>				
				<tr>
					<td width="20%" class="row-title" style="vertical-align:top;"><?=$row['title'];?></td>
					<td width="3%" align="center" style="vertical-align:top;">:</td><td>
						<div class="input-group">
							<?=$row['value']; ?>
						</div>
					</td>
				</tr>
			<?php
		}
		?>
	</table>