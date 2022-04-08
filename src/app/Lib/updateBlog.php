<?php
require_once(__DIR__ . '/../Lib/pdoInit.php');

function updateBlog(int $id, string $title, string $contents): void
{
  $pdo = pdoInit();
  $sql = 'UPDATE blogs SET title = :title, contents = :contents WHERE id = :id';
  $statement = $pdo->prepare($sql);
  $statement->bindValue(':id', $id);
  $statement->bindValue(':title', $title, PDO::PARAM_STR);
  $statement->bindValue(':contents', $contents, PDO::PARAM_STR);
  $statement->execute();
}
?>