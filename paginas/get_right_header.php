<?php
include $_SERVER['DOCUMENT_ROOT'].'/functions.php';
error_reporting(0);
// Get msg count
$user_id = $_SESSION['user_id'];
$conn = sql_domain();
$stmt = $conn->prepare('select count(*) as aantal from messages where receiver = :uid and message_read = "0000-00-00 00:00:00"');
$stmt->bindParam(':uid',$user_id);
$stmt->execute();
$result = $stmt->fetchAll();
if($result[0]){
    $message_count = $result[0]['aantal'];
}else{
    $message_count = 0;
}
//Set logged in timestamp
$stmt = $conn->prepare('update users set last_login = :date where id = :uid');
$stmt->bindParam(':uid',$user_id);
$stmt->bindParam(':date',date('Y-m-d H:i:s'));
$stmt->execute();

if(GetPlatformInfo('enable_login') == 0){
    session_destroy();
}
$stmt = $conn->prepare('select last_login from users');
$stmt->execute();
$logged_in = $stmt->fetchAll();
$count_active = 0;
foreach($logged_in as $logged_in_){
    $last_active = strtotime($logged_in_['last_login']);
    $time_for_active = strtotime(date('Y-m-d H:i:s')) - 180;
    if($last_active > $time_for_active){
        $counter++;
    }
}
?>
<ul class="nav navbar-nav">
    </li>
    <!-- Tasks: style can be found in dropdown.less -->
    <li class="dropdown tasks-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-flag-o"></i>
            <span class="label label-danger"><?php echo $counter;?></span>
        </a>
        <ul class="dropdown-menu">
            <li class="header">There are currently <?php echo $counter;?> players online.</li>
        </ul>
    </li>
    <!-- Messages: style can be found in dropdown.less-->
    <li class="dropdown messages-menu">
        <!-- Menu toggle button -->
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-envelope-o"></i>
            <span class="label label-success"><?php echo $message_count;?></span>
        </a>
        <ul class="dropdown-menu">
            <li class="header">
                <?php
                if($message_count == 0){
                    echo "You have no messages";
                }else if($message_count == 1){
                    echo "You have 1 message";
                }else{
                    echo 'You have '.$message_count.' messages';
                }
                ?>
            </li>
            <li>
                <!-- inner menu: contains the messages -->
                <ul class="menu">
                    <li><!-- start message -->
                        <a href="#">
                            <div class="pull-left">
                                <!-- User Image -->
                                <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                            </div>
                            <!-- Message title and timestamp -->
                            <h4>
                                Support Team
                                <small><i class="fa fa-clock-o"></i> 5 mins</small>
                            </h4>
                            <!-- The message -->
                            <p>Why not buy a new awesome theme?</p>
                        </a>
                    </li><!-- end message -->
                </ul><!-- /.menu -->
            </li>
            <li class="footer"><a href="index?module=inbox">See All Messages</a></li>
        </ul>
    </li><!-- /.messages-menu -->
    <!-- User Account Menu -->
    <li class="dropdown user user-menu">
        <!-- Menu Toggle Button -->
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <!-- The user image in the navbar-->
            <img src="<?php echo GetUserBanner($_SESSION['user_id']);?>" class="user-image" alt="User Image">
            <!-- hidden-xs hides the username on small devices so only the image appears. -->
            <span class="hidden-xs"><?php echo $_SESSION['username'];?></span>
        </a>
        <ul class="dropdown-menu">
            <!-- The user image in the menu -->
            <li class="user-header">
                <img src="<?php echo GetUserBanner($_SESSION['user_id']);?>" class="img-circle" alt="User Image">
                <p>
                    <?php echo $_SESSION['username'];?>
                </p>
            </li>
            <!-- Menu Body -->
            <li class="user-body">
                <div class="col-xs-4 text-center">
                    <a id='change_password' href="#">Password</a>
                </div>
                <div class="col-xs-4 text-center">
                    <a href="index?module=inbox">Inbox</a>
                </div>
                <div class="col-xs-4 text-center">
                    <a href="index?module=users&id=<?php echo $_SESSION['user_id'];?>">Profile</a>
                </div>
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
                <div class="pull-left">
                    <a href="#" class="btn btn-default btn-flat">Teamprofile</a>
                </div>
                <div class="pull-right">
                    <a href="login" class="btn btn-default btn-flat">Sign out</a>
                </div>
            </li>
        </ul>
    </li>
</ul>
<script>
    $("#change_password").on('click',function(){
        $.ajax({
            url :'./paginas/change_password.php',
            success : function(res){
                $("#modal").html(res);
                $("#modal").modal('show');
            }
        })


    })



</script>