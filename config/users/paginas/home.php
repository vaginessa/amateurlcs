<?php
$columns = array(
	"username" => array("titel" => 'Username',"width" => 30),
	"email" => array("titel" => 'Email',"width" => 20),
	"type" => array("titel" => 'Type',"width" => 10),
	"rank" => array("titel" => 'Rank',"width" => 10),
	"team" => array("titel" => 'Team',"width" => 20),
	"role" => array("titel" => 'Role',"width" => 20),
	"last_login" => array("titel" => 'Last login',"width" => 20),
	"actions" => array("titel" => 'Actions',"width" => 10)
);
?>
<div class='box box-solid box-primary'>
	<div class="box-header with-border">
		<h3 class="box-title">User Management</h3>
		<div class="box-tools pull-right">
      		<button id='new_user' class='btn btn-sm btn-success'>New user</button>
   		</div>
	</div>
	<div class="box-body">
		<table id='table_users' class='table table-bordered table-hover table-condensed table-striped '>
			<thead>
				<tr>
					<?php
					foreach ($columns as $key => $value) {
					if ($value['titel'] == 'Actions') {
					echo "<th width='" . $value['width'] . "%'>" . $value['titel'] . "</th>";
					}
					else {
					echo "<th>" . $value['titel'] . "</th>";
					}
					}
					?>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>
</div>
<script>
	$("#new_user").on('click', function() {
		$.ajax({
			url : './config/users/actions/new.php',
			success : function(res) {
				$("#modal").html(res);
				$("#modal").modal('show');
			}
		})
	})
	$(document).on('click', '.delete', function() {
		$.ajax({
			url : './config/users/actions/delete.php',
			type : 'POST',
			data : {
				user_id : $(this).data('id')
			},
			success : function(res) {
				$("#modal").html(res);
				$("#modal").modal('show');
			}
		})
	})
	$(document).on('click', '.edit', function() {
		$.ajax({
			url : './config/users/actions/new.php',
			type : 'POST',
			data : {
				user_id : $(this).data('id')
			},
			success : function(res) {
				$("#modal").html(res);
				$("#modal").modal('show');
			}
		})
	})
	var oTable;
	LoadTable();
	function LoadTable() {	
			oTable = $('#table_users').DataTable({
				//bLengthChange: false,
				"bScrollCollapse" : true,
				"aaSorting" : [[0, 'asc']],
				"aLengthMenu" : [[5, 10, 20, -1], [5, 10, 20, "All"] // change per page values here
				],
				"sAjaxSource" : "config/users/paginas/home_sub.php",
				"bAutoWidth" : false,
				"bProcessing" : true,
				"iDisplayLength" : 20,
			});		
	}
</script>