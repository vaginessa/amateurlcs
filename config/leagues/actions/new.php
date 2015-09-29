<?php
error_reporting(0);
include $_SERVER['DOCUMENT_ROOT'].'/functions.php';
$league_id = $_POST['league_id'];

$conn = sql_domain();
$stmt = $conn->prepare('select * from leagues_config where id = :i');
$stmt->bindParam(':i',$league_id);
$stmt->execute();
$league = $stmt->fetchAll();
$league = $league[0];




?>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php if($league_id){ echo "Edit league : ".$league['name'];}else { echo "New league";}?></h4>
      </div>
      <div class="modal-body">   
      <form class='form form-horizontal'>
     	 <div class="form-group ">
		    <label for="inputEmail3" class="col-md-2 control-label">Name</label>
		    <div class="col-md-3">
		      <input id='name' type="text" class="form-control"  value="<?php echo $league['name'];?>">		   
	   		 </div>
		    <label for="inputEmail3" class="col-md-1 control-label">Type</label>
		    <div class="col-md-3">
    			<?php echo GlobalLeagueTypeSelection('league',$league['type']);?>
		    </div>
		 </div>				 
		<div  id='single_ele_package_1'>
			<hr>
		 <div class="form-group ">
		   	 <label for="inputEmail3" class="col-md-3 control-label">Round progression</label>
		    	<div class='col-md-3'>
		    	<select id='rp' class='form-control'>
		    		<option value="1">Manual</option>
		    	</select>		    		
		    </div>		 
		 </div>	
		<div class="form-group ">
		   	 <label for="inputEmail3" class="col-md-3 control-label">Match results</label>
		    	<div class='col-md-3'>
		    	<select id='mr' class='form-control'>
		    		<option value="1">Admin input</option>
		    	</select>		    		
		    </div>		 
		 </div>	
	</div>
		  <div id='round_robin_package_1'>
			  <hr>
			  <div class="form-group ">
				  <label for="inputEmail3" class="col-md-3 control-label">Amount of weeks</label>
				  <div class='col-md-3'>
					  <input type="text" class="form-control" id="weeks"/>
				  </div>
			  </div>
			  <div class="form-group ">
				  <label for="inputEmail3" class="col-md-3 control-label">Amount of teams</label>
				  <div class='col-md-3'>
					  <input type="text" class="form-control" id="teams" disabled/>
				  </div>
			  </div>
			  <div class="form-group ">
				  <label for="inputEmail3" class="col-md-3 control-label">Match results</label>
				  <div class='col-md-3'>
					  <select id='mr' class='form-control'>
						  <option value="1">Admin input</option>
					  </select>
				  </div>
			  </div>
		  </div>


	  </form>
      </div>
     <div class="modal-footer">
		<button type="button" data-dismiss='modal' class="btn btn-primary">Close</button>		
		<button type='button' data-dismiss='modal' id='btn_save_league' class='btn btn-success'>Save</button>
	</div>
    </div>
  </div>
<script>
	$(document).ready(function(){
		$("#single_ele_package_1").hide()
		$("#round_robin_package_1").hide()
	})


$("#weeks").on('keyup',function(){
	$("#teams").val(parseInt($(this).val())+ parseInt(1));
})



	$("#league").on('change',function(){
		if($(this).val() == 1){
			if("<?php echo $GLOBALS['package'];?>" == 1){
				$("#single_ele_package_1").show();
			}
		}
		if($(this).val() == 3){
			if("<?php echo $GLOBALS['package'];?>" == 1){
				$("#round_robin_package_1").show();
			}
		}
	})
	$("#btn_save_league").on('click',function(){
		$.ajax({
			url :'./config/leagues/actions/new2.php',
			type :'POST',
			data : {
				lid : "<?php echo $league_id;?>",
				n : $("#name").val(),
				t : $("#league").val(),
				rp : $("#mr").val(),
				mr :	$("#mr").val(),
				weeks : $("#weeks").val(),
				teams : $("#teams").val()

			},
			success : function(res){			
				$("#table_leagues").DataTable().ajax.reload();
			}
		})
	})		
</script>  


