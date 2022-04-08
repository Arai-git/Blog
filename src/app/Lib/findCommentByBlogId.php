<?php
require_once(__DIR__ . '/../Lib/pdoInit.php');

function findCommentByBlogId(int $blogId): ? array
{
	$pdo = pdoInit();
  $sql = "SELECT * FROM comments WHERE blog_id = :id";
  $statement = $pdo->prepare($sql);
  $statement->execute([':id' => $blogId]);
  $comments = $statement->fetchAll(PDO::FETCH_ASSOC);
	return ($comments) ? $comments : null;
}
?>