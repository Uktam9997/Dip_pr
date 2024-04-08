<?php

session_start();


if(!$_GET['id'] || !$_GET['path_img']) {
    $_SESSION['error'] = 'Повторите попитку';
    header("Location: /../page_users.php");
    exit;

}

if(!$_FILES) {
    $_SESSION['error'] = 'Повторите попитку';
    header("Location:/ /../page_users.php");
    exit;
}

$id = $_GET['id'];
$path_avatar = $_GET['path_img'];
$avatar = $_FILES['avatar'];

// var_dump($id);
// var_dump($path_img);
// var_dump($avatar); exit;

function uploads_avatar($avatar){
    $result = pathinfo($avatar['name']);
    $file_name = uniqid() . "." . $result['extension'];
    $upload_path = 'uploads/' . $file_name;

    if (move_uploaded_file($avatar['tmp_name'], $upload_path)) {
        return $upload_path;
    } else {
        return false;
        $_SESSION['error'] = 'Файл не загружен!';
        header("Location: /../page_users.php");
        exit;
    }
}
$path_avatar = uploads_avatar($avatar);
$path_img = 'C:\xampp\htdocs\Dip_pr\app' . '/' . $path_avatar;

// var_dump($path_img); exit;
try{
    $pdo = new PDO("mysql:host=localhost;dbname=dip_pr;", "root", "");

    $sql = "UPDATE security_media SET avatar = :path_avatar WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['path_avatar' => $path_avatar, 'id' => $id]);

    if (file_exists($path_img)) {
        unlink($path_img);
        
        $_SESSION['messenger'] = 'Аватар обнавлен :)';
        header("Location: /../page_users.php");
        exit;
    } else {
        $_SESSION['error'] = "Не получилос удалить предедуший аватар! <br> Файл не найден.";
        header("Location: /../page_users.php");
        exit;
    }
    exit;

}
catch(PDOException $e) {
    $_SESSION['error'] = 'Аватар обнавит не удалос :( <br> Повторите попитку';
    header("Location: /../page_users.php");
    exit;
}
