<!DOCTYPE html>
<html lang="eng">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title><?=$this->authentication->get_Preference('judul_atas');?></title>
        <link rel="icon" type="image/png" href="<?=asset_url('images/icon.png')?>" sizes="32x32" />
        <?=$template['partials']['css'];?>
        <?=$template['partials']['js'];?>
        <meta charset="utf-8">
    </head>
    <body class="light">
        <!-- <?=$template['partials']['preloader'];?> -->
        <div id="app">
            <?=$template['partials']['sidebar_left'];?>
            <?=$template['partials']['header'];?>
            
            <div class="page has-sidebar-left height-full">
               
                <header class="bg-hotpink relative nav-sticky">
                    <div class="container-fluid text-white">
                        <div class="row p-t-b-10 ">
                            <div class="col">
                                <h4>
                                    <i class="icon-box"></i>
                                    <?php
                                    $judul = lang("msg_title");
                                    echo (!empty($judul)) ? $judul : ucwords(_MODULE_NAME_);?>
                                </h4>
                            </div>
                        </div>

                        <?php if ((isset($master['tabs']) > 0 && ($this->uri->segment(2) == 'add' || $this->uri->segment(2) == 'edit') || $this->uri->segment(1) == 'setting')): ?>
                        <div class="row">
                            <ul class="nav responsive-tab nav-material nav-material-white" id="v-pills-tab">
                                <?php

                                    $i = 1;
                                    foreach ($master['tabs'] as $tab):
                                        $active = "";
                                        if ($i == 1) {
                                            $active = ' active ';
                                        }

                                        $hide = '';
                                        if (array_key_exists('show', $tab)) {
                                            if (!$tab['show']) {
                                                $hide = ' hide ';
                                            }

                                        }

                                        $tab_icon = ' <i class="icon icon-home2"></i> ';
                                        if (array_key_exists('icon', $tab)) {
                                            $tab_icon = ' <i class="icon icon-' . $tab['icon'] . '"></i> ';
                                        }

                                        ?>

                                      <li>
                                          <a class="nav-link <?php echo $active . $hide; ?>" id="<?php echo $tab['id']; ?>" data-toggle="pill" href="#tab_<?php echo $i; ?>">
                                              <?php echo $tab_icon; ?>
                                              <?php echo $tab['title']; ?>
                                          </a>
                                      </li>
                                      <?php $i++;
                                    endforeach
                                    ;?>
                            </ul>
                        </div>
                        <?php endif;?>

                    </div>
                </header>

                <div class="container-fluid relative animatedParent animateOnce p-2">
                    <?=$template['body'];?>
                </div>
            </div>
            <?php echo $template['partials']['sidebar_right']; ?>

            <div class="control-sidebar-bg shadow white fixed"></div>
        </div>

        <?php echo $template['partials']['js_bottom']; ?>
        <?php echo $template['metadata']; ?>

        <script>
            var spinner='<img src="<?=base_url('ssthemes/default/assets/images/input-spinner.gif');?>" alt="" />';
            var base_url = "<?php echo base_url(); ?>";
            var mode = "<?php echo $this->uri->segment(2); ?>";
            var modul_name = "<?php echo $this->router->fetch_module(); ?>";
            var csrf_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
            var csrf_cookie_name = '<?php echo $this->config->item('csrf_cookie_name'); ?>';

            function loading(nil, id){
               if(typeof(id) == "undefined")
                  id ='overlay';
               if (nil){
                  $("#" + id).removeClass("hide");
               }else{
                  $("#" + id).addClass("hide");
               }
            }

            function loading_all(nil){
               if (nil)
                  $("body").addClass("loading");
               else
                  $("body").removeClass("loading");
            }


            $(document).ready(function() {

               setTimeout(function(){
                  $('#sts_pesan_proses').fadeOut(1000);
                  $('.row-title').removeClass('error');
                  $('select.error').removeClass('error');
               }, 9000);

               $('#sts_pesan_proses').on('click', function(e) {
                  $(this).fadeOut(1000);
                  $('.row-title').removeClass('error');
                  $('select.error').removeClass('error');
               });

               $('#sts_error').fadeIn('slow');
               setTimeout(function(){
                  $('#sts_error').remove();
                  $('input').removeClass('error');
                  $('select.error').removeClass('error');

                  $('#sts_error').fadeOut(1000);
                  $('.row-title').removeClass('error');
               }, 5000);

               $('#sts_error').on('click', function(e) {
                  $(this).fadeOut(1000);
                  $('input').removeClass('error');
                  $('select.error').removeClass('error');
                  $('.row-title').removeClass('error');
               });

               var url_redirect_to ="<?php echo base_url('auth/logout?redirect_to=' . urlencode(uri_string())); ?>";

               $("#logout").removeAttr('href').attr('href',url_redirect_to);
               $("#logout2").removeAttr('href').attr('href',url_redirect_to);

               $("input:text")
                  .focus(function () { $(this).select(); } )
                  .mouseup(function (e) {e.preventDefault(); });

               $("img").addClass("lazyload");
            });

            var Globals = <?php echo json_encode(array(
                'sLengthMenu'   => lang('msg_data_table_sLengthMenu'),
                'sZeroRecords'  => lang('msg_data_table_sZeroRecords'),
                'sInfo'         => lang('msg_data_table_sInfo'),
                'sInfoEmpty'    => lang('msg_data_table_sInfoEmpty'),
                'sInfoFiltered' => lang('msg_data_table_sInfoFiltered'),
                'sSearch'       => lang('msg_data_table_sSearch'),
                'sFirst'        => lang('msg_data_table_sFirst'),
                'sPrevious'     => lang('msg_data_table_sPrevious'),
                'sNext'         => lang('msg_data_table_sNext'),
                'sLast'         => lang('msg_data_table_sLast'),
                'cboSelect'     => lang('msg_cbo_select'),
                'nil_combo'     => $this->authentication->get_Preference('baris_tabel'),
            )); ?>;          
            
            document.onkeypress= stopEnterKey;
        </script>
    </body>
</html>