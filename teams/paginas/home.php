<?php

if($_GET['id'] == "") {

    $conn = sql_domain();
    $stmt = $conn->prepare('select * from teams');
    $stmt->execute();
    $result = $stmt->fetchAll();
    foreach ($result as $r) {
        echo "<div class='col-md-2'>";
        echo '<div style="text-align:center;" class="title"><h3>';
        echo $r['name'];
        echo "</h3></div>";
        echo '<div class="img">';
        echo '<a href="index?module=teams&id=' . $r['id'] . '"><img class="img-responsive" style="border-radius:150px;" src="' . GetTeamBanner($r['id']) . '"/></a>';
        echo "</div>";
        echo "</div>";
    }
}
if($_GET['id'] != ""){
    $team_id = $_GET['id'];
    $team_id = TeamGetInfoByColumn('id','id',$team_id);
    if(!($team_id)){
        echo "Invalid team.";
        return;
    }
    // Query static shizzle so we can lower the amount of querys ( name, captainname and stuff)
    $team_name = TeamGetInfoByColumn('name','id',$team_id);
    $team_tag = TeamGetInfoByColumn('tag','id',$team_id);
    // Check if the user is a captain
    $captain_id = TeamGetInfoByColumn('captain_id','id',$team_id);

    $c_captain = false;
    if($captain_id == $_SESSION['user_id']){
        $c_captain = true;
    }
    // Check if the user is a member
    $c_member = false;
    if(GetTeamOfUser($_SESSION['user_id']) == $team_id){
        $c_member = true;
    }
?>
<div class="row">
    <div class="col-md-2">
        <div class="box box-primary">
            <div class="box-body box-profile">
                <img class="profile-user-img img-responsive img-circle" style="width:180px;" src="<?php echo GetTeamBanner($team_id);?>" alt="User profile picture">
                <h3 class="profile-username text-center"><?php echo $team_name;?></h3>
                <div style='width:100%' class="btn-group-vertical">
                    <button id='btn_roster_changes' class="btn btn-flat btn-primary">Roster changes</button>
                </div>
                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        <b>Teamcaptain</b> <a href="index?module=user_profile&id=<?php echo $captain_id;?>" class="pull-right"><?php echo UserGetInfoByColumn('username','id',$captain_id);?></a>
                    </li>
                    <li class="list-group-item">
                        <b>Kicks left</b> <a class="pull-right"><?php echo TeamGetInfoByColumn('kicks_left','id',$team_id);?></a>
                    </li>
                    <li class="list-group-item">
                        <b>Message captain</b> <a href="index?module=inbox&id=<?php echo $captain_id;?>" class="pull-right"><i class="fa fa-envelope"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs pull-right">
                   <li class="pull-left header"><i class="fa fa-bars"></i>
                    <b><?php echo $team_name." - ". $team_tag;?></b>
                    </li>
                    </ul>

              <div class="tab-content">
                    <table class="table table-light">
                        <thead>
                        <tr>
                            <th>MEMBER</th>
                            <th>ROLE</th>
                            <th>RANK</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $conn = sql_domain();
                        $stmt = $conn->prepare('select t.user_id,role_id,rank_solo from teams_roles as t left join users_statistics as u on t.user_id = u.user_id where t.team_id = :t');
                        $stmt->bindParam(':t',$team_id);
                        $stmt->execute();
                        $teams = $stmt->fetchAll();
                        foreach($teams as $t){
                            echo "<tr>";
                            echo "<td>";

                            echo UserGetInfoByColumn('username','id',$t['user_id'])."</td>";
                            echo "<td>". GlobalGetRole($t['role_id'])."</td>";
                            echo "<td>". GlobalGetRank('value','id',$t['rank_solo'])."</td>";
                            echo "<td><button class='btn btn-primary btn-sm'><i class='fa fa-refresh'></i></button>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            dsfds
        </div>
    </div>
    <div class="col-md-6">
        <div class="col-md-12">
           <div class="nav-tabs-custom">
               <ul class="nav nav-tabs pull-right">
                   <li class="pull-left header"><i class="fa fa-list"></i>

                       <?php
                       $stmt = $conn->prepare('select * from leagues_config order by id');
                       $active_league_id = 0;
                       $active_league_type = 0;
                       $stmt->execute();
                       $leagues = $stmt->fetchAll();
                       foreach($leagues as $l) {
                           if ($l['type'] == 3) {
                           }
                           $stmt = $conn->prepare('select league_id from leagues_round_robin_teams where team_id = :t and league_id = :l');
                           $stmt->bindParam(':t', $team_id);
                           $stmt->bindParam(':l', $l['id']);
                           $stmt->execute();
                           $result = $stmt->fetchAll();
                           if ($result[0]) {
                               $active_league_type = 3;
                               $active_league_id = $result[0]['league_id'];
                           }
                       }
                       if($active_league_id != 0){
                           echo 'Current team standing - '.LeagueGetInfoByColumn('name','id',$active_league_id);
                       }       else{
                           echo "Not enrolled in a league";
                       }
                       ?>

                   </li>
               </ul>
                <div class="tab-content">
                    <?php
                    if($active_league_type == 3){
                        $stmt = $conn->prepare('select * from leagues_round_robin_teams where league_id = :l');
                        $stmt->bindParam(':l',$active_league_id);
                        $stmt->execute();
                        $teams = $stmt->fetchAll();
                        echo "<table class='table table-condensed table-striped table-hover'>";
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>Team</th>";
                        echo "<th>Points</th>";
                        echo "<th>Games won</th>";
                        echo "<th>Games lost</th>";
                        echo "<th>Games played</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        foreach($teams as $t){
                            echo "<tr>";
                            if($t['team_id'] == $team_id){
                                echo "<tr class='info'>";
                            }else {
                                echo "<tr>";
                            }
                            echo "<td>" . TeamGetInfoByColumn('name', 'id', $t['team_id']) . "</td>";
                            echo "<td>" . $t['points'] ."</td>";
                            echo "<td>" . $t['games_won'] ."</td>";
                            echo "<td>" . $t['games_lost'] ."</td>";
                            echo "<td>" . $t['games_played'] ."</td>";
                            echo "</tr>";
                        }
                        echo "</tbody></table>";
                    }
                    ?>
                </div>
            </div>
            </div>
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs pull-right">
                    <li class="active"><a href="#tab_1-1" data-toggle="tab">Upcoming</a></li>
                    <li><a href="#tab_2-2" data-toggle="tab">Past</a></li>
                    <li class="pull-left header"><i class="fa fa-calendar"></i> Matches</li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1-1">
                        <?php
                        if($active_league_type == 3){
                            $stmt = $conn->prepare('select current_week from leagues_config_round_robin where league_id = :lid');
                            $stmt->bindParam(':lid',$active_league_id);
                            $stmt->execute();
                            $current_week = $stmt->fetchAll();
                            $stmt = $conn->prepare('select * from matches_round_robin where league_id = :lid and week_id >= :w and team_1 = :t or  league_id = :lid and week_id >= :w and team_2 = :t');
                            $stmt->bindParam(':w',$current_week[0]['current_week']);
                            $stmt->bindParam(':lid',$active_league_id);
                            $stmt->bindParam(':t',$team_id);
                            $stmt->execute();
                            $matches = $stmt->fetchAll();
                            echo "<table class='table table-striped table-hover'>";
                            echo "<thead>";
                            echo "<tr>";
                            echo "<th>Week</th>";
                            echo "<th>Team 1</th>";
                            echo "<th>Team 2</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            foreach($matches as $m){
                                echo "<tr>";
                                echo "<td>Week ". $m['week_id'] ."</td>";
                                echo "<td>". TeamGetInfoByColumn('name','id',$m['team_1']) ."</td>";
                                echo "<td>". TeamGetInfoByColumn('name','id',$m['team_2'])  ."</td>";
                            }
                            echo "</tbody></table>";
                        }
                        ?>
                    </div><!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_2-2">
                    </div><!-- /.tab-pane -->
                </div><!-- /.tab-content -->
            </div><!-- nav-tabs-custom -->
        </div>
    </div>
</div>
<?php
}
?>
<script>
    $("#btn_roster_changes").on('click',function(){

    })



</script>



