<?php

//файль подключон на page_users.php

session_start();

$pdo = new PDO("mysql:host=localhost;dbname=dip_pr;", "root", "");

$sql = "SELECT users.id, users.name, users.address_job, users.phone, users.address,
    security_media.email, security_media.password, security_media.status, security_media.avatar,
    social_network.vk, social_network.telegram, social_network.instagram
    FROM users
    LEFT JOIN security_media ON users.id = security_media.user_id
    LEFT JOIN social_network ON users.id = social_network.user_id";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

