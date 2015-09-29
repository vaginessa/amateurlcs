<?php
include $_SERVER['DOCUMENT_ROOT'] . '/functions.php';

// get previous guy
$conn = sql_domain();
$stmt = $conn->prepare('select user_id from teams_roles where team_id = :t and role_id = :r');
$stmt->bindParam(':t',$_POST['t']);
$stmt->bindParam(':r',$_POST['r']);
$stmt->execute();
$user = $stmt->fetchAll();

if($user){
	$stmt = $conn->prepare('update users set type = 2 where id = :u');
	$stmt->bindParam(':u',$user[0]['user_id']);
	$stmt->execute();
	
	$stmt = $conn->prepare('delete from teams_roles where user_id = :u');
	$stmt->bindParam(':u',$user[0]['user_id']);
	$stmt->execute();
	
	
}
$stmt = $conn->prepare('update users set type = 3 where id = :u');
$stmt->bindParam(':u',$_POST['u']);
$stmt->execute();

$stmt = $conn->prepare('insert into teams_roles(team_id,user_id,role_id)VALUES(:t,:u,:r)');
$stmt->bindParam(':u',$_POST['u']);
$stmt->bindParam(':t',$_POST['t']);
$stmt->bindParam(':r',$_POST['r']);
$stmt->execute();











?>