<?php
  require_once(__DIR__ . '/../app/Lib/redirect.php');
  require_once(__DIR__ . '/../app/Lib/findBlogById.php');
  require_once(__DIR__ . '/../app/Lib/findCommentByBlogID.php');

  session_start();

  $sessionId = $_SESSION['id'];
  $name = $_SESSION['name'];

  $blogId = filter_input(INPUT_GET, 'id');
  
  if (!isset($sessionId)) {
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
  <h1>記事詳細ページ</h1>
  <h3><?php echo "タイトル：" . $blog['title']; ?></h3>
  <div>
    <p>投稿日時：<?php echo $blog['created_at']; ?></p>
    <p><?php echo $blog['contents']; ?></p>
    <a href="edit.php?id=<?php echo $blog['id']; ?>">編集</a>
    <a href="delete.php?id=<?php echo $blog['id']; ?>">削除</a>
    <br>
    <br>
    <form method="get" action="mypage.php">
      <input type="submit" value="マイページ一覧へ"></input>
    </form>
  </div>
</body>
</html>