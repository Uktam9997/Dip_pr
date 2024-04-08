<?php

session_start();

if(!$_GET['id']) {
    $_SESSION['error'] = 'Повторите попитку';
    header("Location: /../page_users.php");
    exit;

}

if(!$_POST) {
    $_SESSION['error'] = 'Повторите попитку';
    header("Location:/ /../page_users.php");
    exit;
}

$id = $_GET['id'];
$status = $_POST['status'];


try{
    $pdo = new PDO("mysql:host=localhost;dbname=dip_pr;", "root", "");

    $sql = "UPDATE security_media SET status = :status WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['status' => $status, 'id' => $id]);

    $_SESSION['messenger'] = 'Статус обнавлен :)';
    header("Location: /../page_users.php");
    exit;

}
catch(PDOException $e) {
    $_SESSION['error'] = 'Статус обнавит не удалос :( <br> Повторите попитку';
    header("Location: /../page_users.php");
    exit;
}







