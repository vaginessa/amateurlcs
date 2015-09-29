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
                <p>
                    Confirm team <b><?php echo $_POST['team_id'];?></b>
                </p>
            </form>
        </div>
        <div class="modal-footer ">
            <button type="button" class="btn btn-default" data-dismiss="modal">
                Close
            </button>
            <button id='confirm_winner' type="button"  class="btn btn-success">
                Confirm winner
            </button>
        </div>
    </div>
</div>
<script>
    $("#confirm_winner").on('click',function(){
        $.ajax({
            url :'./config/leagues/singleele/result_match2.php',
            type :'POST',
            data : {
                match_id : "<?php echo $_POST['match_id'];?>",
                team_id : "<?php echo $_POST['team_id'];?>",
                league_id : "<?php echo $_POST['league_id'];?>"
            }
        })
    })



</script>


