<?php 
    if((bool)$this->authentication->get_Info_User('photo')){
        $photo = show_image($this->authentication->get_Info_User('photo'),160, 100, 'staft', '', 'user_avatar');
    } elseif((bool)$this->authentication->get_Info_User('photo_google')) {
        $photo = '<img src="'.$this->authentication->get_Info_User('photo_google').'" alt="" class="user_avatar">';
    } else {
        $photo = '<img src="'.img_url('default-user.png').'" alt="" class="user_avatar">';
    }

    $name = ($this->authentication->get_info_user('nama_lengkap')=="")?$this->authentication->get_info_user('username'):$this->authentication->get_info_user('nama_lengkap');
?>

<?php if ($this->template->_sideleft): ?>
<div class="col-3 sideleft p-0">
    <section class="sidebar">
        <div class="user-panel p-0 border-bottom pb-1">
                <div>
                    <div class="float-left image">
                        <?=$photo?>
                    </div>
                    <div class="float-left info">
                        <h4 class="mt-2 mb-1 bold"><?=$name?></h4>
                        <a href="#"><i class="icon-circle hotpink-text blink"></i> Online</a>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="collapse multi-collapse" id="userSettingsCollapse">
                    <div class="list-group mt-3 shadow">
                        <a href="index.html" class="list-group-item list-group-item-action ">
                            <i class="mr-2 icon-umbrella text-blue"></i>Profile
                        </a>
                        <a href="#" class="list-group-item list-group-item-action"><i class="mr-2 icon-cogs text-yellow"></i>Settings</a>
                        <a href="#" class="list-group-item list-group-item-action"><i class="mr-2 icon-security text-purple"></i>Change Password</a>
                    </div>
                </div>
            </div>
        <ul class="sidebar-menu">


            <li class="treeview active">
                <a href="#">
                    <i class="icon icon-account_box hotpink-text s-18"></i>
                    <span>Akun Saya</span>
                    <i class="icon icon-angle-left s-18 pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?=base_url('profiles')?>"><i class="icon icon-info2 ml-3"></i>Profile</a></li>
                    <li><a href="<?=base_url('profiles')?>"><i class="icon icon-info2 ml-3"></i>Bank & Kartu</a></li>
                    <li><a href="<?=base_url('address')?>"><i class="icon icon-info2 ml-3"></i>Buku Alamat</a></li>
                    <li><a href="<?=base_url('change-password')?>"><i class="icon icon-info2 ml-3"></i>Ubah Password</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="<?=base_url('order-history')?>">
                    <i class="icon icon-shopping-bag hotpink-text s-18"></i>
                    <span>Order History</span>
                </a>
            </li>
            
            <li class="treeview no-b relative">
                <a href="#">
                    <i class="icon icon-notifications hotpink-text s-18 "></i>
                    <span>Notification</span>
                    <span class="badge badge-sm bold r-20 badge-danger pull-right absolute" style="margin-top: -11px">1</span>
                </a>
            </li>
        </ul>
    </section>
    


</div>
<?php endif ?>
