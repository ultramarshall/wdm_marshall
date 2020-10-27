<!-- <section class="content-header">
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url();?>"><i class="fa fa-dashboard"></i> <?php echo lang('msg_url_home');?></a></li>
		<?php
		$jml=count($breadcrumb);
		$i=1;
		$uri='/';
		foreach($breadcrumb as $bread){
			$bread=str_replace('_','-',$bread);
			if ($i<2)
			{
				$uri .= $bread . '/';
				echo '<li><a href="'.$uri.'" class="text-primary">'.$bread.'</a></li>';
			}elseif ($i==2){
				echo '<li class="active">'.$bread.'</li>';
				break;
			}
			++$i;
		}
		?>
	</ol>
</section> -->

<!-- <div class="page-title">
	<div class="title_left">
		<h3 class="judul_list"><?php 
		$judul=lang("msg_title");
		echo (!empty($judul)) ? $judul:ucwords(_MODULE_NAME_);?></h3>
	<div class="garis_judul hide"></div>
	</div>

	<div class="title_right hide">
		<div class="circle pull-right hvr-float-shadow">
			<span class="glyphicon glyphicon-flag inside pointer tool-help"></span>
		</div>
		<div class="circle pull-right hvr-float-shadow">
			<span class="glyphicon glyphicon-question-sign inside pointer tool-help"></span>
		</div>
	</div>
</div> -->
		
 <div class="row">
	<div class="col-12">
		<?php
		if (count($tooltips)>0){ ?>
		<div id="text-carousel" class="carousel slide" data-ride="carousel">
			<!-- Wrapper for slides -->
			<div class="row">
				<div class="col-xs-offset-1 col-xs-10">
					<div class="carousel-inner">
						<?php
						foreach($tooltips as $key=>$tool){ 
							$aktif="";
							if ($key==0){$aktif="active";}
							?>
							<div class="item <?=$aktif;?>">
								<div class="carousel-content">
									<div>
										<p><?=$tool;?></p>
									</div>
								</div>
							</div>
						<?php } ;?>
					</div>
				</div>
				<ol class="carousel-indicators">
					<?php
					foreach($tooltips as $key=>$tool){ 
						$aktif="";
						if ($key==0){$aktif="active";}
						?>
						<li data-target="#text-carousel" data-slide-to="<?=$key;?>" class="<?=$aktif;?>"></li>
					<?php };?>
				 </ol>
			</div>
			<!-- Controls --> 
			<a class="left carousel-control" href="#text-carousel" data-slide="prev" style="background:none !important">
			<span class="glyphicon glyphicon-chevron-left"></span>
		  </a>
		 <a class="right carousel-control" href="#text-carousel" data-slide="next" style="background:none !important">
			<span class="glyphicon glyphicon-chevron-right"></span>
		  </a>

		</div>
		<?php 
		}
		if (isset($header)){ 
			if (!empty($header)){ ?>
			<div class="x_panel">
				<div class="x_content">
					<?php echo $header;?>
				</div>
			</div>
		<?php } 
		} ?>
		<?php echo $content;?>
		<?php 
		if (isset($footer)){
			if (!empty($footer)){ ?>
			<div class="x_panel">
				<div class="x_content">
					<?php echo $footer;?>
				</div>
			</div>
		<?php } 
		}?>
	</div>
</div>


<!-- <div class="row hide">
	<div class="col-md-12">
		<div class="panel footer">
			<p class="footer text-green" style="margin:0 15px;">
				<em>
					Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  '| &nbsp;&nbsp;&nbsp;Engine : CodeIgniter version <strong>' . CI_VERSION . '</strong>' : '' ?>
			<span class="pull-right"><?php echo "Memory use  : " . $this->benchmark->memory_usage();?></span></em></p>
		</div>
	</div>
</div>

<div class="modal modal-default" id="modal_umum" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
  <?php echo form_open(base_url('ajax/save-option-combo'),array('id'=>'form_input_modal','role'=>'form"'));?>
    <div class="modal-content box">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="title_modal_umum">Tambah Data Baru</h4>
      </div>
      <div class="modal-body">
		&nbsp;
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"> <?=lang('msg_tombol_quit');?> </button>
        <span class="btn btn-sm btn-small btn-danger" id="proses_add_combo" ><i class="fa fa-save"></i> <?=lang('msg_tombol_save');?> </span>
      </div>
	  <div class="overlay hide" id="overlay_search">
		<i class="fa fa-refresh fa-spin"></i>
	</div>
    </div>
	<?php echo form_close();?>	
  </div>
</div> -->