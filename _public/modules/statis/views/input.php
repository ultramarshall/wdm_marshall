<?php
	if (isset($header))
	{
?>
	<div class="panel-footer"><?php echo $header;?></div>
<?php }
	echo $input;?>
<?php
	if (isset($footer)){
?>
<div class="panel-footer"><?php echo $footer;?></div>
<?php } ?>