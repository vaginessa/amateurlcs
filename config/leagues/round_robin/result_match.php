<div class="modal-dialog modal-nm">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="myModalLabel"> Set the result for the match? </h4>
        </div>
        <div class="modal-body">
            <form class='form form-horizontal'>
                <div class="form-group">
                    <label class="col-md-4 control-label">Winning team</label>
                    <div class="col-md-8">
                        <select class="form-control" id="team">
                            <option></option>
                            <?php
                            include $_SERVER['DOCUMENT_ROOT'].'/functions.php';
                            $conn = sql_domain();
                            $stmt = $conn->prepare('select team_1,team_2 from matches_round_robin where id = :mid');
                            $stmt->bindParam(':mid',$_POST['match_id']);
                            $stmt->execute();
                            $teams = $stmt->fetchAll();
                            echo "<option value='".$teams[0]['team_1'] ."'>". TeamGetInfoByColumn('name','id',$teams[0]['team_1'])."</option>";
                            echo "<option value='".$teams[0]['team_2'] ."'>". TeamGetInfoByColumn('name','id',$teams[0]['team_2'])."</option>";
                            ?>
                        </select>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer ">
            <button type="button" class="btn btn-default" data-dismiss="modal">
                Close
            </button>
            <button id='confirm_winner' data-dismiss="modal" type="button"  class="btn btn-success">
                Confirm winner
            </button>
        </div>
    </div>
</div>
<script>

$("#confirm_winner").on('click',function(){
    if($("#team").val() != "") {
        $.ajax({
            url: './config/leagues/round_robin/result_match2.php',
            type: 'POST',
            data: {
                match_id: "<?php echo $_POST['match_id'];?>",
                team: $("#team").val()
            },
            success : function(){
                ReloadMatches()
            }
        })
    }
})

</script>


