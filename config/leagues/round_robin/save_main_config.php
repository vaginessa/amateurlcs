<?php
include $_SERVER['DOCUMENT_ROOT'].'/functions.php';
$conn = sql_domain();
$stmt = $conn->prepare('update leagues_config_round_robin set current_week = :w where league_id = :l');
$stmt->bindParam(':w',$_POST['current_week']);
$stmt->bindParam(':l',$_POST['league_id']);
$stmt->execute();
?>