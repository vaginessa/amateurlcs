<?php
include $_SERVER['DOCUMENT_ROOT'].'/functions.php';
error_reporting(-1);
/// check all inputs
$user_id = $_POST['user_id'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$role_pref = $_POST['role_pref'];
$type = $_POST['type'];
$current_team = $_POST['current_team'];
$current_role = $_POST['current_role'];
$current_rank = $_POST['current_rank'];
if($user_id){
	// exists already -> update
	//main info 
	$conn = sql_domain();
	$stmt = $conn->prepare('update users set username  = :username,
									 email = :email,
									 type = :type,
									 role_pref = :role_pref
									 where id = :uid');
	$stmt->bindParam(':username',$username);
	$stmt->bindParam(':email',$email);
	$stmt->bindParam(':type',$type);
	$stmt->bindParam(':role_pref',$role_pref);
	$stmt->bindParam(':uid',$user_id);
	$stmt->execute();
	// if  pass is set
	if($password){
	$password_ = password_hash($password,PASSWORD_DEFAULT);	
	$stmt = $conn->prepare('update users set password = :pass where id = :uid');
	$stmt->bindParam(':pass',$password);
	$stmt->bindParam(':uid',$user_id);
	$stmt->execute();
	}
	// Delete team entries
	$stmt = $conn->prepare('delete from teams_roles where user_id = :u');
	$stmt->bindParam(':u',$user_id);
	$stmt->execute();
	// if teams are set
	if($current_team){
		
		
		
		
		$stmt = $conn->prepare('insert into teams_roles(team_id,role_id,user_id)VALUES(:t,:r,:u)');
		$stmt->bindParam(':t',$current_team);
		$stmt->bindParam(':r',$current_role);
		$stmt->bindParam(':u',$user_id);
		$stmt->execute();		
	}		
}else {
	// doesnt exist -> new user -> insert
	// is password set? if not rand string
	$password_ = "";
	if($password){
		$password_ = password_hash($password,PASSWORD_DEFAULT);	
	}else {		
		$randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 20);
		$password_ = password_hash($randomString,PASSWORD_DEFAULT);
	}	
	$conn = sql_domain();
	$stmt = $conn->prepare('insert into users(username,email,password,type,role_pref)VALUES(:u,:e,:p,:t,:r)');
	$stmt->bindParam(':u',$username);
	$stmt->bindParam(':e',$email);
	$stmt->bindParam(':p',$password_);
	$stmt->bindParam(':t',$type);
	$stmt->bindParam(':r',$role_pref);
	$stmt->execute();
	$user_id = $conn->lastInsertId();	

	$stmt = $conn->prepare('INSERT INTO users_statistics(user_id)VALUES(:user_id)');
	$stmt->bindParam(':user_id',$user_id);
	$stmt->execute();	
	if($current_team){
		$stmt = $conn->prepare('insert into teams_roles(team_id,user_id,role_id)VALUES(:t,:u,:r)');
		$stmt->bindParam(':t',$current_team);
		$stmt->bindParam(':u',$user_id);
		$stmt->bindParam(':r',$current_role);
		$stmt->execute();
	}
}
?>