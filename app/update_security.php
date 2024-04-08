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
$email = $_POST['email'];
$password = $_POST['password'];
$confirmconfirm_password = $_POST['confirm_password'];

if($password !== $confirmconfirm_password) {
    $_SESSION['error'] = 'Паролы не совпадает :| <br> Повторите попитку';
    header("Location:/ /../page_users.php");
    exit;
}

try{
    $pdo = new PDO("mysql:host=localhost;dbname=dip_pr;", "root", "");

    $sql = "UPDATE security_media SET email = :email, password = :password WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email, 'password' => password_hash($password, PASSWORD_DEFAULT), 'id' => $id]);

    $_SESSION['messenger'] = 'Безопасност обнавлен :)';
    header("Location: /../page_users.php");
    exit;

}
catch(PDOException $e) {
    $_SESSION['error'] = 'Безопасност обнавит не удалос :( <br> Повторите попитку';
    header("Location: /../page_users.php");
    exit;
}

