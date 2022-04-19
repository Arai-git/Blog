<?php
require_once(__DIR__ . '/../../app/Lib/pdoInit.php');
require_once(__DIR__ . '/../../app/Lib/redirect.php');
require_once(__DIR__ . '/../../app/Lib/session.php');

session_start();

$id = $_SESSION['id'];
$title = filter_input(INPUT_POST, 'title');
$contents = filter_input(INPUT_POST, 'contents');

if (empty($title) || empty($contents)) $session->appendError("タイトルまたは本文が記入されていません！");
if (!empty($_SESSION['errors'])) {
  $_SESSION['formInputs']['email'] = $email;
  $_SESSION['formInputs']['name'] = $name;
  redirect('create.php');
}

$pdo = pdoInit();

$sql =
      'INSERT INTO blogs (user_id, title, contents) VALUES(:id, :title, :contents)';
  $statement = $pdo->prepare($sql);
  $statement->bindValue(':id', $id, PDO::PARAM_INT);
  $statement->bindValue(':title', $title, PDO::PARAM_STR);
  $statement->bindValue(':contents', $contents, PDO::PARAM_STR);
  $statement->execute();

  header('Location: ../mypage.php');
  exit();
?>