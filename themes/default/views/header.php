<?php

	$CI=& get_instance(); 
	$this->authentication->set_notif();
	$lang = $this->authentication->get_Language();
	$kiri=_build_menu('atas-kiri');
	$kanan=_build_menu('atas-kanan');
	$lang_active=$this->session->userdata('bahasa');
	if (empty($lang_active))
		$lang_active=$this->config->item('language');
	$kiri_hide="hide";
	if(count($this->authentication->get_Menus('atas-kiri'))>0){
		$kiri_hide="";
	}elseif(count($this->authentication->get_Menus('atas-kanan'))>0){
		$kiri_hide="hide";
	}
	
	$photo = $this->authentication->get_Preference('list_photo');
	if (!$photo){
		$photo = img_url('default-user.png');
	}else{
		$photo = staft_url($this->authentication->get_info_user('photo'));
	}
	

	
	if ($this->authentication->is_admin()){ 
        $debugCount = '';
        if ($this->authentication->get_notif_error() != 0) {
            $debugCount = '<span class="badge badge-danger badge-mini rounded-circle">
                    '.$this->authentication->get_notif_error().'
                  </span>';
        }

        $notif ='<li class="dropdown custom-dropdown messages-menu">
                    <a href="#" class="nav-link text-white" data-toggle="dropdown">
                        <i class="icon-bug "></i>
                        '.$debugCount.'
                    </a>
                    
                    <ul class="dropdown-menu p-1" style="width: 200px">
                      <li class="header">'.$this->authentication->get_notif_error(1).'</li>
                      <li>
                        <ul class="menu pl-2 pr-2">'; 
    						$jml_max=intval($this->authentication->get_Preference('max_notif_debug'));
    						$no=1;
    						foreach($this->authentication->get_notif_error(2) as $row)
    						{
    							$post_date = $row->created_at;
    							$tgl=time_ago($post_date);
    							$notif .='<li>
    								<a href="'.base_url('debug/view/' . $row->id).'" target="_blank">
    									<div class="pull-left">
    									<i class="fa fa-warning text-yellow"></i>
    									</div>
    								  <h4>
    									 '.$row->priority_name.'
    								  </h4>
    								  <small>
    									<i class="fa fa-user"></i> '.$row->user.' | 
    									<i class="fa fa-clock-o"></i> '.$tgl.'
    								</small>
    								</a>
    							  </li>';
    							$no++;
    							if ($no>$jml_max)
    								break;
    						}
                        $notif .='</ul>
                      </li>
                      <li class="footer pt-2 pb-2 text-center"><a href="'.base_url('debug').'">View all</a></li>
                    </ul>
                  </li>';
    }
	if ($this->authentication->get_Preference('notif')=='0'){$notif='';}
?>

<div class="has-sidebar-left">
    
    <div class="pos-f-t">
        <div class="collapse" id="navbarToggleExternalContent">
            <div class="dark pt-2 pb-2 pl-4 pr-2">
                <div class="search-bar">
                    <input class="transparent s-24 text-white b-0 font-weight-lighter w-128 height-50" type="text"
                        placeholder="start typing...">
                </div>
                <a href="#" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-expanded="false"
                    aria-label="Toggle navigation" class="paper-nav-toggle paper-nav-white active "><i></i></a>
            </div>
        </div>
    </div>
    <div class="sticky" style="z-index: 100">
        <div class="navbar navbar-expand navbar-dark d-flex justify-content-between bd-navbar bg-hotpink">
            <div class="relative">
                <a href="#" data-toggle="offcanvas" class="paper-nav-toggle pp-nav-toggle">
                <i></i>
                </a>
            </div>
            <!--Top Menu Start -->
            <div class="navbar-custom-menu p-t-10">
                <?php if ($this->authentication->is_admin()): ?>
                <ul class="nav navbar-nav">
                    <!-- <?=$notif?> -->
                        
                    
                    <li class="dropdown custom-dropdown user user-menu">
                        <a href="#" class="nav-link" data-toggle="dropdown">
                                <?php if ($lang_active == 'english'): ?>
                                <img src="<?php echo img_url('lang-english.png');?>" class="user-image" alt="">
                                <?php endif ?>
                                <?php if ($lang_active == 'id'): ?>
                                <img src="<?php echo img_url('lang-indonesia.png');?>" class="user-image" alt="">
                                <?php endif ?>
                        </a>
                        <ul class="dropdown-menu" style="min-width: 130px">
                            <li>
                                <ul class="menu pl-2 pr-2">
                                    <li>
                                        <a href="<?php echo base_url();?>auth/language/id?redirect_to=<?php echo urlencode(current_url())?>" class="p-2">
                                            <div class="avatar float-left border">
                                                <img src="<?php echo img_url('lang-indonesia.png');?>" alt="">
                                            </div>
                                            <span class="pl-3" style="line-height: 28px">Indonesia</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url();?>auth/language/english?redirect_to=<?php echo urlencode(current_url())?>" class="p-2">
                                            <div class="avatar float-left border">
                                               <img src="<?php echo img_url('lang-english.png');?>" alt="">
                                            </div>
                                            <span class="pl-3" style="line-height: 28px">English</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
 
                    <li class="dropdown custom-dropdown user user-menu">
                        <a href="#" class="nav-link" data-toggle="dropdown">
                            <img src="<?=$photo?>" class="user-image" alt="User Image">
                        </a>
                        <div class="dropdown-menu pt-3" style="margin-left: -220px">
                            <?php if($this->authentication->is_admin()) { ?>
                            <div class="col-12 justify-content-between">
                                <div class="col-3 text-center fs-9 mb-3 float-left">
                                    <a href="<?=base_url('setting')?>">
                                        <i class="fas fa-igloo fs-16 color-hotpink"></i>
                                        <div class="text-center pt-1">Setting</div>
                                    </a>
                                </div>
                                <div class="col-3 text-center fs-9 mb-3 float-left">
                                    <a href="<?=base_url('groups')?>">
                                        <i class="fas fa-igloo fs-16 color-hotpink"></i>
                                        <div class="text-center pt-1">Group</div>
                                    </a>
                                </div>
                                <div class="col-3 text-center fs-9 mb-3 float-left">
                                    <a href="<?=base_url('module')?>">
                                        <i class="fas fa-igloo fs-16 color-hotpink"></i>
                                        <div class="text-center pt-1">Module</div>
                                    </a>
                                </div>
                                <div class="col-3 text-center fs-9 mb-3 float-left">
                                    <a href="<?=base_url('operator')?>">
                                        <i class="fas fa-igloo fs-16 color-hotpink"></i>
                                        <div class="text-center pt-1">Operator</div>
                                    </a>
                                </div>
                                <div class="col-3 text-center fs-9 mb-3 float-left">
                                    <a href="<?=base_url('font-icon')?>">
                                        <i class="fas fa-igloo fs-16 color-hotpink"></i>
                                        <div class="text-center pt-1">Font-icon</div>
                                    </a>
                                </div>
                                <div class="col-3 text-center fs-9 mb-3 float-left">
                                    <a href="<?=base_url('debug')?>">
                                        <i class="fas fa-igloo fs-16 color-hotpink"></i>
                                        <div class="text-center pt-1">Debug</div>
                                    </a>
                                </div>
                                <div class="col-3 text-center fs-9 mb-3 float-left">
                                    <a href="<?=base_url('log-activity')?>">
                                        <i class="fas fa-igloo fs-16 color-hotpink"></i>
                                        <div class="text-center pt-1">Log Activity</div>
                                    </a>
                                </div>
                                <div class="col-3 text-center fs-9 mb-3 float-left">
                                    <a href="<?=base_url('monitoring-user-online')?>">
                                        <i class="fas fa-igloo fs-16 color-hotpink"></i>
                                        <div class="text-center pt-1">User Online</div>
                                    </a>
                                </div>
                                <div class="col-3 text-center fs-9 mb-3 float-left">
                                    <a href="<?=base_url('bahasa')?>">
                                        <i class="fas fa-igloo fs-16 color-hotpink"></i>
                                        <div class="text-center pt-1">Bahasa</div>
                                    </a>
                                </div>
                                <div class="col-3 text-center fs-9 mb-3 float-left">
                                    <a href="<?=base_url('sub-bahasa')?>">
                                        <i class="fas fa-igloo fs-16 color-hotpink"></i>
                                        <div class="text-center pt-1">Seting Bahasa</div>
                                    </a>
                                </div>
                                
                            </div>
                            <?php } ?>
                        </div>
                    </li>
    
                </ul>
                <?php else: ?>
                <a href="<?=base_url('auth/logout')?>" class="text-white bolder">
                    <i class="fa fa-user s-32 fa-fw"></i>
                    <span>Logout</span>
                </a>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
    .col a .pt-1{ font-size: 10px; }
</style>