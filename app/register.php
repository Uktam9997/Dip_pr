<?php 

session_start();

if(!isset($_POST['email']) || !isset($_POST['password'])) {
    $_SESSION['error'] = 'Заполните все поля !';
    header('Location: /../page_register.php');
    exit;
}

$email = htmlspecialchars($_POST['email']);
$password = htmlspecialchars($_POST['password']);
$pdo = new PDO("mysql:host=localhost;dbname=dip_pr;", "root", "");


$sql = "SELECT * FROM admin WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->execute(['email' => $email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if($user) {
    $_SESSION['error'] = 'Этот эл. адрес уже занят другим пользователем. <br> 
    Eсли это ваше эл. адрес то переходите на страницу авторизации и автаризуйтес.';
    header('Location: /../page_register.php');
    exit;
}


try{

    $sql = "INSERT INTO admin (email, password) VALUES (:email, :password)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email, 'password' => password_hash($password, PASSWORD_DEFAULT)]);

    $_SESSION['messenger'] = 'Вы успешно зарегистрировалис ;)';
    header('Location: /../page_login.php');

} catch(PDOException $e){

    $_SESSION['error'] = 'Проезашло ошибко! Пожалуйеста повторите попитку';
    header('Location: /../page_register.php');

}





