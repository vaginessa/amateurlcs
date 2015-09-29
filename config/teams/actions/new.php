<?php
error_reporting(0);
include $_SERVER['DOCUMENT_ROOT'].'/functions.php';
$team_id = $_POST['team_id'];
?>

<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php if($team_id){ echo "Edit team : ".TeamGetInfoByColumn('name','id',$team_id);}else { echo "New team";}?></h4>
      </div>
      <div class="modal-body">   
      <form class='form form-horizontal'>
     	 <div class="form-group ">
		    <label for="inputEmail3" class="col-md-2 control-label">Name</label>
		    <div class="col-md-4">
		      <input id='name' type="text" class="form-control"  value="<?php echo TeamGetInfoByColumn('name','id',$team_id);?>">		   
	   	 </div>
		      <label for="inputEmail3" class="col-md-2 control-label">Tag</label>
		    <div class="col-md-2">
    			  <input id='tag' type="text" class="form-control" value="<?php echo TeamGetInfoByColumn('tag','id',$team_id);?>">		   
		    </div>
		     </div>	
		    <div class="form-group ">
		    <label for="inputEmail3" class="col-md-2 control-label">Captain</label>
		    <div class="col-md-4">
		     <?php echo GetUserSelection('captain',TeamGetInfoByColumn('captain_id','id',$team_id));?>   
	   	    </div>	     
		     </div>	 	    
		       <?php
		       if($team_id){
		       	echo "<hr>";  				
					switch($GLOBALS['package']){
						case 1:
							 for($i=1;$i<6;$i++){
							 	echo "<div class='form-group'>";
								 echo ' <label for="inputEmail3" class="col-md-2 control-label">'. GlobalGetRole($i).'</label>';
								 echo '<div class="col-md-5">';
								GetUserSelection($i,GetUserForRosterRole($i,$team_id),'role_selection');
								 echo "</div>";
								 echo "</div>";					
							 }
							echo "<div class='form-group'>";
							 echo ' <label for="inputEmail3" class="col-md-2 control-label">'. GlobalGetRole(9).'</label>';
							 echo '<div class="col-md-5">';
							GetUserSelection(9,GetUserForRosterRole(9,$team_id),'role_selection');
							echo "</div>";
							echo "</div>";			
							break;							
					}				 
			  }
		     ?>	     		      		     		      
      </form>
      </div>
     <div class="modal-footer">
		<button type="button" data-dismiss='modal' class="btn btn-primary">Close</button>
		<button type='button'  data-dismiss='modal'  id='save_team' class='btn btn-success'>Save</button>
	</div>
    </div>
  </div>

<script>

  $
	var team_id ="<?php echo $team_id;?>";
	$(".role_selection").on('change',function(){
		$.ajax({
			url : './config/teams/actions/changeroster.php',
			type :'POST',
			data : {
				t : team_id,
				r : $(this).attr('id'),
				u : $(this).val()
			}
		})
	})



$("#save_team").on('click',function(){
	$.ajax({
		url  :'./config/teams/actions/new2.php',
		type :'POST',
		data : {
			tid : "<?php echo $team_id;?>",
			n : $("#name").val(),
			t : $("#tag").val(),
			cid : $("#captain").val() ,			
		},
		success : function(res){
			team_id = res;
		$("#table_teams").DataTable().ajax.reload();		
		}
	})
})
</script>  

