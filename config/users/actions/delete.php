<?php
include $_SERVER['DOCUMENT_ROOT'] . '/functions.php';
?>
<div class="modal-dialog modal-nm">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h4 class="modal-title" id="myModalLabel"> Delete user </h4>
		</div>
		<div class="modal-body">
			<form class='form form-horizontal'>
				<p>
					Sure you want to delete this user?
				</p>
			</form>
		</div>
		<div class="modal-footer ">
			<button type="button" class="btn btn-default" data-dismiss="modal">
				Close
			</button>
			<button id='delete' type="button" data-dismiss="modal" class="btn red">
				Delete
			</button>
		</div>
	</div>
</div>
<script>
	$("#delete").on('click',function(){
		$.ajax({
			url :'./config/users/actions/delete2.php',
			type :'POST',
			data : {
				user_id : '<?php echo $_POST['user_id']; ?>'
					},
			success : function(res){
				$("#table_users").DataTable().ajax.reload();
							}
			})
		})
</script>