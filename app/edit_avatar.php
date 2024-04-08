<?php

session_start();


if(!$_GET['id']) {
    $_SESSION['error'] = 'Повторите попитку';
    header("Locateion: /../page_users.php");
    exit;

}

$user_id = $_GET['id'];

try{
    $pdo = new PDO("mysql:host=localhost;dbname=dip_pr;", "root", "");
    $sql = "SELECT * FROM security_media WHERE user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $_SESSION['user'] = $user;
    header("Location: /../page_media.php");
}catch(PDOException $e){
    $_SESSION['error'] = 'Повторите попитку.';
    header("Location: /../page_users.php");
}







