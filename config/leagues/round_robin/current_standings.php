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
$stmt = $conn->prepare('select * from leagues_config_round_robin where league_id = :i');
$stmt->bindParam(':i',$league_id);
$stmt->execute();
$config = $stmt->fetchAll();
$config = $config[0];
// Count teams
$stmt = $conn->prepare('select count(*) as count from leagues_round_robin_teams where league_id = :lid');
$stmt->bindParam(':lid',$league_id);
$stmt->execute();
$count = $stmt->fetchAll();
$count = $count[0]['count'];
?>
<div class="row">
    <div class="col-md-12">
        <div class='box box-solid box-primary'>
            <div class="box-header with-border">
                <h3 class="box-title">Main configuration</h3>
            </div>
            <div class="box-body">
                <?php if($count< $config['amount_of_teams']){?>
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
                <?php }else {
                    ?>
                    <form class="form form-horizontal">
                        <div class="form-group">
                            <div class="col-md-6">
                                <button type='button' id='btn_create_rr_matches' class='btn btn-success'>Create the matches</button>
                            </div>
                        </div>
                    </form>


                    <?php
                } ?>
                <table id='list_of_teams' class="table table-bordered table-condensed">
                    <thead>
                    <tr>
                        <th>Team name</th>
                        <th>Captain</th>
                        <th>Points</th>
                        <th>Won/Lost/Played</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $stmt = $conn->prepare('select * from leagues_round_robin_teams where league_id = :lid');
                    $stmt->bindParam(':lid',$league_id);
                    $stmt->execute();
                    $teams = $stmt->fetchAll();
                    foreach($teams as $team){
                        echo "<tr>";
                        echo "<td>". $team['team_id']."</td>";
                        echo "<td>". UserGetInfoByColumn('username','id',TeamGetInfoByColumn('captain_id','id',$team['team_id'])) ."</td>";
                        echo "<td>". $team['points'] ."</td>";
                        echo "<td>". $team['games_won'] ."/". $team['games_lost']."/". $team['games_played']."</td>";
                        echo "<td><button class='btn btn-danger'>Remove</button></td>";
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

    $("#btn_create_rr_matches").on('click',function(){
        $.ajax({
            url :'./config/leagues/round_robin/create_matches.php',
            type :'POST',
            data : {
                lid : "<?php echo $_POST['lid'];?>"
            }
        })
    })


    $("#list_of_teams").DataTable();
    $("#btn_add_team").on('click',function(){
        $.ajax({
            url :'./config/leagues/round_robin/add_team.php',
            type :'POST',
            data : {
                lid : "<?php echo $league_id;?>",
                team_id : $("#team").val()
            },
            success : function(){
                $("#team").val(" ");
                ReloadStandings('<?php echo $league_id;?>');
            }
        })
    })




</script>
