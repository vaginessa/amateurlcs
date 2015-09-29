<?php
$columns = array(
	"name" => array("titel" => 'Name',"width" => 30),
	"type" => array("titel" => 'Type',"width" => 20),
	"actions" => array("titel" => 'Actions',"width" => 20));
?>
<div class='box box-solid box-primary'>
	<div class="box-header with-border">
		<h3 class="box-title">League Management</h3>
		<div class="box-tools pull-right">
      		<button id='new_league' class='btn btn-sm btn-success'>New league</button>
   		</div>
	</div>
	<div class="box-body">
		<table id='table_leagues' class='table table-bordered table-hover table-condensed table-striped '>
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


	$(document).on('click','.edit_league_rr',function(){
		$.ajax({
			url :'./config/leagues/round_robin/home.php',
			type :'POST',
			data : { lid: $(this).data('id')},
			success : function(res){
				$("#modal").html(res);
				$("#modal").modal('show');
			}
		})
	})

$(document).on('click','.add_teams_singlele',function(){
	$.ajax({
		url :'./config/leagues/singleele/home.php',
		type :'POST',
		data : { lid: $(this).data('id')},
		success : function(res){
			$("#modal").html(res);
			$("#modal").modal('show');
		}
	})
})
$(document).on('click','.start_single_ele',function(){
	$.ajax({
		url :'./config/leagues/start/single_ele.php',
		type :'POST',
		data : { lid: $(this).data('id')}		
	})
})




















	function NewLeague(id){
		$.ajax({
			url : './config/leagues/actions/new.php',
			type : 'POST',
			data : {
				league_id : id
			},
			success : function(res) {
				$("#modal").html(res);
				$("#modal").modal('show');
			}
		})
	}
	$("#new_league").on('click',function(){
		NewLeague();
	})	
	$(document).on('click', '.delete', function() {
		$.ajax({
			url : './config/leagues/actions/delete.php',
			type : 'POST',
			data : {
				league_id : $(this).data('id')
			},
			success : function(res) {
				$("#modal").html(res);
				$("#modal").modal('show');
			}
		})
	})
	$(document).on('click', '.edit', function() {
		NewLeague($(this).data('id'));
	})
	var oTable;
	LoadTable();
	function LoadTable() {
			oTable = $('#table_leagues').dataTable({
				//bLengthChange: false,
				"bScrollCollapse" : true,
				"aaSorting" : [[0, 'asc']],
				"aLengthMenu" : [[5, 10, 20, -1], [5, 10, 20, "All"] // change per page values here
				],
				"sAjaxSource" : "config/leagues/paginas/home_sub.php",
				"bAutoWidth" : false,
				"bProcessing" : true,
				"iDisplayLength" : 20,
			});
			
	}
</script>