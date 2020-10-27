<?php
doi::dump($message, false,true);
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<?=link_tag(css_url('bootstrap.min.css'));?>
<?=link_tag(css_url('font-awesome.css'));?>
<?=link_tag(css_url('ionicons.min.css'));?>
<?=script_tag(plugin_url("jquery/dist/jquery.min.js"));?>
<title>Database Error</title>
</style>
</head>
<body>
	<div class="wrapper">
		<div class="content-wrapper" style="margin:50px 100px;">
			<section class="content">
				<div class="row">
					<div class="col-md-3">
						<img src="<?php echo img_url('err_db.jpg');?>">
					</div>
					<div class="col-md-6">
						<h1><?=$heading. ' - Code: ' . $status_code;?></h1>
						Looks like the database got lost somewhere...<br/>
						Don't worry though! We'll recover it!<br/>
						In the mean time, you can choose<br/><br/>
						<span class="show-error" style="cursor:pointer;"><em>show error</em><br/>&nbsp;</span>
						<div class="well hide">
						<?=$heading.'<br/><code>'.$message.'</code>';?>
						</div>
						<div class="error-actions">
						   <a href="<?php echo base_url();?>" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-home"></span> Take Me Home </a>
							<a href="<?php echo base_url('contact');?>" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-envelope"></span> Contact Support </a>
							<a href="<?php echo current_url();?>" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-home"></span> Refresh</a>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
	<script>
		$(function(){
			$(".show-error").click(function(){
				$(".well").removeClass("hide");
				$(this).addClass("hide");
			})
		})
	</script>
</body>
</html>