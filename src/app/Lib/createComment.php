<?php
require_once(__DIR__ . '/../Lib/pdoInit.php');

function createComment(int $userId, int $blogId, string $commentName, string $comments): void
{
  $pdo = pdoInit();
  $sql =
        'INSERT INTO comments (user_id, blog_id, commenter_name, comments) VALUES (:userId, :blogId, :commentName, :comments)';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':userId', $userId, PDO::PARAM_INT);
    $statement->bindValue(':blogId', $blogId, PDO::PARAM_INT);
    $statement->bindValue(':commentName', $commentName, PDO::PARAM_STR);
    $statement->bindValue(':comments', $comments, PDO::PARAM_STR);
    $statement->execute();
}
?>