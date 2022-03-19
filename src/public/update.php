<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['errors'][] = 'POST送信になっていません！';
}

$id = filter_input(INPUT_GET, 'id');
$title = filter_input(INPUT_POST, 'title');
$contents = filter_input(INPUT_POST, 'contents');

if (empty($title) || empty($contents)) {
    $_SESSION['errors'][] = 'タイトルまたは本文が記入されていません！';
} else {
  $dbUserName = 'root';
  $dbPassWord = 'password';
  $pdo = new PDO(
      'mysql:host=mysql; dbname=blog; charset=utf8',
      $dbUserName,
      $dbPassWord
  );
  $sql = 'UPDATE blogs SET title = :title, contents = :contents WHERE id = :id';
  $statement = $pdo->prepare($sql);
  $statement->bindValue(':id', $id);
  $statement->bindValue(':title', $title, PDO::PARAM_STR);
  $statement->bindValue(':contents', $contents, PDO::PARAM_STR);
  $statement->execute();
  header('Location: myarticledetail.php?id=' . $id);
  exit();
}
?>