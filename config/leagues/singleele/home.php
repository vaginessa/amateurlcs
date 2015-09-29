<?php
include $_SERVER['DOCUMENT_ROOT'].'/functions.php';
$league_id = $_POST['lid'];

$conn = sql_domain();
$stmt = $conn->prepare('select * from leagues_config where id = :i');
$stmt->bindParam(':i',$league_id);
$stmt->execute();
$league = $stmt->fetchAll();
$league = $league[0];
?>
<div class="modal-dialog" style="width:1600px">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">
        	<?php echo $league['name'];?> - <?php echo GlobalGetLeagueType($league['type']);?></h4>
      </div>
      <div class="modal-body">
          <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                  <li data-name="configuration" class="active tab_links"><a href="#tab_1" data-toggle="tab">Main configuration</a></li>
                  <li data-name="brackets" class="tab_links"><a href="#tab_2" data-toggle="tab">Brackets</a></li>
                  <li data-name="results" class="tab_links"><a href="#tab_2" data-toggle="tab">Match results</a></li>
              </ul>
              <div class="tab-content" id="tab_content">
              </div><!-- /.tab-content -->
          </div><!-- nav-tabs-custom -->
          </form>
      </div>
    </div>
  </div>
  <script>
      function ReloadConfiguration(lid){
          $.ajax({
              url  :'./config/leagues/singleele/configuration.php',
              type :'POST',
              data : { lid : lid},
              success : function(res){
                  $("#tab_content").html(res);
                  $("#list_of_teams").DataTable();

              }
          })
      }

      ReloadConfiguration(<?php echo $league_id;?>);
  	$(".tab_links").on('click',function(){
        if($(this).data('name')== 'configuration'){
            ReloadConfiguration(<?php echo $league_id;?>);
        }else
  		$.ajax({
  			url :'./config/leagues/singleele/'+ $(this).data('name')+'.php',
  			type :'POST',
  			data : { lid : "<?php echo $league_id;?>"},
  			success : function(res){
  				$("#tab_content").html(res);
  			}
  		})
  	})
  </script>