<?php

session_start();


foreach ($_POST as $input_name => $input_value) {
    if (empty($input_value)) {
        $_SESSION['error'] = 'Все поля обязательно для заполнения';
        header("Location: /../page_create_user.php");
        exit;
    }
}


if(empty($_FILES['avatar']['name']) || empty($_FILES['avatar']['tmp_name'])) {
    $_SESSION['error'] = 'Загузит файль не получилос :( <br> Повторите попитку.';
    header("Location: /../page_create_user.php");
    exit;
}

$avatar = $_FILES['avatar'];

$name = htmlspecialchars($_POST['name']);
$address_job = htmlspecialchars($_POST['address_job']);
$phone = htmlspecialchars($_POST['phone']);
$address = htmlspecialchars($_POST['address']);
$email = htmlspecialchars($_POST['email']);
$password = htmlspecialchars($_POST['password']);
$status = htmlspecialchars($_POST['status']);
$vk = htmlspecialchars($_POST['vk']);
$telegram = htmlspecialchars($_POST['telegram']);
$instagram = htmlspecialchars($_POST['instagram']);


$pdo = new PDO("mysql:host=localhost;dbname=dip_pr;", "root", "");

$sql = "SELECT * FROM security_media WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->execute(['email' => $email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if($user) {
    $_SESSION['error'] = 'Этот эл. адрес уже занят другим пользователем.';
    header("Location: /../page_create_user.php");
    exit;
}

function get_users($pdo, $name, $address_job, $phone, $address) {
    $sql = "INSERT INTO users (name, address_job, phone, address) VALUES (:name, :address_job, :phone, :address)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'name' => $name,
        'address_job' => $address_job,
        'phone' => $phone,
        'address' => $address,
    ]);

    // Получаем ID только что созданного пользователя
     $user_id = $pdo->lastInsertId();
     return $user_id;
}

$user_id = get_users($pdo, $name, $address_job, $phone, $address);
// var_dump($user_id);
// exit;

if(!$user_id) {
    $_SESSION['error'] = 'Добавит ползавателя не получилос :( <br> Повторите попитку.';
    header("Location: /../page_create_user.php");
    exit;
}

function upload_file($file) {
    $result = pathinfo($file['name']);
    $file_name = uniqid() . "." . $result['extension'];
    $upload_path = 'uploads/' . $file_name;

    if (move_uploaded_file($file['tmp_name'], $upload_path)) {
        return $upload_path;
    } else {
        return false;
        $_SESSION['error'] = 'Файл не загружен!';
        header("Location: /../page_create_user.php");
        exit;
    }
}

$path_avatar = upload_file($_FILES['avatar']);

function get_security_media($pdo, $user_id, $email, $password, $status, $path_avatar) {
    
    $sql = "INSERT INTO security_media (user_id, email, password, status, avatar) VALUES 
    (:user_id, :email, :password, :status, :avatar)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'user_id' => $user_id,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'status' => $status,
        'avatar' => $path_avatar,
    ]);
    $security_media = $pdo->lastInsertId();

    if (!$security_media) {
        $_SESSION['error'] = 'Не получилось добавить Безопасность и Медиа :( <br> Повторите попытку.';
        header("Location: /../page_create_user.php");
        exit;
    }
}
get_security_media($pdo, $user_id, $email, $password, $status, $path_avatar);

function get_social_network($pdo, $user_id, $vk, $telegram, $instagram) {
    $sql = "INSERT INTO social_network (user_id, vk, telegram, instagram) VALUES (:user_id, :vk, :telegram, :instagram)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'user_id' => $user_id,
        'vk' => $vk,
        'telegram' => $telegram,
        'instagram' => $instagram
    ]);
    
    $social_network = $pdo->lastInsertId();

    if(!$social_network) {
        $_SESSION['error'] = 'Не получилос добавить Социальные сети :( <br> Повторите попитку.';
        header("Location: /../page_create_user.php");
        exit;
    }
}
get_social_network($pdo, $user_id, $vk, $telegram, $instagram);

$_SESSION['messenger'] = 'Ползовател добавлен!';
header("Location: /../page_users.php");
