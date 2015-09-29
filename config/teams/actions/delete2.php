<?php
include $_SERVER['DOCUMENT_ROOT'] . '/functions.php';
$team_id = $_POST['team_id'];
$conn = sql_domain();

$stmt = $conn->prepare('select captain_id from teams where id = :t');
$stmt->bindParam(':t',$team_id);
$stmt->execute();

$result = $stmt->fetchAll();
$stmt = $conn->prepare('update users set type = 2 where id = :uid');
$stmt->bindParam(':uid',$result[0]['captain_id']);
$stmt->execute();

$stmt = $conn->prepare('select user_id from teams_roles where team_id = :t');
$stmt->bindParam(':t',$team_id);
$stmt->execute();
$result = $stmt->fetchAll();
foreach($result as $r){
	$stmt = $conn->prepare('update users set type = 2 where id = :uid');
	$stmt->bindParam(':uid',$r);
	$stmt->execute();
}

$stmt = $conn->prepare('delete from teams where id = :t');
$stmt->bindParam(':t',$team_id);
$stmt->execute();

$stmt = $conn->prepare('delete from teams_roles where team_id = :t');
$stmt->bindParam(':t',$team_id);
$stmt->execute();

?>