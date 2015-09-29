<?php
include $_SERVER['DOCUMENT_ROOT'].'/functions.php';
error_reporting(1);
$logo = $_FILES['logo']['tmp_name'];

$conn = sql_domain();
$stmt = $conn->prepare('update users set type = 3 where id = :uid');
$stmt->bindParam(':uid',$_SESSION['user_id']);
$stmt->execute();
$conn = null;

$conn = sql_domain();
$stmt = $conn->prepare('INSERT into teams(name,tag,captain_id,kicks_left)VALUES(:name,:tag,:captain_id,:kicks)');
$stmt->bindParam(':name',$_POST['team_name']);
$stmt->bindParam(':tag',$_POST['team_tag']);
$stmt->bindParam(':captain_id',$_SESSION['user_id']);
$stmt->bindParam(':kicks',GetPlatforminfo('team_kicks'));
$stmt->execute();
$team_id = $conn->lastInsertId();
//Insert user into role
if($team_id != 0){
InsertUserRole($team_id,$_SESSION['user_id'],$_POST['role']);
// Upload logo if set
if($_FILES['logo']['size']){	
	if($_FILES['logo']['size'] < 800000 && $_FILES['logo']['type'] == 'image/png' || $_FILES['logo']['size'] < 800000 && $_FILES['logo']['type'] == 'image/jpeg'){		
		if(move_uploaded_file($logo, $_SERVER['DOCUMENT_ROOT']. 'assets/teams/'.$GLOBALS['subdomain'].'/'.$team_id.'.png')){
			echo "1";			
		}		else {
			echo "2";
		}
	}
}
}else {
	echo "0";
}
?>