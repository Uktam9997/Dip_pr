<?php 

session_start();

if(!empty($_GET['action'])) {
    unset($_SESSION['user_nic']);
    header("Location: /../page_login.php");
    exit;
}



if(empty($_POST['email']) || empty($_POST['password'])) {
    $_SESSION['error'] = 'Заполните все поля !';
    header('Location: /../page_login.php');
    exit;
}

$email = htmlspecialchars($_POST['email']);
$password = htmlspecialchars($_POST['password']);
$pdo = new PDO("mysql:host=localhost;dbname=dip_pr;", "root", "");


$sql = "SELECT * FROM admin WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->execute(['email' => $email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);


if(!$user) {
    $_SESSION['error'] = 'Ползовател не найден! :( <br> Но это не страшно вы тут можете зарегистрироватся :) !!!';
    header('Location: /../page_register.php');
    exit;
}

$password_verify = password_verify($password, $user['password']);


if(!$password_verify) {
    $_SESSION['error'] = 'Не верный логин или пароль!';
    header("Location: /../page_login.php");
    exit;
}

$_SESSION['user_nic'] = $email;

header("Location: /../page_users.php");







