<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title><?php echo $template['title'];?></title>
		<link rel="shortcut icon" href="<?php echo base_url();?>/images/favicon.png" />
		
		<?php echo $template['partials']['css'];?>
		<?php echo $template['partials']['js'];?>
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		  <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		<![endif]-->
	</head>
	<body class="hold-transition lockscreen">
	<!-- Automatic element centering -->
   <?php echo $template['body'];?>
	</body>
</html>
