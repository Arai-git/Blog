<?php
require_once(__DIR__ . '/../app/Lib/redirect.php');
require_once(__DIR__ . '/../app/Lib/findBlogById.php');
require_once(__DIR__ . '/../app/Lib/findCommentByBlogId.php');

session_start();

$userId = $_SESSION['id'];
$name = $_SESSION['name'];

$blogId = filter_input(INPUT_GET, 'id');

if (!isset($userId)) {
  header('Location: ./user/signin.php');
  exit('ログインしてください。');
}

$blog = findBlogById($blogId);
$comments = findCommentByBlogId($blogId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>記事詳細ページ</title>
</head>
<body>
  <header>
    <h3>こんにちは、<?php echo $name; ?> さん</h3>
    <a href="index.php">一覧ページ</a>&emsp;&emsp;<a href="logout.php" name="logout">ログアウト</a>
  </header>
  <div>
    <h1>記事詳細ページ</h1>
    <p>投稿日時：<?php echo $blog['created_at']; ?></p>
    <p><?php echo $blog['contents']; ?></p>
    <form method="get" action="index.php">
      <input type="submit" value="ページ一覧へ"></input>
    </form>
    <br>
    <br>
    <br>
  </div>
  <div>
    <form action="comment.php?id=<?php echo $blog['id']; ?>" method="post">
      <h4>この投稿にコメントしますか？</h4>
      <p>コメント名</p>
      <input text="" name="commentName">
      <p>内容</p>
      <input textarea="" name="comments">
      <br>
      <br>
      <input type="submit" action="" name="submitComment" value="コメント"></input>
      <br>
      <br>
      <br>
    </form>
  </div>
  <h3>コメント一覧</h3>
  <table>
    <?php foreach ($comments as $comment): ?>
        <?php echo $comment['commenter_name']; ?>
        <br>
        <?php echo $comment['created_at']; ?>
        <br>
        <?php echo $comment['comments']; ?>
        <br>
        <br>
    <? endforeach; ?>
  </table>
</body>
</html>