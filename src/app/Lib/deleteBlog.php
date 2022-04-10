<?php
require_once(__DIR__ . '/../Lib/pdoInit.php');

function deleteBlog(int $id): void
{
  $pdo = pdoInit();
  $sql = 'DELETE FROM blogs WHERE id = :id';
  $statement = $pdo->prepare($sql);
  $statement->execute([':id' => $id]);
}
?>