<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Page Error</title>
</style>
</head>
<body>
	<div class="wrapper">
		<div class="content-wrapper" style="margin:50px 100px;">
			<section class="content">
				<div class="row">
					<div class="col-md-4">
						<img src="<?php echo img_url('oops.png');?>">
					</div>
					<div class="col-md-8">
						<h1>A PHP Error was encountered!</h1>
						<p>The server encountered an internal error or misconfiguration and was unable to complete you request.</p>
						<p>Please contact the server administrator, webmaster@gmail.com and inform them of the time error accourred, and anyting you might have done that may have caused the error</p> 
						<p>More informastion about this error may available in the server error log.</p>
						
						<p>Severity: <?php echo $severity; ?></p>
						<p>Message:  <?php echo $message; ?></p>
						<p>Filename: <?php echo $filepath; ?></p>
						<p>Line Number: <?php echo $line; ?></p>

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
</body>
</html>