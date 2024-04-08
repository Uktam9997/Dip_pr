<?php 

session_start();

if(!isset($_GET['id'])) {
    $_SESSION['error'] = 'Повторите попитку';
    header("Location: /../page_users.php");
    exit;
}

$user_id = $_GET['id'];




try{
    $pdo = new PDO("mysql:host=localhost;dbname=dip_pr;", "root", "");
    $sql = "SELECT email, password FROM security_media WHERE user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $user_id]);
    // $error = $stmt->errorInfo();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $_SESSION['user'] = $user;
    header("Location: /../page_security.php");
}catch(PDOException $e){
    $_SESSION['error'] = 'Повторите попитку.';
    header("Location: /../page_users.php");
}