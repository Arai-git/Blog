<?php

require_once(__DIR__ . '/../Lib/pdoInit.php');

function seachOrder() {

  if (isset($_GET['order'])) {
      $direction = $_GET['order'];
  } else {
      $direction = 'desc';
  }

  if (isset($_GET['search'])) {
      $title = '%' . $_GET['search'] . '%';
      $content = '%' . $_GET['search'] . '%';
  } else {
      $title = '%%';
      $content = '%%';
  }

  $pdo = pdoInit();
  $sql = "SELECT * FROM blogs WHERE title LIKE :title OR contents LIKE :contents ORDER BY id $direction";
  $statement = $pdo->prepare($sql);
  $statement->bindValue(':title', $title, PDO::PARAM_STR);
  $statement->bindValue(':contents', $content, PDO::PARAM_STR);
  $statement->execute();
  $blogs = $statement->fetchAll(PDO::FETCH_ASSOC);
  return $blogs;
}
?>