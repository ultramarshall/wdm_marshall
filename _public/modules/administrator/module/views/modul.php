<?php 
	echo form_open_multipart($this->uri->uri_string,array('id'=>'form_input'));
	// echo script_tag(plugin_url("nestable/jquery.nestable.js"));
?>


			<div class="card mt-3">
				<div class="card-header">
					<div class="float-right">
						<?=$action;?>
					</div>
				</div>
						<div class="card-body">
							<menu id="nestable-menu" class="">
								<button class="btn btn-sm btn-warning btn-app" type="button" data-action="expand-all">Expand All</button>
								<button class="btn btn-sm btn-warning btn-app " type="button" data-action="collapse-all">Collapse All</button>
							</menu>
							<table class="table">
								<tr>
									<td>
									<textarea id="nestable-output" name="nestable-output" class="d-none"><?=$source_tree;?></textarea>
									<div class="dd" id="nestable">
										<ol class="dd-list" style="width: 100%">
											<?php echo $tree;?>
										</ol>
									</div>
									</td>
								</tr>
							</table>
						</div>
			</div>
		
<?php echo form_close();?>


<script>
	$(function(){
		$(document).ready(function(){
			loader();
		})

		$(".edit_modul").click(function(){
			var id = $(this).attr('data-id');
			$("#mdl_"+id).toggle();
		})
		
		$(".title_modul").keyup(function(){
			$(this).closest(".dd3-content").find(".judul").html($(this).val());
		})
		$(".icon_modul").change(function(){
			$(this).closest(".dd3-content").find("i").removeClass().addClass($(this).val());
		})


	})
</script>