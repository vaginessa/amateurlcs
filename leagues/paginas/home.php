<div class="col-md-12">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs pull-right">
            <?php
            $conn = sql_domain();
            $stmt = $conn->prepare('select * from leagues_config');
            $stmt->execute();
            $leagues = $stmt->fetchAll();
            $teller =1;
            $first = 0;
            foreach($leagues as $l){
                if($teller == 1){
                    echo '<li data-id="'. $l['id'].'" class="league_tabs active"><a href="#" data-toggler="tab">'.$l['name'] .'</a>';
                    $first = $l['id'];
                    $teller++;
                }else {
                    echo '<li  data-id="'. $l['id'].'"  class="league_tabs"><a href="#" data-toggler="tab">'.$l['name'] .'</a>';
                }
            }
            ?>
            <li class="pull-left header"><i class="fa fa-th"></i>Leagues</li>
        </ul>
        <div id="tab_content" class="tab-content">
        </div>
    </div>
</div>
<script>

   //First
   $.ajax({
       url :'./leagues/paginas/home_sub.php',
       data : {
           league_id : "<?php echo $first;?>"
       },
       type :'POST',
       success : function(res){
           $("#tab_content").html(res);
       }
   })


   $(".league_tabs").on('click',function(){
    $('.league_tabs').each(function(){
        $(this).removeClass('active');
    })
    $(this).addClass('active');
    $.ajax({
        url :'./leagues/paginas/home_sub.php',
        data : {
            league_id : $(this).data('id')
        },
        type :'POST',
        success : function(res){
            $("#tab_content").html(res);
        }
    })



})



</script>

