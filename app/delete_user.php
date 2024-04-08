<?php 

session_start();

if(!$_GET['id']) {
    $_SESSION['error'] = 'повторите попитку';
    header("Location: /../page_users.php");
    exit;

}


$user_id = $_GET['id'];
$path_avatar = $_GET['path_avatar'];


$pdo = new PDO("mysql:host=localhost;dbname=dip_pr;", "root", "");

$delete_user = "DELETE FROM users WHERE id = :user_id";
$stmt_user = $pdo->prepare($delete_user);
$stmt_user->execute(['user_id' => $user_id]);

$delete_security_media = "DELETE FROM security_media WHERE user_id = :user_id";
$stmt_security_media = $pdo->prepare($delete_security_media);
$stmt_security_media->execute(['user_id' => $user_id]);

$delete_social_network = "DELETE FROM social_network WHERE user_id = :user_id";
$stmt_social_network = $pdo->prepare($delete_social_network);
$stmt_social_network->execute(['user_id' => $user_id]);

$path_img = 'C:\xampp\htdocs\Dip_pr\app' . '/' . $path_avatar;

if (file_exists($path_img)) {
    
        if($stmt_user && $stmt_security_media && $stmt_social_network) {
            unlink($path_img);
            $_SESSION['messenger'] = 'Ползовател удален';
            header("Location: /../page_users.php");
            exit;
        }
    $_SESSION['error'] = "Удалить ползователя не удалос :( <br> Попробуйте еще раз.";
    header("Location: /../page_users.php");
    exit;
}
