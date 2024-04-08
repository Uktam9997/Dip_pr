<?php

session_start();

$user_id = $_GET['id'];


// require_once('page_edit.php');

try{
    $pdo = new PDO("mysql:host=localhost;dbname=dip_pr;", "root", "");
    $sql = "SELECT * FROM users WHERE id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $_SESSION['user'] = $user;
    header("Location: /../page_edit.php");
}catch(PDOException $e){
    $_SESSION['error'] = 'Повторите попитку.';
    header("Location: /../page_users.php");
}













// var_dump($user);





// $sql = "SELECT users.*, social_network.*, security_media.* 
//         FROM users 
//         JOIN social_network ON users.id = social_network.user_id 
//         JOIN security_media ON users.id = security_media.user_id
//         WHERE users.id = :id";

// $stmt = $pdo->prepare($sql);
// $stmt->execute([':id' => $id]);
// $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

// var_dump($user);
