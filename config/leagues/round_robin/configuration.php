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

?>
<div class="row">
    <div class="col-md-12">
        <div class='box box-solid box-primary'>
            <div class="box-header with-border">
                <h3 class="box-title">Main configuration</h3>
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
                    <div class="form-group ">
                        <label for="inputEmail3" class="col-md-2 control-label">Current week</label>
                        <div class="col-md-4">
                            <select id='week' class="form-control">
                                <option value="0" <?php if($config['current_week'] == 0){ echo "selected";}?>>Not begun yet</option>
                                <?php
                                for($i=1;$i <= $config['weeks'];$i++){
                                    if($config['current_week'] == $i){
                                        echo "<option value='" .$i."' selected>Week ". $i."</option>";
                                    }else{
                                        echo "<option value='" .$i."'>Week ". $i."</option>";
                                    }
                                }
                                ?>

                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-4 col-md-offset-2">
                            <button type='button' id='save_main_config' class="btn btn-success">Save</button>
                        </div>
                    </div>
                    <hr>
                    <div id='round_robin_package_1'>
                        <div class="form-group ">
                            <label for="inputEmail3" class="col-md-3 control-label">Amount of weeks</label>
                            <div class='col-md-3'>
                                <input type="text" class="form-control" id="weeks" value="<?php echo $config['weeks'];?>" disabled>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="inputEmail3" class="col-md-3 control-label">Amount of teams</label>
                            <div class='col-md-3'>
                                <input type="text" class="form-control" id="teams" value="<?php echo $config['amount_of_teams'];?>" disabled/>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="inputEmail3" class="col-md-3 control-label">Match results</label>
                            <div class='col-md-3'>
                                <select id='mr' class='form-control'>
                                    <option value="1" <?php if($config['match_results'] == 1){ echo "selected";};?> >Admin input</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $("#save_main_config").on('click',function(){
        $.ajax({
            url :'./config/leagues/round_robin/save_main_config.php',
            type :'POST',
            data : {
                current_week : $("#week").val(),
                league_id : "<?php echo $_POST['lid'];?>"
            }
        })
    })
</script>
