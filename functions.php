<?php
session_start();

//Get the subdomain from the url
$urlParts = explode('.', $_SERVER['HTTP_HOST']);
$subdomain = $urlParts[0];
//Get database connection globals
$central = mysqli_connect('localhost','root','','amateurlcs_central') or die ('Something is wrong');
$central_result = mysqli_fetch_array(mysqli_query($central,'select d.id,d.domain,database_user,database_password,database_db,package
 from domains as d join domains_packages as p on d.id = p.domain where d.domain = "'.$subdomain .'"'));
$GLOBALS['domain'] = $subdomain;
$GLOBALS['db_user'] = $central_result['database_user'];
$GLOBALS['db_password'] = $central_result['database_password'];
$GLOBALS['db_db'] = $central_result['database_db'];
$GLOBALS['package'] = $central_result['package'];

//Domain sql function
function sql_domain()
{
	$db = $GLOBALS['db_db'];
	return new PDO("mysql:host=localhost;dbname=$db",$GLOBALS['db_user'],$GLOBALS['db_password']);	
}
//Central sql function
function sql_central(){
	return new PDO("mysql:host=localhost;dbname=amateurlcs_central",'root','');
}
// normal sql function for datatables ajax, unsure how to migrate to PDO param style
function sql($query){
	$connection = mysqli_connect("localhost",$GLOBALS['db_user'],$GLOBALS['db_password'],$GLOBALS['db_db'])  or die("Er zijn een probleem met de verbinding tussen de pagina en de database. Probeer later opnieuw");		
	return mysqli_query($connection,$query);	
}

/*	Functions list
 * 	1. Global database related
 * 		1.1 GlobalGetRank
 * 		1.2 GlobalGetAccountType
 * 		1.3 GlobalGetRegion
 * 		1.4 GlobalGetChampionName
 * 		1.5 GlobalTypeSelection
 * 		1.6 GlobalRankSelection
 * 		1.7 GlobalRoleSelection
 * 		1.8 GlobalGetRole
 * 		1.9 GetDayOfTheWeek
 * 		1.10 GlobalLeagueTypeSelection
 * 		1.11 GetDaySelection
 * 		1.12 GlobalGetLeagueType
 * 		1.13 GlobalGetSingleEleRounds
 * 		
 * 		
 * 	2. Management related
 * 		2.1 GetPlatformInfo
 * 		2.2 SetPlatformInfo
 * 		2.3 Management option UI builder
 * 		2.4 Region select
 * 		2.5 ManagementUIBuilderAllowDeny
 * 
 * 	3. User related
 * 		3.1 CreateNewUser 
 * 		3.2 UserGetInfoByColumn
 * 		3.3 CreateOpgg
 * 		3.4 GetUserBanner
 * 		3.5 UserGetStatistics
 * 		3.6 UserStatisticsInsertChampions
 * 		3.7 GetUserSelection
 *
 * 	4. Team related
 * 		4.1 InsertUserRole
 * 		4.2 GetTeamOfUser
 * 		4.3 GetTeamBanner
 * 		4.4 TeamGetInfoByColumn
 * 		4.5 GetCurrentRosterForTeam
 * 		4.6 GetCurrentRoleOfUser 		
 * 		4.7 GetCurrentTeamSelection
 * 		4.8 GetUserForRosterRole
 * 		
 *	5. League related
 * 		5.1 LeagueGetInfoByColumn
 * 		5.2 RoundRobinInfoByColumn
 * 
 *  		
*/

// 1. Global database related
//	1.1 GlobalGetRank
function GlobalGetRank($column_a,$column_b,$value){
	$conn = sql_central();
	$stmt = $conn->prepare('SELECT '.$column_a .' from global_lolranks where '. $column_b .' = :value');
	$stmt->bindParam(':value',$value);
     $stmt->execute();
	$result = $stmt->fetchAll();
	if($result){
		return $result[0][$column_a];	
	}else {
		return 'Unranked';
	}
	
	
}
//	1.2 GlobalGetAccountType
function GlobalGetAccountType($type_id){
	$conn = sql_central();
	$stmt = $conn->prepare('SELECT value from global_account_types where id = :type_id');
	$stmt->bindParam(':type_id',$type_id);
     $stmt->execute();
	$result = $stmt->fetchAll();	
	return $result[0]['value'];	
}
//	1.3 GlobalGetRegion
function GlobalGetRegion($region_id){
	$conn = sql_central();
	$stmt = $conn->prepare('SELECT short from global_regions where id = :region_id');
	$stmt->bindParam(':region_id',$region_id);
     $stmt->execute();
	$result = $stmt->fetchAll();	
	return $result[0]['short'];	
}
//	1.4 GlobalGetChampionName
function GlobalGetChampionName($champion_id){
	$conn = sql_central();
	$stmt = $conn->prepare('SELECT name from global_champions where champion_id = :c_id');
	$stmt->bindParam(':c_id',$champion_id);
     $stmt->execute();
	$result = $stmt->fetchAll();	
	return $result[0]['name'];	
}
// 	1.5 GlobalTypeSelection
function GlobalTypeSelection($element_id,$selected = null){
	echo '<select class="form-control" id="'. $element_id .'">'; 
	echo '<option></option>';
	$conn = sql_central();
	$stmt ="";
	if($GLOBALS['package'] == 1){
		$stmt = $conn->prepare('SELECT * from global_account_types where id < 5');
	}
	$stmt->execute();
	$result = $stmt->fetchAll();	
	foreach($result as $r){
		if($selected == $r['id']){
			echo "<option value='". $r['id']."' selected>" .$r['value']."</option>";
		}else{
			echo "<option value='". $r['id']."'>" .$r['value']."</option>";
		}		
	}
	echo '</select>';	
}
//		1.6 GlobalRankSelection
function GlobalRankSelection($element_id,$selected = null){
	echo '<select class="form-control" id="'. $element_id .'">'; 
	echo '<option></option>';
	$conn = sql_central();
	$stmt = $conn->prepare('SELECT * from global_lolranks');
	$stmt->execute();
	$result = $stmt->fetchAll();	
	foreach($result as $r){
		if($selected == $r['id']){
			echo "<option value='". $r['id']."' selected>" .$r['value']."</option>";
		}else{
			echo "<option value='". $r['id']."'>" .$r['value']."</option>";
		}		
	}
	echo '</select>';	
}
//		1.7 GlobalRoleSelection
function GlobalRoleSelection($element_id,$selected = null)
{
	echo '<select class="form-control" id="'. $element_id .'">'; 
	echo '<option></option>';
	$conn = sql_central();
	$stmt = $conn->prepare('SELECT * from global_teamroles');
	$stmt->execute();
	$result = $stmt->fetchAll();	
	foreach($result as $r){
		if($selected == $r['id']){
			echo "<option value='". $r['id']."' selected>" .$r['value']."</option>";
		}else{
			echo "<option value='". $r['id']."'>" .$r['value']."</option>";
		}		
	}
	echo '</select>';	
}
//		1.8 GlobalGetRole
function GlobalGetRole($role_id){
	$conn = sql_central();
	$stmt = $conn->prepare('SELECT value from global_teamroles where id = :rid');
	$stmt->bindParam(':rid',$role_id);
     $stmt->execute();
	$result = $stmt->fetchAll();	
	if($result){
		return $result[0]['value'];	
	}else {
		return "";
	}
	
}
// 		1.9 GetDayOfTheWeek
function GetDayOfTheWeek($day_id){
	switch($day_id){
		case 1:
			return 'Monday';
			break;
		case 2:
			return 'Tuesday';
			break;
		case 3:
			return 'Wednesday';
			break;
		case 4:
			return 'Thursday';
			break;
		case 5:
			return 'Friday';
			break;
		case 6:
			return 'Saturday';
			break;
		case 7:
			return 'Sunday';
			break;
	}
}
// 		1.10 GlobalLeagueTypeSelection
function GlobalLeagueTypeSelection($element_id,$selected){
	//Basic package
	//Round robin only
	$allowed = [];
	if($GLOBALS['package'] == 1){
		$allowed = array(3);
	}
	echo '<select class="form-control" id="'. $element_id .'">'; 
	echo '<option></option>';
	$conn = sql_central();
	$stmt = $conn->prepare('SELECT * from global_tournament_types');
	$stmt->execute(); 
	$result = $stmt->fetchAll();
	foreach($result as $r){
		if(in_array($r['id'],$allowed)){
		if($selected == $r['id']){
			echo "<option value='". $r['id']."' selected>" .$r['name']."</option>";
		}else{
			echo "<option value='". $r['id']."'>" .$r['name']."</option>";
		}
	}
	}
	echo '</select>';				
}
// 		1.11 GetDaySelection
function GetDaySelection($element_id,$selected){
	echo "<select class='form-control' id='".$element_id."'>";
	echo "<option></option>";
	echo "<option>Monday</option>";
	echo "<option>Tuesday</option>";
	echo "<option>Wednesday</option>";
	echo "<option>Thursday</option>";
	echo "<option>Friday</option>";
	echo "<option>Saturday</option>";
	echo "<option>Sunday</option>";

	echo "</select>";
}
//		1.12 GlobalGetLeagueType
function GlobalGetLeagueType($id){
	$conn = sql_central();
	$stmt = $conn->prepare('SELECT name from global_tournament_types where id = :rid');
	$stmt->bindParam(':rid',$id);
     $stmt->execute();
	$result = $stmt->fetchAll();	
	if($result){
		return $result[0]['name'];	
	}else {
		return "";
	}
}
// 		1.13 GlobalGetSingleEleRounds
function GlobalGetSingleEleRounds($round){
	$conn = sql_central();
	$stmt = $conn->prepare('SELECT name from global_single_ele_rounds where id = :rid');
	$stmt->bindParam(':rid',$round);
     $stmt->execute();
	$result = $stmt->fetchAll();	
	if($result){
		return $result[0]['name'];	
	}else {
		return "";
	}
}



// 2. Management related
// 	2.1 GetPlatformInfo
function GetPlatformInfo($field){
	$conn = sql_domain();
	$stmt = $conn->prepare('SELECT value from management where field = :field');
	$stmt->bindParam(':field',$field);
     $stmt->execute();
	$result = $stmt->fetchAll();
	return $result[0]['value'];	
}
//	 2.2 SetPlatformInfo
function SetPlatformInfo($field,$value){
	$conn = sql_domain();
	$stmt = $conn->prepare('UPDATE management set value = :value where field = :field');
	$stmt->bindParam(':value',$value);
	$stmt->bindParam(':field',$field);
    $stmt->execute();
}
// 	2.3 Management option UI builder
function ManagementUIBuilderEnableDisable($text,$field){
	echo "<div class='form-group'>";
	echo "<label class='control-label col-md-5'>".$text."</label>";
	echo "<div class='col-md-7'>";
	echo "<select id='". $field."' class='form-control fields'>";
	echo "<option value='0' ";
	if(GetPlatformInfo($field) == 0){
		echo "selected";
	}
	echo ">Disabled</option>";
	echo "<option value='1' ";
	if(GetPlatformInfo($field) == 1){
		echo "selected";
	}
	echo ">Enabled</option>";
	echo "</select>";	
	echo "</div>";
	echo "</div>";
}

// 	2.4 Region select
function Regionselect($text,$field){
	echo "<div class='form-group'>";
	echo "<label class='control-label col-md-5'>".$text."</label>";
	echo "<div class='col-md-7'>";
	echo "<select id='". $field."' class='form-control fields'>";
	echo "<option></option>";
	$selected = GetPlatformInfo('region_select');
	$conn = sql_central();
	$stmt = $conn->prepare('SELECT * from global_regions');
	$stmt->execute();
	$result = $stmt->fetchAll();
	foreach($result as $r){
		if($r['id'] == $selected){
			echo "<option value='".$r['id']."' selected>".$r['region']."</option>";
		}else {
			echo "<option value='".$r['id']."'>".$r['region']."</option>";
		}	
	}	
	echo "</select>";	
	echo "</div>";
	echo "</div>";
}
// 	2.5 ManagementUIBuilderAllowDeny
function ManagementUIBuilderAllowDeny($text,$field){
	echo "<div class='form-group'>";
	echo "<label class='control-label col-md-5'>".$text."</label>";
	echo "<div class='col-md-7'>";
	echo "<select id='". $field."' class='form-control fields'>";
	echo "<option value='0' ";
	if(GetPlatformInfo($field) == 0){
		echo "selected";
	}
	echo ">Deny</option>";
	echo "<option value='1' ";
	if(GetPlatformInfo($field) == 1){
		echo "selected";
	}
	echo ">Allow</option>";
	echo "</select>";	
	echo "</div>";
	echo "</div>";
}

// 3. User related
// 		3.1 CreateNewUser
function CreateNewUser($username,$email){
	$conn = sql_domain();
	$randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 20);
	$password_ = password_hash($randomString,PASSWORD_DEFAULT);	
	$stmt = $conn->prepare('INSERT INTO users (username,email,password)VALUES(:username,:email,:password)');
	$stmt->bindParam(':username',$username);
	$stmt->bindParam(':email',$email);
	$stmt->bindParam(':password',$password_);
	$stmt->execute();	
	$user_id = $conn->lastInsertId();
	if($user_id != 0){
	$stmt = $conn->prepare('INSERT INTO users_statistics(user_id)VALUES(:user_id)');
	$stmt->bindParam(':user_id',$user_id);
	$stmt->execute();
	}	
	// Still need to send the email though	
}
// 		3.2 UserGetInfoByColumn
function UserGetInfoByColumn($column_a,$column_b,$value){
	$conn = sql_domain();
	$stmt = $conn->prepare('SELECT '.$column_a.' from users where '.$column_b .' = :value');
	$stmt->bindParam(':value',$value);
	$stmt->execute();
	$result = $stmt->fetchAll();
	if($result){
		return $result[0][$column_a];
	}else {
		return "";
			}
	
}
// 		3.3 CreateOpgg
function CreateOpgg($username){	
	$username = explode(' ',$username);
	$u_string = "http://".GlobalGetRegion(GetPlatformInfo('region_select')). ".op.gg/summoner/userName=";
	foreach($username as $u){
		$u_string.= $u.'+';
	}
	return $u_string;
}
//		3.4 GetUserBanner
function GetUserBanner($user_id){
	if (file_exists($_SERVER['DOCUMENT_ROOT'] . 'assets/users/'.$GLOBALS['subdomain'].'/' . $user_id . '.png'))
	{
		return '../../assets/users/'.$GLOBALS['subdomain'].'/'.$user_id.'.png';
	}else if(file_exists($_SERVER['DOCUMENT_ROOT'] . 'assets/subdomain_logos/'.$GLOBALS['subdomain'].'.png'))  {
		return "../../assets/subdomain_logos/". $GLOBALS['subdomain'].".png";
	}else {
		return "../../assets/default.png";
	}
}
// 		3.5 UserGetStatistics
function UserGetStatistics($user_id){
	$conn = sql_domain();
	$stmt = $conn->prepare('SELECT * from users_statistics where user_id = :user_id');
	$stmt->bindParam(':user_id',$user_id);
	$stmt->execute();
	return $stmt->fetchAll();
}
// 		3.6 UserStatisticsInsertChampions
function UserStatisticsInsertChampions($user_id,$champion_id,$total_games,$wins){
	$conn = sql_domain();
	$stmt = $conn->prepare('INSERT INTO users_champions(user_id,champion_id,games_played,games_won)VALUES(:user_id,:champion_id,:played,:won)');
	$stmt->bindParam(':user_id',$user_id);
	$stmt->bindParam(':champion_id',$champion_id);
	$stmt->bindParam(':played',$total_games);
	$stmt->bindParam(':won',$wins);
	$stmt->execute();
}
// 		3.7 GetUserSelection
function GetUserSelection($element_id,$selected,$class){
	echo '<select class="form-control '. $class .'" id="'. $element_id .'">'; 
	echo "<option></option>";
	$conn = sql_domain();
	$stmt = $conn->prepare('select id,username from users');
	$stmt->execute();
	$result = $stmt->fetchAll();
	foreach($result as $r){
		if($r['id'] == $selected){
			echo "<option value='". $r['id']."' selected>".$r['username']."</option>";
		}else {
			echo "<option value='". $r['id']."'>".$r['username']."</option>";
		}
	}
	echo '</select>';
}

// 4. Team related
//		4.1 InsertUserRole
function InsertUserRole($team_id,$user_id,$role_id){
	$conn = sql_domain();
	$stmt = $conn->prepare('INSERT INTO teams_roles(team_id,user_id,role_id)VALUES(:tid,:uid,:rid)');
	$stmt->bindParam(':tid',$team_id);
	$stmt->bindParam(':uid',$user_id);
	$stmt->bindParam(':rid',$role_id);
	$stmt->execute();		
} 
//		4.2 GetTeamOfUser
function GetTeamOfUser($user_id){
	$conn = sql_domain();
	$stmt = $conn->prepare('select team_id from teams_roles where user_id = :uid');
	$stmt->bindParam(':uid',$user_id);
	$stmt->execute();
	$result = $stmt->fetchAll();
	if($result){
	return $result[0]['team_id'];	
	}else{
		return '';
	}
}
// 		4.3 GetTeamBanner
function GetTeamBanner($team_id){
	
	if (file_exists($_SERVER['DOCUMENT_ROOT'] . 'assets/teams/'.$GLOBALS['subdomain'].'/' . $team_id . '.png'))
	{
		return '../../assets/teams/'.$GLOBALS['subdomain'].'/'.$team_id.'.png';
	}else if(file_exists($_SERVER['DOCUMENT_ROOT'] . 'assets/subdomain_logos/'.$GLOBALS['subdomain'].'.png'))  {
		return "../../assets/subdomain_logos/". $GLOBALS['subdomain'].".png";
	}else {
		return "../../assets/default.png";
	}
}
// 		4.4 TeamGetInfoByColumn
function TeamGetInfoByColumn($column_a,$column_b,$value){
	$conn = sql_domain();
	$stmt = $conn->prepare('SELECT '.$column_a.' from teams where '.$column_b .' = :value');
	$stmt->bindParam(':value',$value);
	$stmt->execute();
	$result = $stmt->fetchAll();
	if($result){
	return $result[0][$column_a];
	}else {
		return '';
	}
}
//		4.5 GetCurrentRosterForTeam
function GetCurrentRosterForTeam($team_id){
	echo "<table class='table table-hover table-light'>";
	echo '<thead>';
	echo '<tr class="uppercase">';
	echo '<th colspan="2">';
	echo "Member";
	echo '<th>Role</th>';
	echo '<th>Rank</th>';
	echo '</tr>';
	echo '</thead>';
	$conn = sql_domain();
	$stmt = $conn->prepare('select * from teams_roles where team_id = :tid');
	$stmt->bindParam(':tid',$team_id);
	$stmt->execute();
	$members = $stmt->fetchAll();
	foreach($members as $member){
		echo "<tr data-toggle='context' data-target='#context-menu'>";
		echo "<td class='fit'>";
		echo "<img class='user-pic' src='".GetUserBanner($member['user_id']) ."'>";
		echo "</td>";
	     echo "<td>";
	     echo "<a target='_blank' href='index?module=user_profile&id=". $member['user_id']."' class='primary-link'>".UserGetInfoByColumn('username','id',$member['user_id'])."</a>";
	     echo "</td>";
	     echo "<td>";
	     echo GlobalGetRole(GetCurrentRoleOfUser($member['user_id']));
	     echo "</td>";
		echo "<td>";
		$rank = UserGetStatistics($member['user_id']);
		echo GlobalGetRank('value','id',$rank[0]['rank_solo']);
          echo "</td>";
		echo "</tr>";			
		echo '<div id="context-menu">
				<ul class="dropdown-menu" role="menu">
					<li>
						<a href="javascript:;">
							<i class="fa fa-refresh"></i> Update rank 
						</a>
					</li>					
				</ul>
			</div>';		
	}
	echo '</table>';	
	echo '<script src="../../assets/global/plugins/bootstrap-contextmenu/bootstrap-contextmenu.js"></script>';
	
}
//		4.6 GetCurrentRoleOfUser
function GetCurrentRoleOfUser($user_id){
	$conn = sql_domain();
	$stmt = $conn->prepare('select role_id from teams_roles where user_id = :uid');
	$stmt->bindParam(':uid',$user_id);
	$stmt->execute();
	$result = $stmt->fetchAll();	
	if($result){
	return $result[0]['role_id'];
	}
	else{
		return '';
	}
	
}
// 		4.7 GetCurrentTeamSelection
function GetCurrentTeamSelection($element_id,$current_team = null){
	$conn = sql_domain();
	$stmt = $conn->prepare('select * from teams order by name');
	$stmt->execute();
	$teams = $stmt->fetchAll();
	echo '<select class="form-control" id="'. $element_id .'">'; 
	echo '<option></option>';
	foreach($teams as $team){
		if($current_team == $team['id']){
			echo "<option value='". $team['id']  ."' selected>". $team['name'] ."</option>";
		}else {
			echo "<option value='". $team['id']  ."'>". $team['name'] ."</option>";
		}	
	}	
	echo '</select>';
}
// 		4.8 GetUserForRosterRole
function GetUserForRosterRole($role_id,$team_id){
	$conn = sql_domain();
	$stmt = $conn->prepare('select user_id from teams_roles where team_id = :t and role_id = :r');
	$stmt->bindParam(':t',$team_id);
	$stmt->bindParam(':r',$role_id);
	$stmt->execute();
	$result = $stmt->fetchAll();
	if($result){
	return $result[0]['user_id'];
	}else { return '';}
}
// 5. League related
// 		5.1 LeagueGetInfoByColumn
function LeagueGetInfoByColumn($column_a,$column_b,$value)
{
	$conn = sql_domain();
	$stmt = $conn->prepare('SELECT ' . $column_a . ' from leagues_config where ' . $column_b . ' = :value');
	$stmt->bindParam(':value', $value);
	$stmt->execute();
	$result = $stmt->fetchAll();
	if ($result) {
		return $result[0][$column_a];
	} else {
		return "";
	}
}
//		5.2 RoundRobinInfoByColumn
function RoundRobinInfoByColumn($column_a,$column_b,$value){
	$conn = sql_domain();
	$stmt = $conn->prepare('SELECT ' . $column_a . ' from leagues_config_round_robin where ' . $column_b . ' = :value');
	$stmt->bindParam(':value', $value);
	$stmt->execute();
	$result = $stmt->fetchAll();
	if ($result) {
		return $result[0][$column_a];
	} else {
		return "";
	}
}


?>