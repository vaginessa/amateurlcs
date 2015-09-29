<?php
include $_SERVER['DOCUMENT_ROOT'].'/functions.php';
$league_id = $_POST['lid'];
$lid = $league_id;
$conn = sql_domain();
$stmt = $conn->prepare('select week_id from matches_round_robin where league_id = :i group by week_id');
$stmt->bindParam(':i',$league_id);
$stmt->execute();
$league = $stmt->fetchAll();

$stmt = $conn->prepare('select current_week from leagues_config_round_robin where league_id = :l');
$stmt->bindParam(':l',$lid);
$stmt->execute();
$week = $stmt->fetchAll();



?>
<div class="box box-solid">
    <div class="box-body">
        <div class="box-group" id="accordion">
            <?php
            foreach($league as $l) {
                $stmt = $conn->prepare('select * from matches_round_robin where league_id = :lid and week_id = :w');
                $stmt->bindParam(':lid', $league_id);
                $stmt->bindParam(':w', $l['week_id']);
                $stmt->execute();
                $res = $stmt->fetchAll();
                echo ' <div class="panel box">
                <div class="box-header with-border">
                    <h4 class="box-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse'.$l['week_id'] .'">';
                echo 'Week '.$l['week_id'];
                echo '</a>
                    </h4>
                </div>
                <div id="collapse'. $l['week_id'].'" class="panel-collapse collapse';
                if($week[0]['current_week'] == $l['week_id']) {
                    echo "in";
                }
                echo '">
                    <div class="box-body">';

                echo "<table class='table'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>Team 1</th>";
                echo "<th>Team 2</th>";
                echo "<th>Winning team</th>";
                echo "</tr>";
                echo "<tbody>";
                foreach($res as $r){
                echo "<tr class='matches' data-match='". $r['id']."'>";
                    echo "<td>". TeamGetInfoByColumn('name','id',$r['team_1'])."</td>";
                    echo "<td>".TeamGetInfoByColumn('name','id',$r['team_2'])."</td>";
                    echo "<td>".TeamGetInfoByColumn('name','id',$r['winning_team']) ."</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
                echo '</div>
                </div>
            </div>';
            }
            ?>
        </div>
    </div><!-- /.box-body -->
</div><!-- /.box -->
<script>
    $('.matches').on('click',function(){
        $.ajax({
            url :'./config/leagues/round_robin/result_match.php',
            type :'POST',
            data : {
                match_id : $(this).data('match')
            },
            success : function(res){
                $("#modal2").html(res);
                $("#modal2").modal('show');
            }
        })
    })



</script>

