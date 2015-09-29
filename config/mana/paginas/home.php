<div class="row">
	<div class='col-md-12'>
		<div class='box box-primary'>
			<div class="box-header with-border">
				<h3 class="box-title">Platform management</h3>
			</div>
			<div class="box-body">
				<div class="col-md-4">
					<div class='box box-primary'>
						<div class="box-header with-border">
							<h3 class="box-title">Basic package</h3>
						</div>
						<form class='form form-horizontal'>
							<div class="box-body">
								<?php Regionselect('Region select','region_select');?>
								<?php ManagementUIBuilderEnableDisable('Registration','registration_open');?>	
								<?php ManagementUIBuilderEnableDisable('Login','enable_login');?>
								<?php ManagementUIBuilderEnableDisable('Team creation','team_creation');?>
								<?php ManagementUIBuilderEnableDisable('Change teamname','change_teamname');?>
								<?php ManagementUIBuilderEnableDisable('Pass captainship','pass_captainship');?>
								
							</div>													
						</form>
					</div>
				</div>				
				</div>		
		</div>
	</div>	
</div>
<script>
	$(document).on('change','.fields',function(){	
		$.ajax({
			url :'./config/mana/paginas/home_sub.php',
			type :'POST',
			data : {
				field : $(this).attr('id'),
				value : $(this).val()
			}
		})		
	})	
</script>

