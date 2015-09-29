<?php
include $_SERVER['DOCUMENT_ROOT'].'/functions.php';
// File to start a single ele league
// League to start?
$league_id = $_POST['lid'];

//Teams tellen 
// Count amount of teams
$conn= sql_domain();
$stmt = $conn->prepare('select count(*) as aantal from leagues_single_ele_teams where league_id = :lid');
$stmt->bindParam(':lid',$league_id);
$stmt->execute();
$result = $stmt->fetchAll();
$aantal = $result[0]['aantal'];

$stmt = $conn->prepare('select team_id from leagues_single_ele_teams where league_id = :lid');
$stmt->bindParam(':lid',$league_id);
$stmt->execute();
$teams = $stmt->fetchAll();


// op basis van teams =>
if($aantal == 2){
	// teams = 2
	// 1 final
	$teller = 1;
	$team_1 = 0;
	$team_2 = 0;	
	$round = 1;
	foreach($teams as $team)
	{	
		UpdateTeamToRound(1, $team['team_id'], $league_id);
		if($teller ==1){
			$team_1 = $team['team_id'];
			$teller++;
		}else{
			$team_2 = $team['team_id'];
		}
	}
	
	InsertIntoMatch(1,$team_1,$team_2,1);
}
if($aantal == 3){
	// teams = 3
	// 2 teams in semi , 1 in final( bye)	
	$bye_ronde = 1;
	$begin_ronde = 2;
	$byes = 1;
	$bye_position = 1;
	$match_position = 1;
	$teller = 1;
	foreach($teams as $team){
		if($byes > 0){			
			InsertIntoMatch($bye_ronde,$team['team_id'],0,$bye_position);
			UpdateTeamToRound($bye_ronde, $team['team_id']);	
			$bye_position++;
			$byes = $byes - 1;
		}else {
			if($teller ==1){
				$team_1 = $team['team_id'];
				UpdateTeamToRound($begin_ronde, $team['team_id']);	
				$teller++;
			}else{
				$team_2 = $team['team_id'];
				UpdateTeamToRound($begin_ronde, $team['team_id']);	
				$teller =1;
				InsertIntoMatch($begin_ronde, $team_1, $team_2, $match_position);
				$match_position++;
			}
		}	
	}	
}
if($aantal == 4){
	// 2 matches
	// 0 byes
	$begin_ronde = 2;
	$match_position = 1;
	$teller = 1;
	
	foreach($teams as $team){
		if($teller ==1){
				$team_1 = $team['team_id'];
				UpdateTeamToRound($begin_ronde, $team['team_id']);	
				$teller++;
			}else{
				$team_2 = $team['team_id'];
				UpdateTeamToRound($begin_ronde, $team['team_id']);	
				$teller =1;
				InsertIntoMatch($begin_ronde, $team_1, $team_2, $match_position);
				$match_position++;
			}		
	}
	InsertIntoMatch(1,0,0,1);
}
if($aantal == 5){
	// 1 match
	// 3 byes
	UpdateTeamToRound(3,$teams[0]['team_id']);
	UpdateTeamToRound(3,$teams[1]['team_id']);
	InsertIntoMatch(3,$teams[0]['team_id'],$teams[1]['team_id'],1);

	UpdateTeamToRound(2,$teams[2]['team_id']);
	InsertIntoMatch(2,$teams[2]['team_id'],0,1);

	UpdateTeamToRound(2,$teams[3]['team_id']);
	UpdateTeamToRound(2,$teams[4]['team_id']);
	InsertIntoMatch(2,$teams[3]['team_id'],$teams[4]['team_id'],2);
	InsertIntoMatch(1,0,0,1);
}
if($aantal == 6){
	UpdateTeamToRound(2,$teams[0]['team_id']);
	InsertIntoMatch(2,$teams[0]['team_id'],0,1);
	UpdateTeamToRound(2,$teams[1]['team_id']);
	InsertIntoMatch(2,$teams[1]['team_id'],0,2);
	UpdateTeamToRound(3,$teams[2]['team_id']);
	UpdateTeamToRound(3,$teams[3]['team_id']);
	InsertIntoMatch(3,$teams[2]['team_id'],$teams[3]['team_id'],1);
	UpdateTeamToRound(3,$teams[4]['team_id']);
	UpdateTeamToRound(3,$teams[5]['team_id']);
	InsertIntoMatch(3,$teams[4]['team_id'],$teams[5]['team_id'],2);
	InsertIntoMatch(1,0,0,1);
}
if($aantal == 7){
	UpdateTeamToRound(2,$teams[0]['team_id']);
	InsertIntoMatch(2,$teams[0]['team_id'],0,1);
	InsertIntoMatch(2,0,0,2);
	InsertIntoMatch(1,0,0,1);
	UpdateTeamToRound(3,$teams[1]['team_id']);
	UpdateTeamToRound(3,$teams[2]['team_id']);
	InsertIntoMatch(3,$teams[1]['team_id'],$teams[2]['team_id'],1);
	UpdateTeamToRound(3,$teams[3]['team_id']);
	UpdateTeamToRound(3,$teams[4]['team_id']);
	InsertIntoMatch(3,$teams[3]['team_id'],$teams[4]['team_id'],2);
	UpdateTeamToRound(3,$teams[5]['team_id']);
	UpdateTeamToRound(3,$teams[6]['team_id']);
	InsertIntoMatch(3,$teams[5]['team_id'],$teams[6]['team_id'],3);

}
if($aantal == 8){
	InsertIntoMatch(2,0,0,1);
	InsertIntoMatch(2,0,0,2);
	InsertIntoMatch(1,0,0,1);

	UpdateTeamToRound(3,$teams[0]['team_id']);
	UpdateTeamToRound(3,$teams[1]['team_id']);
	InsertIntoMatch(3,$teams[0]['team_id'],$teams[1]['team_id'],1);

	UpdateTeamToRound(3,$teams[2]['team_id']);
	UpdateTeamToRound(3,$teams[3]['team_id']);
	InsertIntoMatch(3,$teams[2]['team_id'],$teams[3]['team_id'],2);

	UpdateTeamToRound(3,$teams[4]['team_id']);
	UpdateTeamToRound(3,$teams[5]['team_id']);
	InsertIntoMatch(3,$teams[4]['team_id'],$teams[5]['team_id'],3);

	UpdateTeamToRound(3,$teams[6]['team_id']);
	UpdateTeamToRound(3,$teams[7]['team_id']);
	InsertIntoMatch(3,$teams[6]['team_id'],$teams[7]['team_id'],4);
}
if($aantal == 9){
	UpdateTeamToRound(4,$teams[0]['team_id']);
	UpdateTeamToRound(4,$teams[1]['team_id']);
	InsertIntoMatch(4,$teams[0]['team_id'],$teams[1]['team_id'],1);
	UpdateTeamToRound(3,$teams[2]['team_id']);
	UpdateTeamToRound(3,$teams[3]['team_id']);
	InsertIntoMatch(3,$teams[2]['team_id'],$teams[3]['team_id'],1);

	UpdateTeamToRound(3,$teams[4]['team_id']);
	UpdateTeamToRound(3,$teams[5]['team_id']);
	InsertIntoMatch(3,$teams[4]['team_id'],$teams[5]['team_id'],2);
	UpdateTeamToRound(3,$teams[6]['team_id']);
	UpdateTeamToRound(3,$teams[7]['team_id']);
	InsertIntoMatch(3,$teams[6]['team_id'],$teams[7]['team_id'],3);
	UpdateTeamToRound(3,$teams[8]['team_id']);
	InsertIntoMatch(3,$teams[8]['team_id'],0,4);
	InsertIntoMatch(2,0,0,1);
	InsertIntoMatch(2,0,0,2);
	InsertIntoMatch(1,0,0,1);
}
if($aantal == 10){
	UpdateTeamToRound(4,$teams[0]['team_id']);
	UpdateTeamToRound(4,$teams[1]['team_id']);
	InsertIntoMatch(4,$teams[0]['team_id'],$teams[1]['team_id'],1);
	UpdateTeamToRound(4,$teams[2]['team_id']);
	UpdateTeamToRound(4,$teams[3]['team_id']);
	InsertIntoMatch(4,$teams[2]['team_id'],$teams[3]['team_id'],2);

	UpdateTeamToRound(3,$teams[4]['team_id']);
	InsertIntoMatch(3,$teams[4]['team_id'],0,1);
	UpdateTeamToRound(3,$teams[5]['team_id']);
	InsertIntoMatch(3,$teams[5]['team_id'],0,2);

	UpdateTeamToRound(3,$teams[6]['team_id']);
	UpdateTeamToRound(3,$teams[7]['team_id']);
	InsertIntoMatch(3,$teams[6]['team_id'],$teams[7]['team_id'],3);

	UpdateTeamToRound(3,$teams[8]['team_id']);
	UpdateTeamToRound(3,$teams[9]['team_id']);
	InsertIntoMatch(3,$teams[8]['team_id'],$teams[9]['team_id'],4);

	InsertIntoMatch(2,0,0,1);
	InsertIntoMatch(2,0,0,2);
	InsertIntoMatch(1,0,0,1);
}
if($aantal == 11){
	UpdateTeamToRound(4,$teams[0]['team_id']);
	UpdateTeamToRound(4,$teams[1]['team_id']);
	InsertIntoMatch(4,$teams[0]['team_id'],$teams[1]['team_id'],1);

	UpdateTeamToRound(4,$teams[2]['team_id']);
	UpdateTeamToRound(4,$teams[3]['team_id']);
	InsertIntoMatch(4,$teams[2]['team_id'],$teams[3]['team_id'],2);

	UpdateTeamToRound(4,$teams[4]['team_id']);
	UpdateTeamToRound(4,$teams[5]['team_id']);
	InsertIntoMatch(4,$teams[4]['team_id'],$teams[5]['team_id'],3);

	UpdateTeamToRound(3,$teams[6]['team_id']);
	InsertIntoMatch(3,$teams[6]['team_id'],0,1);

	UpdateTeamToRound(3,$teams[7]['team_id']);
	InsertIntoMatch(3,$teams[7]['team_id'],0,2);

	UpdateTeamToRound(3,$teams[8]['team_id']);
	InsertIntoMatch(3,$teams[8]['team_id'],0,3);

	UpdateTeamToRound(3,$teams[9]['team_id']);
	UpdateTeamToRound(3,$teams[10]['team_id']);
	InsertIntoMatch(3,$teams[9]['team_id'],$teams[10]['team_id'],4);

	InsertIntoMatch(2,0,0,1);
	InsertIntoMatch(2,0,0,2);
	InsertIntoMatch(1,0,0,1);
}
if($aantal == 12){
	UpdateTeamToRound(4,$teams[0]['team_id']);
	UpdateTeamToRound(4,$teams[1]['team_id']);
	InsertIntoMatch(4,$teams[0]['team_id'],$teams[1]['team_id'],1);

	UpdateTeamToRound(4,$teams[2]['team_id']);
	UpdateTeamToRound(4,$teams[3]['team_id']);
	InsertIntoMatch(4,$teams[2]['team_id'],$teams[3]['team_id'],2);

	UpdateTeamToRound(4,$teams[4]['team_id']);
	UpdateTeamToRound(4,$teams[5]['team_id']);
	InsertIntoMatch(4,$teams[4]['team_id'],$teams[5]['team_id'],3);

	UpdateTeamToRound(4,$teams[6]['team_id']);
	UpdateTeamToRound(4,$teams[7]['team_id']);
	InsertIntoMatch(4,$teams[6]['team_id'],$teams[7]['team_id'],4);

	UpdateTeamToRound(3,$teams[8]['team_id']);
	InsertIntoMatch(3,$teams[8]['team_id'],0,1);

	UpdateTeamToRound(3,$teams[9]['team_id']);
	InsertIntoMatch(3,$teams[9]['team_id'],0,2);

	UpdateTeamToRound(3,$teams[10]['team_id']);
	InsertIntoMatch(3,$teams[10]['team_id'],0,3);

	UpdateTeamToRound(3,$teams[11]['team_id']);
	InsertIntoMatch(3,$teams[11]['team_id'],0,4);

	InsertIntoMatch(2,0,0,1);
	InsertIntoMatch(2,0,0,2);
	InsertIntoMatch(1,0,0,1);
}
if($aantal == 13){
	UpdateTeamToRound(4,$teams[0]['team_id']);
	UpdateTeamToRound(4,$teams[1]['team_id']);
	InsertIntoMatch(4,$teams[0]['team_id'],$teams[1]['team_id'],1);

	UpdateTeamToRound(4,$teams[2]['team_id']);
	UpdateTeamToRound(4,$teams[3]['team_id']);
	InsertIntoMatch(4,$teams[2]['team_id'],$teams[3]['team_id'],2);

	UpdateTeamToRound(4,$teams[4]['team_id']);
	UpdateTeamToRound(4,$teams[5]['team_id']);
	InsertIntoMatch(4,$teams[4]['team_id'],$teams[5]['team_id'],3);

	UpdateTeamToRound(4,$teams[6]['team_id']);
	UpdateTeamToRound(4,$teams[7]['team_id']);
	InsertIntoMatch(4,$teams[6]['team_id'],$teams[7]['team_id'],4);

	UpdateTeamToRound(4,$teams[8]['team_id']);
	UpdateTeamToRound(4,$teams[9]['team_id']);
	InsertIntoMatch(4,$teams[8]['team_id'],$teams[9]['team_id'],5);

	UpdateTeamToRound(3,$teams[10]['team_id']);
	InsertIntoMatch(3,$teams[10]['team_id'],0,1);

	UpdateTeamToRound(3,$teams[11]['team_id']);
	InsertIntoMatch(3,$teams[11]['team_id'],0,2);

	UpdateTeamToRound(3,$teams[12]['team_id']);
	InsertIntoMatch(3,$teams[12]['team_id'],0,3);

	InsertIntoMatch(3,0,0,4);
	InsertIntoMatch(2,0,0,1);
	InsertIntoMatch(2,0,0,2);
	InsertIntoMatch(1,0,0,1);
}
if($aantal == 14){
	UpdateTeamToRound(4,$teams[0]['team_id']);
	UpdateTeamToRound(4,$teams[1]['team_id']);
	InsertIntoMatch(4,$teams[0]['team_id'],$teams[1]['team_id'],1);

	UpdateTeamToRound(4,$teams[2]['team_id']);
	UpdateTeamToRound(4,$teams[3]['team_id']);
	InsertIntoMatch(4,$teams[2]['team_id'],$teams[3]['team_id'],2);

	UpdateTeamToRound(4,$teams[4]['team_id']);
	UpdateTeamToRound(4,$teams[5]['team_id']);
	InsertIntoMatch(4,$teams[4]['team_id'],$teams[5]['team_id'],3);

	UpdateTeamToRound(4,$teams[6]['team_id']);
	UpdateTeamToRound(4,$teams[7]['team_id']);
	InsertIntoMatch(4,$teams[6]['team_id'],$teams[7]['team_id'],4);

	UpdateTeamToRound(4,$teams[8]['team_id']);
	UpdateTeamToRound(4,$teams[9]['team_id']);
	InsertIntoMatch(4,$teams[8]['team_id'],$teams[9]['team_id'],5);

	UpdateTeamToRound(4,$teams[10]['team_id']);
	UpdateTeamToRound(4,$teams[11]['team_id']);
	InsertIntoMatch(4,$teams[10]['team_id'],$teams[11]['team_id'],6);

	UpdateTeamToRound(3,$teams[12]['team_id']);
	InsertIntoMatch(3,$teams[12]['team_id'],0,1);

	UpdateTeamToRound(3,$teams[13]['team_id']);
	InsertIntoMatch(3,$teams[13]['team_id'],0,2);

	InsertIntoMatch(3,0,0,3);
	InsertIntoMatch(3,0,0,4);
	InsertIntoMatch(2,0,0,1);
	InsertIntoMatch(2,0,0,2);
	InsertIntoMatch(1,0,0,1);
}
if($aantal == 15){
	UpdateTeamToRound(4,$teams[0]['team_id']);
	UpdateTeamToRound(4,$teams[1]['team_id']);
	InsertIntoMatch(4,$teams[0]['team_id'],$teams[1]['team_id'],1);

	UpdateTeamToRound(4,$teams[2]['team_id']);
	UpdateTeamToRound(4,$teams[3]['team_id']);
	InsertIntoMatch(4,$teams[2]['team_id'],$teams[3]['team_id'],2);

	UpdateTeamToRound(4,$teams[4]['team_id']);
	UpdateTeamToRound(4,$teams[5]['team_id']);
	InsertIntoMatch(4,$teams[4]['team_id'],$teams[5]['team_id'],3);

	UpdateTeamToRound(4,$teams[6]['team_id']);
	UpdateTeamToRound(4,$teams[7]['team_id']);
	InsertIntoMatch(4,$teams[6]['team_id'],$teams[7]['team_id'],4);

	UpdateTeamToRound(4,$teams[8]['team_id']);
	UpdateTeamToRound(4,$teams[9]['team_id']);
	InsertIntoMatch(4,$teams[8]['team_id'],$teams[9]['team_id'],5);

	UpdateTeamToRound(4,$teams[10]['team_id']);
	UpdateTeamToRound(4,$teams[11]['team_id']);
	InsertIntoMatch(4,$teams[10]['team_id'],$teams[11]['team_id'],6);

	UpdateTeamToRound(4,$teams[12]['team_id']);
	UpdateTeamToRound(4,$teams[13]['team_id']);
	InsertIntoMatch(4,$teams[12]['team_id'],$teams[13]['team_id'],7);

	UpdateTeamToRound(3,$teams[14]['team_id']);
	InsertIntoMatch(3,$teams[14]['team_id'],0,1);

	InsertIntoMatch(3,0,0,2);
	InsertIntoMatch(3,0,0,3);
	InsertIntoMatch(3,0,0,4);
	InsertIntoMatch(2,0,0,1);
	InsertIntoMatch(2,0,0,2);
	InsertIntoMatch(1,0,0,1);
}
if($aantal == 16){
	UpdateTeamToRound(4,$teams[0]['team_id']);
	UpdateTeamToRound(4,$teams[1]['team_id']);
	InsertIntoMatch(4,$teams[0]['team_id'],$teams[1]['team_id'],1);

	UpdateTeamToRound(4,$teams[2]['team_id']);
	UpdateTeamToRound(4,$teams[3]['team_id']);
	InsertIntoMatch(4,$teams[2]['team_id'],$teams[3]['team_id'],2);

	UpdateTeamToRound(4,$teams[4]['team_id']);
	UpdateTeamToRound(4,$teams[5]['team_id']);
	InsertIntoMatch(4,$teams[4]['team_id'],$teams[5]['team_id'],3);

	UpdateTeamToRound(4,$teams[6]['team_id']);
	UpdateTeamToRound(4,$teams[7]['team_id']);
	InsertIntoMatch(4,$teams[6]['team_id'],$teams[7]['team_id'],4);

	UpdateTeamToRound(4,$teams[8]['team_id']);
	UpdateTeamToRound(4,$teams[9]['team_id']);
	InsertIntoMatch(4,$teams[8]['team_id'],$teams[9]['team_id'],5);

	UpdateTeamToRound(4,$teams[10]['team_id']);
	UpdateTeamToRound(4,$teams[11]['team_id']);
	InsertIntoMatch(4,$teams[10]['team_id'],$teams[11]['team_id'],6);

	UpdateTeamToRound(4,$teams[12]['team_id']);
	UpdateTeamToRound(4,$teams[13]['team_id']);
	InsertIntoMatch(4,$teams[12]['team_id'],$teams[13]['team_id'],7);

	UpdateTeamToRound(4,$teams[14]['team_id']);
	UpdateTeamToRound(4,$teams[15]['team_id']);
	InsertIntoMatch(4,$teams[14]['team_id'],$teams[15]['team_id'],8);

	InsertIntoMatch(3,0,0,1);
	InsertIntoMatch(3,0,0,2);
	InsertIntoMatch(3,0,0,3);
	InsertIntoMatch(3,0,0,4);
	InsertIntoMatch(2,0,0,1);
	InsertIntoMatch(2,0,0,2);
	InsertIntoMatch(1,0,0,1);
}
if($aantal > 16 && $aantal < 33){
	$amount_links = 0;
	$amount_rechts = 0;
	$amount_rechts = 32 - $aantal;
	$amount_links = $aantal - $amount_rechts;
	//echo $amount_rechts. " ".$amount_links;
	$team_1 = 0;
	$team_2 = 0;
	$match_counter = 1;
	// links
	$teller = 1;
	for($i=0;$i<$amount_links;$i++){
		if($teller == 1){
			$team_1 = $teams[$i]['team_id'];
			UpdateTeamToRound(5,$teams[$i]['team_id']);
			$teller++;
			continue;
		}
		if($teller == 2){
			$team_2 = $teams[$i]['team_id'];
			UpdateTeamToRound(5,$teams[$i]['team_id']);
			InsertIntoMatch(5,$team_1,$team_2,$match_counter);
			$match_counter++;
			$teller = 1;
		}
	}
	echo $amount_rechts;
	$oneven_done  = 0;
	if( $amount_rechts % 2 == 0){
		$oneven_done = 1;
	}
	echo $oneven_done;
    $match_counter = 1;
	for($i = $amount_links;$i<$aantal;$i++){
	if($oneven_done == 0){
		InsertIntoMatch(4,$teams[$i]['team_id'],0,$match_counter);
		$match_counter++;
		$oneven_done = 1;
	}else{
		if($teller == 1){
			$team_1 = $teams[$i]['team_id'];
			UpdateTeamToRound(4,$teams[$i]['team_id']);
			$teller++;
			continue;
		}
		if($teller == 2){
			$team_2 = $teams[$i]['team_id'];
			UpdateTeamToRound(4,$teams[$i]['team_id']);
			InsertIntoMatch(4,$team_1,$team_2,$match_counter);
			$match_counter++;
			$teller = 1;
		}
	}
	}
	if($match_counter < 9){
		for($i = $match_counter;$i<9;$i++){
			InsertIntoMatch(4,0,0,$i);
		}
	}
	InsertIntoMatch(3,0,0,1);
	InsertIntoMatch(3,0,0,2);
	InsertIntoMatch(3,0,0,3);
	InsertIntoMatch(3,0,0,4);
	InsertIntoMatch(2,0,0,1);
	InsertIntoMatch(2,0,0,2);
	InsertIntoMatch(1,0,0,1);
}
if($aantal > 32 &&  $aantal < 65){
	$amount_links = 0;
	$amount_rechts = 0;
	$amount_rechts = 64 - $aantal;
	$amount_links = $aantal - $amount_rechts;
	$team_1 = 0;
	$team_2 = 0;
	$match_counter = 1;
	// links
	$teller = 1;
	for($i=0;$i<$amount_links;$i++){
		if($teller == 1){
			$team_1 = $teams[$i]['team_id'];
			UpdateTeamToRound(6,$teams[$i]['team_id']);
			$teller++;
			continue;
		}
		if($teller == 2){
			$team_2 = $teams[$i]['team_id'];
			UpdateTeamToRound(6,$teams[$i]['team_id']);
			InsertIntoMatch(6,$team_1,$team_2,$match_counter);
			$match_counter++;
			$teller = 1;
		}
	}
	echo $amount_rechts;
	$oneven_done  = 0;
	if( $amount_rechts % 2 == 0){
		$oneven_done = 1;
	}
	echo $oneven_done;
	$match_counter = 1;
	for($i = $amount_links;$i<$aantal;$i++){
		if($oneven_done == 0){
			InsertIntoMatch(5,$teams[$i]['team_id'],0,$match_counter);
			$match_counter++;
			$oneven_done = 1;
		}else{
			if($teller == 1){
				$team_1 = $teams[$i]['team_id'];
				UpdateTeamToRound(5,$teams[$i]['team_id']);
				$teller++;
				continue;
			}
			if($teller == 2){
				$team_2 = $teams[$i]['team_id'];
				UpdateTeamToRound(5,$teams[$i]['team_id']);
				InsertIntoMatch(5,$team_1,$team_2,$match_counter);
				$match_counter++;
				$teller = 1;
			}
		}
	}
	if($match_counter < 17){
		for($i = $match_counter;$i<17;$i++){
			InsertIntoMatch(5,0,0,$i);
		}
	}
	for($i=1;$i<9;$i++){
		InsertIntoMatch(4,0,0,$i);
	}
	InsertIntoMatch(3,0,0,1);
	InsertIntoMatch(3,0,0,2);
	InsertIntoMatch(3,0,0,3);
	InsertIntoMatch(3,0,0,4);
	InsertIntoMatch(2,0,0,1);
	InsertIntoMatch(2,0,0,2);
	InsertIntoMatch(1,0,0,1);
}
if($aantal > 64 &&  $aantal < 129){
	$amount_links = 0;
	$amount_rechts = 0;
	$amount_rechts = 128 - $aantal;
	$amount_links = $aantal - $amount_rechts;
	$team_1 = 0;
	$team_2 = 0;
	$match_counter = 1;
	// links
	$teller = 1;
	for($i=0;$i<$amount_links;$i++){
		if($teller == 1){
			$team_1 = $teams[$i]['team_id'];
			UpdateTeamToRound(7,$teams[$i]['team_id']);
			$teller++;
			continue;
		}
		if($teller == 2){
			$team_2 = $teams[$i]['team_id'];
			UpdateTeamToRound(7,$teams[$i]['team_id']);
			InsertIntoMatch(7,$team_1,$team_2,$match_counter);
			$match_counter++;
			$teller = 1;
		}
	}
	echo $amount_rechts;
	$oneven_done  = 0;
	if( $amount_rechts % 2 == 0){
		$oneven_done = 1;
	}
	echo $oneven_done;
	$match_counter = 1;
	for($i = $amount_links;$i<$aantal;$i++){
		if($oneven_done == 0){
			InsertIntoMatch(6,$teams[$i]['team_id'],0,$match_counter);
			$match_counter++;
			$oneven_done = 1;
		}else{
			if($teller == 1){
				$team_1 = $teams[$i]['team_id'];
				UpdateTeamToRound(6,$teams[$i]['team_id']);
				$teller++;
				continue;
			}
			if($teller == 2){
				$team_2 = $teams[$i]['team_id'];
				UpdateTeamToRound(6,$teams[$i]['team_id']);
				InsertIntoMatch(6,$team_1,$team_2,$match_counter);
				$match_counter++;
				$teller = 1;
			}
		}
	}
	if($match_counter < 33){
		for($i = $match_counter;$i<33;$i++){
			InsertIntoMatch(6,0,0,$i);
		}
	}
	if($match_counter < 17){
		for($i = $match_counter;$i<17;$i++){
			InsertIntoMatch(5,0,0,$i);
		}
	}
	for($i=1;$i<9;$i++){
		InsertIntoMatch(4,0,0,$i);
	}
	InsertIntoMatch(3,0,0,1);
	InsertIntoMatch(3,0,0,2);
	InsertIntoMatch(3,0,0,3);
	InsertIntoMatch(3,0,0,4);
	InsertIntoMatch(2,0,0,1);
	InsertIntoMatch(2,0,0,2);
	InsertIntoMatch(1,0,0,1);
}
function UpdateTeamToRound($round,$team){
		$league_id = $_POST['lid'];
		$conn= sql_domain();
		$stmt = $conn->prepare('update leagues_single_ele_teams set current_round = :r where team_id = :t and league_id = :l');
		$stmt->bindParam(':r',$round);
		$stmt->bindParam(':l',$league_id);
		$stmt->bindParam(':t',$team);
		$stmt->execute();
}
function InsertIntoMatch($round,$team_1,$team_2,$position){
			$league_id = $_POST['lid'];
			$conn= sql_domain();
			$stmt = $conn->prepare('insert into matches_single_ele(league_id,round_id,team_1,team_2,position)VALUES
			(:l,:r,:t1,:t2,:p)');		
			$stmt->bindParam(':r',$round);
			$stmt->bindParam(':l',$league_id);
			$stmt->bindParam(':t1',$team_1);
			$stmt->bindParam(':t2',$team_2);	
			$stmt->bindParam(':p',$position);			
			$stmt->execute();		
		
}
?>