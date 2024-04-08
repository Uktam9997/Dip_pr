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
$name = $_POST['name'];
$address_job = $_POST['address_job'];
$phone = $_POST['phone'];
$address = $_POST['address'];




$pdo = new PDO("mysql:host=localhost;dbname=dip_pr;", "root", "");

try{
    $sql = "UPDATE users SET 
        name = :name, 
        address_job = :address_job, 
        phone = :phone, 
        address = :address WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        "name" => $name, 
        "address_job" => $address_job, 
        "phone" => $phone, 
        "address" => $address,
        "id" => $id
    ]);

    // $error = $stmt->errorInfo();
    // var_dump($error);
    // exit;

    $_SESSION['messenger'] = 'Ползователь успешно обновлен :)';
    header("Location: /../page_users.php");

}catch(PDOException $e){
    $_SESSION['error'] = 'Произошло ошибко :( <br> Повторите попитку.';
    header("Location: /../page_users.php");
}

