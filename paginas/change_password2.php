<?php
include $_SERVER['DOCUMENT_ROOT'].'/functions.php';
$pass = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
$hash = password_hash($pass,PASSWORD_DEFAULT);
$conn = sql_domain();
$stmt = $conn->prepare('update users set password = :h where id = :uid');
$stmt->bindParam(':h',$hash);
$stmt->bindParam(':uid',$_SESSION['user_id']);
$stmt->execute();
?>