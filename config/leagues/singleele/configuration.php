<?php
error_reporting(0);
include $_SERVER['DOCUMENT_ROOT'].'/functions.php';
$league_id = $_POST['lid'];
$lid = $league_id;
$conn = sql_domain();
$stmt = $conn->prepare('select * from leagues_config where id = :i');
$stmt->bindParam(':i',$league_id);
$stmt->execute();
$league = $stmt->fetchAll();
$league = $league[0];
?>
<div class="row">
    <div class="col-md-6">
        <div class='box box-solid box-primary'>
            <div class="box-header with-border">
                <h3 class="box-title">Teams participating in this league</h3>
            </div>
            <div class="box-body">
        <form class="form form-horizontal">
<div class="form-group ">
    <label for="inputEmail3" class="col-md-2 control-label">Name</label>
    <div class="col-md-4">
        <input id='name' type="text" class="form-control"  value="<?php echo $league['name'];?>">
    </div>
    <label for="inputEmail3" class="col-md-2 control-label">Type</label>
    <div class="col-md-4">
        <input type="text" class="form-control" value="<?php echo GlobalGetLeagueType($league['type']);?>" disabled/>
    </div>
</div>
<div style='display:none;'  id='single_ele_package_1'>
    <hr>
    <div class="form-group">
        <div class="col-md-4">
            <button type='button' id='begin_tournament' class="btn btn-success">Lets begin this shit</button>
        </div>
    </div>


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
        </form>
                </div>
            </div>
        </div>
</div>
    <div class="col-md-6">
        <div class='box box-solid box-primary'>
            <div class="box-header with-border">
                <h3 class="box-title">Teams participating in this league</h3>
            </div>
            <div class="box-body">
                <form class="form form-horizontal">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-md-1 control-label">Team</label>
                        <div class="col-md-4">
                            <?php echo GetCurrentTeamSelection('team');?>
                        </div>
                        <div class="col-md-6">
                            <button type='button' id='btn_add_team' class='btn btn-success'>Add team</button>
                        </div>
                    </div>
                </form>
                <table id='list_of_teams' class='table table-bordered'>
                    <thead>
                    <tr>
                        <th>Team name</th>
                        <th>Captain</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody id='tbody_list'>
                    <?php
                    $conn = sql_domain();
                    $stmt = $conn->prepare('select * from leagues_single_ele_teams where league_id = :l');
                    $stmt->bindParam(':l',$lid);
                    $stmt->execute();
                    $result = $stmt->fetchAll();
                    foreach($result as $r){
                        echo "<tr>";
                        echo "<td>". TeamGetInfoByColumn('name','id',$r['team_id']) ."</td>";
                        echo "<td>". UserGetInfoByColumn('username','id',TeamGetInfoByColumn('captain_id','id',$r['team_id'])) ."</td>";
                        if($r['defeated'] == 0){
                            echo "<td>Active</td>";
                        }
                        if($r['defeated'] == 1){
                            echo "<td>Defeated</td>";
                        }
                        echo "<td><button type='button'  data-id='".$r['id'] ."' class='btn btn_delete_team btn-danger'><i class='fa fa-times'></i></button></td>";
                        echo "</tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>


    $("#begin_tournament").on('click',function(){
        $.ajax({
            url :'./config/leagues/start/single_ele.php',
            data : {
                lid : "<?php echo $league_id;?>"
            },
            type :'POST'
        })
    })

    $("#btn_add_team").on('click',function(){
        $.ajax({
            url :'./config/leagues/singleele/add_team.php',
            type :'POST',
            data : {
                lid : "<?php echo $league_id;?>",
                team_id : $("#team").val()
            },
            success : function(){
                $("#team").val(" ");
                ReloadConfiguration('<?php echo $league_id;?>');

            }
        })
    })




if("<?php echo $league_id;?>"){
    if("<?php echo $GLOBALS['package'];?>" == 1){
        $("#single_ele_package_1").show();
    }
}





</script>



