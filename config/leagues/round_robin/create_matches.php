<?php
include $_SERVER['DOCUMENT_ROOT'].'/functions.php';
$league_id = $_POST['lid'];
// get teams
$conn = sql_domain();
$stmt = $conn->prepare('select team_id from leagues_round_robin_teams where league_id = :lid');
$stmt->bindParam(':lid',$league_id);
$stmt->execute();
$result = $stmt->fetchAll();
$teams = array();
foreach($result as $r){
    array_push($teams,$r['team_id']);
}

function InsertMatch($week,$team1,$team2){
    $league_id = $_POST['lid'];
    $conn = sql_domain();
    $stmt = $conn->prepare('insert into matches_round_robin(league_id,week_id,team_1,team_2)VALUES(:l,:w,:t1,:t2)');
    $stmt->bindParam(':l',$league_id);
    $stmt->bindParam(':w',$week);
    $stmt->bindParam(':t1',$team1);
    $stmt->bindParam(':t2',$team2);
    $stmt->execute();

}
$schedule = roundRobin($teams);
// Week = 1
$week = 1;
foreach($schedule as $sch){
   foreach($sch as $s){
       InsertMatch($week,$s['Home'],$s['Away']);
   }
    $week++;

}




function roundRobin( array $teams ){

    if (count($teams)%2 != 0){
        array_push($teams,"bye");
    }

    $away = array_splice($teams,(count($teams)/2));
    $home = $teams;
    for ($i=0; $i < count($home)+count($away)-1; $i++)
    {
        for ($j=0; $j<count($home); $j++)
        {
            $round[$i][$j]["Home"]=$home[$j];
            $round[$i][$j]["Away"]=$away[$j];
        }
        if(count($home)+count($away)-1 > 2)
        {
            $s = array_splice( $home, 1, 1 );
            $slice = array_shift( $s  );
            array_unshift($away,$slice );
            array_push( $home, array_pop($away ) );
        }
    }
  return $round;
}


?>