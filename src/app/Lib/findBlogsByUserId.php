<?php
require_once(__DIR__ . '/../Lib/pdoInit.php');

function findBlogsById(int $id): ?array
{
	$pdo = pdoInit();
  $sql = 'SELECT * FROM blogs WHERE user_id = :id';
  $statement = $pdo->prepare($sql);
  $statement->execute([':id' => $id]);
  $blogs = $statement->fetchAll(PDO::FETCH_ASSOC);
	return ($blogs) ? $blogs : null;
}
?>