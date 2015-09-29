<?php
include $_SERVER['DOCUMENT_ROOT'].'/functions.php';
$winning_team = $_POST['team'];
$match_id = $_POST['match_id'];

$conn = sql_domain();
$stmt = $conn->prepare('select * from matches_round_robin where id = :m');
$stmt->bindParam(':m',$match_id);
$stmt->execute();
$result = $stmt->fetchAll();
print_r($result);

$losing_team = 0;

if($winning_team == $result[0]['team_1']){
    $losing_team = $result[0]['team_2'];
}else{
    $losing_team = $result[0]['team_1'];
}

echo $winning_team.  " ".$losing_team;
// Set match result
$stmt = $conn->prepare('update matches_round_robin set winning_team = :w where id = :m');
$stmt->bindParam(':w',$winning_team);
$stmt->bindParam(':m',$match_id);
$stmt->execute();

// update points
$stmt = $conn->prepare('update leagues_round_robin_teams set points = points + 3,games_won = games_won + 1 , games_played = games_played +1 where team_id = :t and league_id = :l');
$stmt->bindParam(':t',$winning_team);
$stmt->bindParam(':l',$result[0]['league_id']);
$stmt->execute();

$stmt = $conn->prepare('update leagues_round_robin_teams set games_lost = games_lost + 1 , games_played = games_played +1 where team_id = :t and league_id = :l');
$stmt->bindParam(':t',$losing_team);
$stmt->bindParam(':l',$result[0]['league_id']);
$stmt->execute();








