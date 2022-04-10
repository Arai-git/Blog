<?php
require_once(__DIR__ . '/../Lib/pdoInit.php');

function findBlogById(int $blogId): ? array
{
  $pdo = pdoInit();
  $sql = 'SELECT * FROM blogs WHERE id = :id';
  $statement = $pdo->prepare($sql);
  $statement->execute([':id' => $blogId]);
  $blog = $statement->fetch(PDO::FETCH_ASSOC);
	return ($blog) ? $blog : null;
}
?>