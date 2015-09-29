<?php
error_reporting(0);
include $_SERVER['DOCUMENT_ROOT'].'/functions.php';
// for edit user
$user_id = $_POST['user_id'];

$conn = sql_domain();
$stmt = $conn->prepare('select * from users where id = :uid');
$stmt->bindparam(':uid',$user_id);
$stmt->execute();
$result = $stmt->fetchAll();
$result = $result[0];

$user_name = $result['username'];
$user_email = $result['email'];
$user_type = $result['type'];
$current_rank = UserGetStatistics($user_id);
$current_rank = $current_rank[0]['rank_solo'];
$role_pref = $result['role_pref'];



?>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php if($user_id){ echo "Edit user : ".$user_name;}else { echo "New user";}?></h4>
      </div>
      <div class="modal-body">   
      <form class='form form-horizontal'>
     	 <div class="form-group ">
		    <label for="inputEmail3" class="col-md-2 control-label">Username</label>
		    <div class="col-md-4">
		      <input id='username' type="text" class="form-control"  value="<?php echo $user_name;?>">		   
	   	 </div>
		      <label for="inputEmail3" class="col-md-2 control-label">Email</label>
		    <div class="col-md-4">
    			  <input id='email' type="text" class="form-control" value="<?php echo $user_email;?>">		   
		    </div>
		     </div>	
 		 <div class="form-group ">		 
		    <label for="inputEmail3" class="col-md-2 control-label">Type</label>
		    <div class="col-md-4">
		      <?php  GlobalTypeSelection('type',$user_type);?>
		    </div> 
		     <label for="inputEmail3" class="col-md-2 control-label">Role pref</label>
	   		 <div class="col-md-4">
				<input id='role_pref' type="text" class="form-control" value="<?php echo $role_pref;?>">
		    </div>
		     </div>	
		      <div class="form-group ">
		    <label for="inputEmail3" class="col-md-2 control-label">Current rank</label>
		    <div class="col-md-4">
				<?php  GlobalRankSelection('current_rank',$current_rank);?>
		    </div>		 
		    <label for="inputEmail3" class="col-md-2 control-label">Set password</label>
		    <div class="col-md-4">
				<input id='password' type="text" class='form-control'/>
		    </div>		 
 		 </div>
 		  <hr>
 		 <h4 class='form-section'>Team related</h4>  
 		 	         
       <div class="form-group ">
		    <label for="inputEmail3" class="col-md-2 control-label">Current team</label>
		    <div class="col-md-4">
				<?php  GetCurrentTeamSelection('current_team',GetTeamOfUser($user_id));?>
		    </div>		
		    <label for="inputEmail3" class="col-md-2 control-label">Current role</label>
		    <div class="col-md-4">
				<?php  GlobalRoleSelection('current_role', GetCurrentRoleOfUser($user_id));?>
		    </div>		        
 		 </div>

      </form>
      </div>
     <div class="modal-footer">
		<button type="button" data-dismiss='modal' class="btn btn-primary">Close</button>
		<button type='button'  data-dismiss='modal'  id='save_user' class='btn btn-success'>Save</button>
	</div>
    </div>
  </div>
<script>
	$("#save_user").on('click',function(){
		$.ajax({
			url :'./config/users/actions/new2.php',
			type :'POST',
			data : {
				user_id : "<?php echo $user_id;?>",
				username : $("#username").val(),
				email : $("#email").val(),
				type : $("#type").val(),
				role_pref : $("#role_pref").val(),
				current_team : $("#current_team").val(),
				current_role : $("#current_role").val(), 
				current_rank : $("#current_rank").val(),
				password :  $("#password").val()
			},
			success : function(){
				$("#table_users").DataTable().ajax.reload();
			}
		})
	})
	
	
		
</script>  


