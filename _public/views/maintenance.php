<!DOCTYPE html>
<html lang="en" >
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SKDR Pusat P2P</title>
	<!--Core CSS -->
	<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo base_url('themes/maintenance/css/animate.css');?>">
    <link href="<?php echo base_url('themes/maintenance/css/bootstrap.min.css');?>" rel="stylesheet">
	 <!-- Custom styles for this template -->
    <link href="<?php echo base_url('themes/maintenance/style.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('themes/maintenance/css/style-responsive.css');?>" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body >
  <!-- Header Section Start -->
	<header id="header_part">
		<div class="header_part" id="head">
			<div class="overlay">
				<div class="start_part" style="padding:20px;">
					<div class="container">
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="row">
									<!-- Logo Start -->
									<div class="site_logo" style="margin-top:50px;">
										<a href="#" title=""><img src="<?=base_url('themes/maintenance/images/logo.png');?>" alt="" title="Logo Depkes" width="100"/></a>
									</div>
									<!-- Logo End-->
									<!-- Site Title start-->	
									<div class="site_title">
										<h1><span style="color:#F7CC1C;">UNDER</span> <span style="color:#3EB9ED;">CONSTRUCTION!</span></h1>
										<p>Just have a wait, we are under development & comming soon shortly</strong>
									</div>
									<!-- Site Title end-->
									<!-- Countdown start -->
									<div class="countdown wow bounceInUp">
										<div class="defaultCountdown"></div>
									</div>
									<!-- Countdown end-->
								</div>
							</div>
						</div>
					</div>
				</div>	
				<!-- Menu Start -->
				<div class="menu_area hide" id="stick_menu">
					<div class="container">
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<nav class="navbar navbar-default" role="navigation">
									<div class="container-fluid">
										<div class="collapse navbar-collapse mainnavmenu" id="bs-example-navbar-collapse-1">
										<div id="menu-center">
											<ul class="nav navbar-nav navbar-right mainnav hide">
												<li><a href="#header_part" >Start</a></li>
												<li><a href="#welcome_section">Welcome</a></li>
												<li><a href="#email_subscribe_section">Get Notify</a></li>
												<li><a href="#contact_section">Contact</a></li>	
											</ul>
										</div>
										</div>
									</div>
								</nav>
							</div>
						</div>
					</div>
				</div>
				<!-- Menu End-->
			</div>
		</div>	
	</header>
  <!-- Header Section End -->		
   <!--Core js-->
	<script>
		var thn = <?=$waktu['tahun'];?>;
		var bln = <?=$waktu['bulan'];?>;
		var tgl = <?=$waktu['tanggal'];?>;
		var jam = <?=$waktu['jam'];?>;
		var menit = <?=$waktu['menit'];?>;
	</script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="<?php echo base_url('themes/maintenance/js/bootstrap.min.js');?>"></script>
    <script src="<?php echo base_url('themes/maintenance/js/jquery.smooth-scroll.js');?>"></script>
    <script src="<?php echo base_url('themes/maintenance/js/wow.min.js');?>"></script>
    <script src="<?php echo base_url('themes/maintenance/js/jquery.nicescroll.min.js');?>"></script>
    <script src="<?php echo base_url('themes/maintenance/js/jquery.countdown.min.js');?>"></script>
	<!--common script init for all pages-->
    <script src="<?php echo base_url('themes/maintenance/js/script.js');?>"></script>
  </body>
</html>
<?php exit(); ?>