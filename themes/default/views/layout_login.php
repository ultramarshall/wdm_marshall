
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
       
        <title>Login</title>
       

        <?php 
            echo link_tag(asset_url('fonts/Source_Sans_Pro/stylesheet.css'));
            echo link_tag(plugin_url("font-awesome-4.7.0/css/font-awesome.css"));
            echo link_tag(plugin_url("font-awesome-animation/font-awesome-animation.min.css"));
            echo link_tag(css_frontend_url("css/app.css"));
            echo link_tag(css_frontend_url("css/style.css"));
        ?>
        
    </head>
    <body class="light  sidebar-collapse" style="background-image: url(<?=css_frontend_url('img/bg.png')?>);">
        
        <?=$template['body']?>

        <script>
            var base_url = "<?php echo base_url(); ?>";
            var csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
            var csrf_cookie_name = '<?php echo $this->config->item('csrf_cookie_name'); ?>';
        </script>

        

        <?=$template['partials']['footer_frontend']; ?>

        
        <?php 
        
        echo script_tag(css_frontend_url('js/app.js'));
        echo script_tag(plugin_url("toastr-master/toastr.js"));
        echo script_tag(js_url("main.js"));
        echo script_tag(js_url("js.cookie.js"));
        echo $template['metadata'];
        ?>
        <script>
            <?php if ($this->session->userdata('result_login')): ?>
                toastr.info("<?=$this->session->userdata('result_login')?>", 'Info', {timeOut: 5000})
            <?php endif ?>
            <?php $this->session->set_userdata('result_login', ''); ?>

        </script>
    </body>
</html>

