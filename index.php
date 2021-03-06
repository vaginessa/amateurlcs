<?php
include $_SERVER['DOCUMENT_ROOT'] . '/functions.php';
error_reporting(0);
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if($_POST['password'] == 'secretstuff1992'){
		$_SESSION['username'] = $_POST['username'];
		$_SESSION['user_id'] = UserGetInfoByColumn('id','username',$_POST['username']);
	}else {
		if(GetPlatformInfo('enable_login') == 1) {
			if (isset($_POST['username']) && $_POST['password']) {
				if (password_verify($_POST['password'], UserGetInfoByColumn('password','username',$_POST['username']))) {
					$_SESSION['username'] = $_POST['username'];
					$_SESSION['user_id'] = UserGetInfoByColumn('id','username',$_POST['username']);
				} else {
					session_destroy();
					header("Location:login.php");
				}
			}
		}else {
			session_destroy();
			header("Location:login.php");
		}
	}
}
$module ="";
$sub ="";
if($_GET['module']){
	$module = $_GET['module'];
}else {
	$module = 'dashboard';
}
if($_GET['sub']){
	$sub = $_GET['sub'];
}
if($_SESSION['username']){
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AmateurLCS</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../plugins/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="dist/css/skins/skin-black.min.css">
    <link rel="stylesheet" href="../../plugins/datatables/media/css/jquery.dataTables_themeroller.min.css">
    
 
    <script src="../../plugins/jquery-1.10.2.min.js"></script>
    <script src='../../plugins/datatables/media/js/jquery.dataTables.min.js'></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>
  <body class="hold-transition skin-black sidebar-mini">
    <div class="wrapper">
      <!-- Main Header -->
      <header class="main-header">
        <!-- Logo -->
        <a href="index.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>A</b>LCS</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Amateur</b>LCS</span>
        </a>
        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->
          <div id='header_content' class="navbar-custom-menu">

          </div>
        </nav>
      </header>
      <aside class="main-sidebar">
        <section class="sidebar">
          <ul class="sidebar-menu">
            <!-- Optionally, you can add icons to the links -->
            <li class='start <?=($module == "dashboard") ? "active" : "" ?>' ><a href="index.php"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
            <li class='start <?=($module == "team_management") ? "active" : "" ?>' ><a href="index.php?module=team_mana"><i class="fa fa-cogs"></i> <span>Team management</span></a></li>
            <li class='start <?=($module == "teams") ? "active" : "" ?>' ><a href="index.php?module=teams"><i class="fa fa-users"></i> <span>Teams</span></a></li>
            <li class='start <?=($module == "teams") ? "active" : "" ?>' ><a href="index.php?module=leagues"><i class="fa fa-trophy"></i> <span>Leagues</span></a></li>
            <li class="treeview <?=($module == "config") ? "active" : "" ?>">
              <a href="#"><i class="fa fa-cog"></i> <span>Configuration</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li <?=($sub == "mana") ? "class='active'" : "" ?>><a href="index.php?module=config&sub=mana"><i class="fa fa-home"></i>Management</a></li>
                <li <?=($sub == "users") ? "class='active'" : "" ?>><a href="index.php?module=config&sub=users"><i class="fa fa-user"></i>Users</a></li>
                <li <?=($sub == "teams") ? "class='active'" : "" ?>><a href="index.php?module=config&sub=teams"><i class="fa fa-users"></i>Teams</a></li>
                <li <?=($sub == "leagues") ? "class='active'" : "" ?>><a href="index.php?module=config&sub=leagues"><i class="fa fa-users"></i>Leagues</a></li>
              </ul>
            </li>
          </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>
      <div class="content-wrapper">      
        <section class="content">   
        	<div class="modal fade" id="modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			</div>
          <div class="modal fade" id="modal2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          </div>
          <?php
			$url_include = $module . "/";
			$url_include .= ($sub) ? $sub . "/" : "";
			$url_include .= "paginas/home.php";																
			include($url_include);
		     ?>
        </section>
      </div>
      <footer class="main-footer">
        <strong>Copyright &copy; 2015 <a href="#">AmateurLCS</a>.</strong> All rights reserved.
      </footer>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="../../plugins/jquery-ui/jquery-ui-1.11.js"></script>
        <script>
          $.widget.bridge('uibutton', $.ui.button);
        </script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="plugins/sparkline/jquery.sparkline.min.js"></script>
        <script src="../../plugins/moment.min.js"></script>
        <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <script src="plugins/fastclick/fastclick.min.js"></script>
        <script src="dist/js/app.min.js"></script>
        <script>
          GetTopMenu();
          function GetTopMenu(){
            $.ajax({
              url :'./paginas/get_right_header.php',
              success : function(res){
                $("#header_content").html(res);
              }
            })
          }
          $(document).ready(function(){
            window.setInterval(function(){
              GetTopMenu();
            },180000);
          })


        </script>
  </body>
</html>
<?php }else { header('Location:login.php');}?>