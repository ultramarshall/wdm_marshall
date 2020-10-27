<!-- <?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<?=link_tag(css_url('bootstrap.min.css'));?>
<?=link_tag(css_url('font-awesome.css'));?>
<?=link_tag(css_url('ionicons.min.css'));?>
<?=link_tag(css_url('AdminLTE.min.css'));?>
<title>Page Error</title>
</style>
</head>
<body>
	<div class="wrapper">
		<div class="content-wrapper" style="margin:50px 100px;">
			<section class="content">
				<div class="row">
					<div class="col-md-4">
						<img src="<?php echo img_url('error-404.jpg');?>">
					</div>
					<div class="col-md-8">
						<h1>404 Page Not Found!</h1>
						The page you requested <a href="<?php echo current_url();?>"> <?php echo current_url();?></a> was not found.<br/><br/>
						<div class="error-actions">
						   <a href="<?php echo base_url();?>" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-home"></span> Take Me Home </a>
							<a href="<?php echo base_url('contact');?>" class="btn btn-default btn-lg hide"><span class="glyphicon glyphicon-envelope"></span> Contact Support </a>
							<a href="<?php echo current_url();?>" class="btn btn-success btn-lg hide"><span class="glyphicon glyphicon-home"></span> Refresh</a>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</body>
</html> -->

<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/themes/default/assets/paper/img/basic/favicon.ico" type="image/x-icon">
    <title>Paper</title>
    <!-- CSS -->
   	<?=link_tag(asset_url('paper/css/app.css'))?>
    <style>
        html, body {
            height: 100%;
        }
        .loader {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: #F5F8FA;
            z-index: 9998;
            text-align: center;
        }

        .plane-container {
            position: absolute;
            top: 50%;
            left: 50%;
        }
    </style>
</head>
<body class="light">

<div id="app">
<div class="height-full light">
    <div id="primary" class="content-area"
         data-bg-possition="center"
         data-bg-repeat="false"
         style="background: url('/themes/default/assets/paper/img/icon/icon-circles.png'); background-repeat: no-repeat; background-size: cover">
        <div class="container">
            <div class="" style="height: 100vh; padding-top:35vh">
                <header class="text-center mt-5">
                    <h1>oops!</h1>
                    <p class="section-subtitle">Something went wrong. The page you are looking for is gone</p>
                </header>
                <div class="pt-5 p-t-100 text-center">
                    <p class="s-256">404</p>
                </div>
            </div>
        </div>
    </div>
    <!-- #primary -->
</div>

<!-- <?= script_tag(plugin_url("jquery/dist/jquery.min.js")) ?> -->
<script type="text/javascript" href="http://new.engine.com/themes/default/assets/paper/js/app.js"></script>
</body>
</html>