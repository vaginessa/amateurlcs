<?php
include $_SERVER['DOCUMENT_ROOT'].'/functions.php';

$conn = sql_domain();
$stmt = $conn->prepare('select current_round from leagues_config_single_ele where league_id = :lid');
$stmt->bindParam(':lid',$_POST['lid']);
$stmt->execute();
$result = $stmt->fetchAll();
$result = $result[0];


?>
<div class="row">
    <?php


    $conn = sql_domain();
    $stmt = $conn->prepare('select current_round from leagues_single_ele_teams where league_id = :lid group by current_round order by current_round desc limit 1');
    $stmt->bindParam(':lid',$_POST['lid']);
    $stmt->execute();
    $result = $stmt->fetchAll();

    $starting_round = $result[0]['current_round'];
    echo "<div class='col-md-12' style='max-height:820px;overflow-y:scroll;'>";
    while($starting_round > 0){
        // Count matches
        echo "<div style='width:16%;float:left;'><div class='align_center' style='100%;'><b>";
        echo GlobalGetSingleEleRounds($starting_round);
        echo "</b></div>";
        $stmt = $conn->prepare('select id,team_1,team_2,position from matches_single_ele where league_id = :lid and round_id = :r order by team_1 asc');
        $stmt->bindParam(':lid',$_POST['lid']);
        $stmt->bindParam(':r',$starting_round);
        $stmt->execute();
        $matches = $stmt->fetchAll();
        $first_padding = "";
        $padding_between = "";
        foreach($matches as $match){
            if($starting_round == 4){
                if($match['position'] == 1){
                    $first_padding = 'margin-top:20px;';
                }
            }
            if($starting_round == 3){
                if($match['position'] == 1){
                    $first_padding = 'margin-top:80px;';
                }
            }
            if($starting_round == 2){
                if($match['position'] == 1){
                    $first_padding = 'margin-top:160px;';
                }
            }
            if($starting_round == 1){
                if($match['position'] == 1){
                    $first_padding = 'margin-top:280px;';
                }
            }


            echo "<div style='100%;'>";
            echo "<div data-match='".$match['id'] ."' data-team='". $match['team_1']."' style='". $first_padding."' class='matches col-md-7 click_to_win'>";
            if($match['team_1'] != 0){
                echo $match['team_1'];
            }
            echo "</div>";
            echo "<div class='col-md-5 border_top align_center'>";
            echo "</div>";
            echo "<div data-match='".$match['id'] ."' data-team='". $match['team_2']."' class='matches align_center matches_second col-md-7 click_to_win'>";
            if($match['team_2'] != 0){
                echo $match['team_2'];
            }
            echo "</div>";
            echo "<div class='col-md-5 border_top align_center'>";
            echo "</div>";
            echo "</div>";
        }
        echo "</div>";
        $starting_round = $starting_round - 1 ;

    }
    echo "</div>";
    ?>

</div>
<script>
    $('.click_to_win').on('click',function(){
        $.ajax({
            url :'./config/leagues/singleele/result_match.php',
            type :'POST',
            data : {
            match_id : $(this).data('match'),
            team_id : $(this).data('team'),
            league_id : "<?php echo $_POST['lid'];?>"},
            success : function(res){
                $("#modal2").html(res);
                $("#modal2").modal('show');
            }
        })

    })


</script>


<style type="text/css">
    .click_to_win:hover {
        background-color: #2dee1b;
    }

    .border_top {
    }
    .align_center {
        text-align:center;
    }
    .matches {
        text-align:center;
        border: 1px solid #000;
        height: 20px;
    }
    .matches_second{
        margin-bottom:10px;
    }
</style>




