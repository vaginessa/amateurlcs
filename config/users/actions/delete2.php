<?php
include $_SERVER['DOCUMENT_ROOT'] . '/functions.php';
$user_id = $_POST['user_id'];

// delete from users table
$conn = sql_domain();
$stmt = $conn->prepare('delete from users where id = :u');
$stmt->bindParam(':u',$user_id);
$stmt->execute();
?>