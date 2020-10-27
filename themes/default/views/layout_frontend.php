<!DOCTYPE html>
<html lang="en" style="">
    <head>
        <meta charset="utf-8">
        <meta name="theme-color" content="#FFB7DB">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, shrink-to-fit=yes">
        <title>e-Faktur</title>
        <meta http-equiv="Content-Security-Policy"
              content="default-src *; img-src * 'self' data: https: http:; script-src 'self' 'unsafe-inline' 'unsafe-eval' http://18.136.181.194 https://app.sandbox.midtrans.com https://cdnjs.cloudflare.com https://*.cloudfront.net; style-src 'self' 'unsafe-inline' *"/>
        <link rel="icon" type="image/png" href="<?=asset_url('images/icon.png')?>" sizes="32x32" />
		<?php 
            echo link_tag(plugin_url('lightslider/lightslider.css'));
            echo link_tag(plugin_url('select2/css/select2.min.css'));
            echo link_tag(asset_url('fonts/Source_Sans_Pro/stylesheet.css'));
            echo link_tag(plugin_url("flipclock/flipclock.css"));
			echo link_tag(css_frontend_url("css/app.css"));
			echo link_tag(css_frontend_url("css/style.css"));
            echo link_tag(css_frontend_url("css/theme-pink.css"));
            echo link_tag('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');
			echo link_tag('https://fonts.googleapis.com/icon?family=Material+Icons');
		?>
        <style>
            @media (max-width: 768px) {
              .container {
                width: 100%;
                max-width: none;
              }
            }
        </style>
		
    </head>
    <body class="light loaded sidebar-collapse w-100" style="background-image: url(<?=css_frontend_url('img/bg.png')?>); background-repeat: repeat">
        
        <div id="app">
            <div>
                <?=$template['partials']['header_frontend']; ?>
                <div class="container-fluid animatedParent animateOnce">
               
                        <?=$template['body'];?>
                    </div>
                </div>
            </div>
        </div>
    <?=$template['partials']['footer_frontend']; ?>
        <script>
            var spinner='<img src="<?=base_url('themes/default/assets/images/input-spinner.gif');?>" alt="" />';
            var base_url = "<?php echo base_url(); ?>";
            var mode = "<?php echo $this->uri->segment(2); ?>";
            var modul_name = "<?php echo $this->router->fetch_module(); ?>";
            var csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
            var csrf_cookie_name = '<?php echo $this->config->item('csrf_cookie_name'); ?>';
            function log(data) {console.log();}
        </script>


        <?php 
        
        echo script_tag(css_frontend_url('js/app.js'));
        echo script_tag(plugin_url("flipclock/flipclock.js"));
        echo script_tag(js_url("js.cookie.js"));
        echo script_tag(plugin_url("cleave/cleave.min.js"));
        echo script_tag(plugin_url("cleave/addons/cleave-phone.id.js"));
        echo script_tag(plugin_url("loaders/blockui.min.js"));
        echo script_tag(plugin_url("toastr-master/toastr.js"));
        echo script_tag(js_url("accounting.js"));
        echo script_tag(js_url("lazysizes.min.js"));
        echo script_tag(js_url("main.js"));
        echo $template['metadata'];
        ?>

        <script>
            $(document).ready(function(){
                $("img").addClass("lazyload");
            });

           

        </script>
       
    </body>
</html>

