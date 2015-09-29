<?php
$columns;
if($GLOBALS['package'] == 1){
	$columns = array(
    0 => array("titel" => 'Team name',"width" => 9),
    1 => array("titel" => 'Captain',"width" => 9),
    2 => array("titel" => 'Toplane',"width" => 9),
    3 => array("titel" => 'Jungler',"width" => 9),
    4 => array("titel" => 'Midlane',"width" => 9),
    5 => array("titel" => 'Adc',"width" => 9),
    6 => array("titel" => 'Support',"width" => 9),
    7 => array("titel" => 'Sub',"width" => 9),
    8 => array("titel" => 'Actions',"width" => 9));	
}

?>
  <div class='box box-solid box-primary'>
	<div class="box-header with-border">
		<h3 class="box-title">Team Management</h3>
		<div class="box-tools pull-right">
      		<button id='new_team' class='btn btn-sm btn-success'>New team</button>
   		</div>
	</div>
	<div class="box-body">
            <table id='table_teams' class='table table-bordered table-hover table-condensed table-striped '>
                <thead>
                    <tr>
                        <?php
                  			foreach ($columns as $key => $value) {
                  				if($value['titel']== 'Actions'){
                  					echo "<th width='10%'>".$value['titel']."</th>";
                  				}else {
                  	    			echo "<th>".$value['titel'] . "</th>";
                  				}
							}
                  			?>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
       </div>
</div>
    <script>
  
  
    $("#new_team").on('click',function(){
    	$.ajax({
    		url :'./config/teams/actions/new.php',
    		success : function(res){
    			$("#modal").html(res);
				$("#modal").modal('show');
    		}
    	})
    })
		$(document).on('click', '.edit', function() {
			$.ajax({
				url : './config/teams/actions/new.php',
				type : 'POST',
				data : {
					team_id : $(this).data('id')
				},
				success : function(res) {
					$("#modal").html(res);
					$("#modal").modal('show');
				}
			})
		})
		$(document).on('click', '.delete', function() {
			$.ajax({
				url : './config/teams/actions/delete.php',
				type : 'POST',
				data : {
					team_id : $(this).data('id')
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
			
				oTable = $('#table_teams').dataTable({
					//bLengthChange: false,
					"bScrollCollapse" : true,
					"aaSorting" : [[0, 'asc']],
					"aLengthMenu" : [[5, 10, 20, -1], [5, 10, 20, "All"] // change per page values here
					],
					"sAjaxSource" : "config/teams/paginas/home_sub.php",
					"bAutoWidth" : false,
					"bProcessing" : true,
					"iDisplayLength" : 20,
				});
				
		}
    </script>