<?php
// Lets find users type first
$type = UserGetInfoByColumn('type','id',$_SESSION['user_id']);
switch($type){
	case 2 :
		// Free agent
		// Give me the option to create a team.
		CreateNewTeam();
		break;	
}
function CreateNewTeam(){
?>
 <link rel="stylesheet" type="text/css" href="../../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
    <div class="col-md-12">
    <div class='portlet light bordered '>
        <div class='portlet-title'>
            <div class='caption font-red-sunglo'>
                Please fill in a name and tag of your choosing for your team.
            </div>
        </div>
        <div class='portlet-body'>
            <form class='form form-horizontal'>
                <div class="form-group ">
                    <label for="inputEmail3" class="col-md-2 control-label">Team name</label>
                    <div class="col-md-4">
                        <input id='team_name' type="text" class="form-control">
                    </div>
                    <label for="inputEmail3" class="col-md-2 control-label">Team tag</label>
                    <div class="col-md-4">
                        <input id='team_tag' type="text" class="form-control" >
                    </div>
                </div>
                <div class="form-group ">
                    <label for="inputEmail3" class="col-md-2 control-label">Role</label>
                    <div class="col-md-4">
                        <select id='role' class="form-control">
                            <option></option>
                            <option value="1">Top</option>
                            <option value="2">Jungle</option>
                            <option value="3">Midlane</option>
                            <option value="4">Adc</option>
                            <option value="5">Support</option>
                        </select>
                    </div>
                </div>
                <div class="form-group ">
                    <label class="control-label col-md-2">Team logo</label>
                    <div class="col-md-9">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
                            </div>
                            <div>
													<span class="btn default btn-file">
													<span class="fileinput-new">
													Select image </span>
													<span class="fileinput-exists">
													Change </span>
													<input id='images' type="file" name="images">
													</span>
                                <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput">
                                    Remove </a>
                            </div>
                        </div>
                        <div class="clearfix margin-top-10">
                        	<p>
                        		If you do not select one, you will be given the tournament logo until you upload one yourself.
                        		Allowed types are png/jpg with a max size of 800kb. Aim for a 512x512 resolution.                  		
                        	</p>
                        </div>
                    </div>
                </div>
                <div class='form-group'>
                    <div class='col-md-3 col-md-offset-2'>
                        <button id='btn_save' type="button" class="btn green"><i class="fa fa-check"></i> Submit</button>
                   </div>
                </div>
           </form>
       </div>
    </div>
    <script type="text/javascript" src="../../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>	
     <script>
        $("#btn_save").on('click',function(){
            file = document.getElementById('images').files[0];
            var fd = new FormData();
            fd.append('team_name' , $("#team_name").val());
            fd.append('team_tag',$("#team_tag").val());
            fd.append('role',$("#role").val());
            fd.append('logo',file);
            $.ajax({
                url :'./team_mana/actions/create_team.php',
                type :'POST',
                data : fd,
                processData : false,
                contentType : false,
                success : function(res){
                	if(res == 0){
                		alert("Team name already exists");
                	}else if(res ==1){
                		window.location.reload();
                	}else if($res == 2){
                		alert('Something is wrong with your logo. Try again later');
                		window.location.reload();
                	}               	
                }
            })
        })
    </script>		
	<?php
}
?>
<script>
	if("<?php echo $type;?>" > 2){
		window.location.href= "index?module=teams&id=<?php echo GetTeamOfUser($_SESSION['user_id']);?>";
	}
</script>


