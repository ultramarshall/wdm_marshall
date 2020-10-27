 <?php 
	$modul='';
	if (isset($_GET['module'])){
		$modul=$_GET['module'];
		$modul=explode('+', $modul);
		$modul=$modul[count($modul)-1];
	}
	
	$gender = $this->authentication->get_Info_User('kelamin');
	$user_photo = $this->authentication->get_Info_User('photo');
	$photo = $this->authentication->get_Preference('list_photo');
	$term = $this->authentication->get_Preference('term');
	$tahun = $this->authentication->get_Preference('tahun');
	
	if (!$photo){
		$photo = img_url('default-user.png');
	}else{
		if (file_exists(staft_path_relative($user_photo)) && !empty($user_photo)){
			$photo = staft_url($user_photo);
		}else{
			$photo = img_url('male.png');
			if ($gender=="P")
				$photo = img_url('female.png');
		}
	}
 ?>
<aside class="main-sidebar fixed offcanvas shadow">
   <section class="sidebar">
      <div class=" m-4" >
            <span class="ml-2" style="font-size: 20px; line-height: 30px;">
               WDS Test Programmer
            </span>
      </div>
      <div class="relative">
         <a data-toggle="collapse" href="#userSettingsCollapse" role="button" aria-expanded="false"
            aria-controls="userSettingsCollapse" class="btn-fab btn-fab-sm fab-right fab-top btn-primary shadow1 ">
         <i class="icon icon-cogs"></i>
         </a>
         <div class="user-panel p-3 light mb-2 bg-default">
            <div class="text-white">
               <div class="float-left image">
                  <img class="user_avatar" src="<?=$photo?>" alt="User Image">
               </div>
               <div class="float-left info pl-2">
                  <h6 class="font-weight-light fs-14 pt-1 mt-2 mb-2" style="text-transform: uppercase;"><?=$this->authentication->get_Info_User('nama_lengkap');?></h6>
                  <a href="#"><i class="icon-circle text-primary blink"></i> Online</a>
               </div>
            </div>
            <div class="clearfix"></div>
            <div class="collapse multi-collapse" id="userSettingsCollapse">
               <div class="list-group mt-3 shadow">
                  <a href="index.html" class="list-group-item list-group-item-action ">
                  <i class="mr-2 icon-umbrella text-blue"></i>Profile
                  </a>
                  <a href="#" class="list-group-item list-group-item-action"><i
                     class="mr-2 icon-cogs text-yellow"></i>Settings</a>
                  <a href="#" class="list-group-item list-group-item-action"><i
                     class="mr-2 icon-security text-purple"></i>Change Password</a>
               </div>
            </div>
         </div>
      </div>
      <?php echo _get_menu('kiri');?>
   </section>
</aside>
<script >
	var data="";
	var sts=0;
	var modul="";
	for(i=1;i<4;i++){
		if (i==1){
			modul ="<?php echo $this->uri->segment(1);?>";
		}else if (i==2){
			modul ="<?php echo $this->uri->segment(1) . '/' . $this->uri->segment(2);?>";
		}else if (i==3){
			modul ="<?php echo $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/' . $this->uri->segment(3);?>";
		}
		
		$('ul.side-menu').each(function() {
			$(this).find('li').each(function(){
				data = $(this).attr('data-modul');
				if (data==modul){
					$(this).addClass('active');
					$(this).parent().closest("li").addClass("active");
					$(this).parent().parent().closest("li").addClass("active");
					$(this).parent().parent().parent().closest("li").addClass("active");
					$(this).parent().parent().parent().parent().closest("li").addClass("active");
					$(this).parent().parent().parent().parent().parent().closest("li").addClass("active");
					
					$(this).parent().closest("ul").css({'display':'block'});
					$(this).parent().closest("ul").closest("ul").css({'display':'block'});
					
					sts=1;
					return false;
				}
			});
		});	
		if(sts==1)
			i=100;
	}
</script>