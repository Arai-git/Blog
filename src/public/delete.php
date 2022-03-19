<?php
$dbUserName = 'root';
$dbPassWord = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=blog; charset=utf8',
    $dbUserName,
    $dbPassWord
);

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$sql = 'DELETE FROM blogs WHERE id = :id';
$statement = $pdo->prepare($sql);
$statement->execute([':id' => $id]);

header('Location: mypage.php');
exit();
?>