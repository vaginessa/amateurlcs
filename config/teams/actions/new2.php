<?php
include $_SERVER['DOCUMENT_ROOT'] . '/functions.php';
$kicks;
if($GLOBALS['package'] == 1){
	$kicks = 2;
} 



if($_POST['tid']){
	
}else {
	$conn = sql_domain();
	$stmt = $conn->prepare('insert into teams(name,tag,captain_id,kicks_left)VALUES(:n,:t,:c,:k)');
	$stmt->bindParam(':n',$_POST['n']);
	$stmt->bindParam(':t',$_POST['t']);
	$stmt->bindParam(':c',$_POST['cid']);
	$stmt->bindParam(':k',$kicks);
	$stmt->execute();
	$team_id = $conn->lastInsertId();
	
	$stmt = $conn->prepare('update users set type = 3 where id = :uid');
	$stmt->bindParam(':uid',$_POST['cid']);
	$stmt->execute();
	echo $team_id;
}













