<?php
include $_SERVER['DOCUMENT_ROOT'] . 'functions.php';
$conn = sql_domain();
$stmt = $conn->prepare('delete from leagues_single_ele where id = :i');
$stmt->bindParam(':i',$_POST['id']);
$stmt->execute();
?>