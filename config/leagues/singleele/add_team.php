<?php
include $_SERVER['DOCUMENT_ROOT'] . 'functions.php';
$lid = $_POST['lid'];
$tid = $_POST['team_id'];
$conn = sql_domain();
$stmt = $conn->prepare('insert into leagues_single_ele_teams(league_id,team_id)VALUES(:l,:t)');
$stmt->bindParam(':l',$lid);
$stmt->bindParam(':t',$tid);
$stmt->execute();
?>