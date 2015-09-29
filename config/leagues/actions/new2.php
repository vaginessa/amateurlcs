<?php
include $_SERVER['DOCUMENT_ROOT'].'/functions.php';


$league_id = $_POST['lid'];

// General
$n = $_POST['n'];
$t = $_POST['t'];


// Single ele
$rp = $_POST['rp'];
$mr = $_POST['mr'];

// Round Robin
$weeks = $_POST['weeks'];
$teams = $_POST['teams'];



if($league_id != 0){
}else {
	$conn = sql_domain();
	$stmt = $conn->prepare('insert into leagues_config(name,type)VALUES(:n,:t)');
	$stmt->bindParam(':n',$n);
	$stmt->bindParam(':t',$t);
	$stmt->execute();
	$league_id = $conn->lastInsertId();
	if($t == 1){
		$stmt = $conn->prepare('insert into leagues_config_single_ele(league_id,current_round,round_progression,match_results)VALUES(:lid,0,:rp,:mr)');
		$stmt->bindParam(':lid',$league_id);
		$stmt->bindParam(':rp',$rp);
		$stmt->bindParam(':mr',$mr);
		$stmt->execute();
	}
	if($t == 3){
		$stmt = $conn->prepare('insert into leagues_config_round_robin(league_id,weeks,current_week,amount_of_teams,match_results)VALUES
		(:l,:w,0,:t,:mr)');
		$stmt->bindParam(':l',$league_id);
		$stmt->bindParam(':w',$weeks);
		$stmt->bindParam(':t',$teams);
		$stmt->bindParam(':mr',$mr);
		$stmt->execute();


	}
}







