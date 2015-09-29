<?php
include $_SERVER['DOCUMENT_ROOT'].'/functions.php';

// get match info, aka boith teams
$conn = sql_domain();
$stmt = $conn->prepare('select * from matches_single_ele where id = :mid');
$stmt->bindParam(':mid',$_POST['match_id']);
$stmt->execute();
$result = $stmt->fetchAll();
//print_r($result);
$match_id = $result[0]['id'];
$league_id = $result[0]['league_id'];
$round_of_match = $result[0]['round_id'];
$winning_team = 0;
$losing_team = 0;
if($_POST['team_id'] == $result[0]['team_1']){
    $winning_team = $_POST['team_id'];
    $losing_team = $result[0]['team_2'];
}

if($_POST['team_id'] == $result[0]['team_2']){
    $winning_team = $_POST['team_id'];
    $losing_team = $result[0]['team_1'];
}



// asign winner to a match in the next round
$stmt = $conn->prepare('select * from matches_single_ele where round_id = :r - 1 and league_id = :l and team_1 = 0 or  round_id = :r - 1 and league_id = :l and team_2 = 0 limit 1');
$stmt->bindParam(':r',$round_of_match);
$stmt->bindParam(':l',$result[0]['league_id']);
$stmt->execute();
$result = $stmt->fetchAll();

if($result[0]['team_1'] == 0){
    $stmt =$conn->prepare('update matches_single_ele set team_1 = :w where id = :m');
    $stmt->bindParam(':w',$winning_team);
    $stmt->bindParam(':m',$result[0]['id']);
    $stmt->execute();
}else{
    $stmt =$conn->prepare('update matches_single_ele set team_2 = :w where id = :m');
    $stmt->bindParam(':w',$winning_team);
    $stmt->bindParam(':m',$result[0]['id']);
    $stmt->execute();
}

// set winner of the match
$stmt = $conn->prepare('update matches_single_ele set winning_team = :w where id = :m');
$stmt->bindParam(':w',$winning_team);
$stmt->bindParam(':m',$match_id);
$stmt->execute();

// set winner into next round
$stmt = $conn->prepare('update leagues_single_ele_teams set current_round = :r - 1 where team_id = :t and league_id = :lid');
$stmt->bindParam(':r',$round_of_match);
$stmt->bindParam(':t',$winning_team);
$stmt->bindParam(':lid',$league_id);
$stmt->execute();
// set loser to defeated
$stmt = $conn->prepare('update leagues_single_ele_teams set defeated =  1 where team_id = :t and league_id = :lid');
$stmt->bindParam(':t',$losing_team);
$stmt->bindParam(':lid',$league_id);
$stmt->execute();















