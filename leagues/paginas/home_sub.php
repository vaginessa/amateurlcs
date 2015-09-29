<?php
include $_SERVER['DOCUMENT_ROOT'] . 'functions.php';
//
$lid = $_POST['league_id'];
//Determine type
$conn = sql_domain();
$stmt = $conn->prepare('select * from leagues_config where id = :lid');
$stmt->bindParam(':lid',$lid);
$stmt->execute();
$result = $stmt->fetchAll();
if($result[0]['type'] == 3){
    // Round Robin
    echo '<table class="table table-bordered table-striped table-hover">';
    echo '<thead><tr>';
    echo '<th width="15%">Team</th>';
    echo '<th>Points</th>';
    echo '<th>Games played</th>';
    echo '<th>Games won</th>';
    echo '<th>Games lost</th>';
    // Get amount of weeks
    $weeks = RoundRobinInfoByColumn('weeks','league_id',$lid);
    for($i = 1;$i<=$weeks;$i++){
        echo "<th>Week " . $i ."</th>";
    }
    echo "</tr></thead>";
    echo "<tbody>";
    // Get teams
    $stmt = $conn->prepare('select t.id,name,points,games_played,games_won,games_lost from leagues_round_robin_teams as l join teams as t on l.team_id = t.id where league_id = :lid');
    $stmt->bindParam(':lid',$lid);
    $stmt->execute();
    $teams = $stmt->fetchAll();

    foreach($teams as $t){
        echo "<tr>";
        echo "<td>". $t['name'] ."</td>";
        echo "<td>". $t['points'] ."</td>";
        echo "<td>". $t['games_played'] ."</td>";
        echo "<td>". $t['games_won'] ."</td>";
        echo "<td>". $t['games_lost'] ."</td>";
        $week = 1;
        for($i= 1;$i<=$weeks;$i++) {
            $stmt = $conn->prepare('select * from matches_round_robin where league_id = :lid and week_id = :w and team_1 = :t or league_id = :lid and week_id = :w and team_2 = :t');
            $stmt->bindParam(':lid', $lid);
            $stmt->bindParam(':w', $week);
            $stmt->bindParam(':t', $t['id']);
            $stmt->execute();
            $r = $stmt->fetchAll();
            if($r[0]['winning_team'] == $t['id']){
                echo "<td>WON</td>";
            }else  if($r[0]['winning_team'] == 0){
                echo "<td>TBA</td>";
            }else{
                echo "<td>LOST</td>";
            }
            $week++;
        }
        echo "</tr>";
   }
    echo "</tbody>";
    echo "</table>";
}
?>