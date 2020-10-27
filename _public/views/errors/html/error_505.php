 <div class="box">
    <div class="box-body">
		<div class="row">
			<div class="col-xs-12">
				<div class="box box-primary" style="padding-bottom:100px;">
					<div class="error-page text-center">
						<h3><i class="fa fa-warning text-yellow"></i> <?php echo lang('msg_error_data_title');?> </h3>
						<div class="error-details">
							 <?php echo lang('msg_error_data_content');?> 
						</div>
						<div class="error-actions">
							<a href="<?php echo base_url();?>" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-home"></span> <?php echo lang('msg_error_data_home');?> </a>
							<a href="<?php echo base_url($this->uri->segment(1));?>" class="btn btn-danger btn-lg btn-flat"><i class="fa fa-hand-o-left"></i> <?php echo lang('msg_error_data_back');?> </a>
							<a href="<?php echo base_url($this->uri->uri_string);?>" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-refresh"></span> <?php echo lang('msg_error_data_refresh');?> </a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
