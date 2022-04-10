<?php
require_once(__DIR__ . '/../app/Lib/redirect.php');
require_once(__DIR__ . '/../app/Lib/createComment.php');

session_start();
$userId = $_SESSION['id'];

if(empty($userId)) {
    header('Location: ./user/signin.php');
    exit();
}

$blogId = filter_input(INPUT_GET, 'id');
$commentName = filter_input(INPUT_POST, 'commentName');
$comments = filter_input(INPUT_POST, 'comments');
$createComment = createComment($userId, $blogId, $commentName, $comments);

header('Location: detail.php?id=' . $blogId);
exit();
?>