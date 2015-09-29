<?php
include $_SERVER['DOCUMENT_ROOT'] . '/functions.php';
?>
<div class="modal-dialog modal-nm">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h4 class="modal-title" id="myModalLabel"> Roster changes </h4>
		</div>
		<div class="modal-body">
			<div class='col-md-3'>
				<ul>
					<a href='#'><li class='links' data-name='team_info'>Team information</li></a>
					<a href='#'><li class='links' data-name='invite_player'>Invite a player</li></a>
					
					
				</ul>				
			</div>
			<div id='content' class='col-md-9'>
				
			</div>
		</div>
		<div class="modal-footer ">
			<button type="button" class="btn btn-default" data-dismiss="modal">
				Close
			</button>
			
		</div>
	</div>
</div>
<script>
	$('.links').on('click',function(){
		$.ajax({
			url : './teams/roster/'+ $(this).data('name')+ '.php',
			success : function(res){
				$('#content').html(res);
			}
		})		
	})
	
	
</script>