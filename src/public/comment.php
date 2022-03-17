<?php
session_start();

$blogId = filter_input(INPUT_GET, 'id');
$userId = $_SESSION['id'];

if ($_POST['submitComment']) {
    $commentName = filter_input(INPUT_POST, 'commentName');
    $comments = filter_input(INPUT_POST, 'comments');
}

if ($_POST['submitComment']) {
    $dbUserName = 'root';
    $dbPassWord = 'password';
    $pdo = new PDO(
        'mysql:host=mysql;dbname=blog;charset=utf8',
        $dbUserName,
        $dbPassWord
    );
    $sql =
        'INSERT INTO comments (user_id, blog_id, commenter_name, comments) VALUES (:userId, :blogId, :commentName, :comments)';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':userId', $userId, PDO::PARAM_INT);
    $statement->bindValue(':blogId', $blogId, PDO::PARAM_INT);
    $statement->bindValue(':commentName', $commentName, PDO::PARAM_STR);
    $statement->bindValue(':comments', $comments, PDO::PARAM_STR);
    $statement->execute();

    header('Location: detail.php?id=' . $blogId);
    exit();
}
?>
   ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?> ?>