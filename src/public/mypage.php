<?php
session_start();

$sessionId = $_SESSION['id'];
$name = $_SESSION['name'];

$blogId = filter_input(INPUT_GET, 'id');

if (!isset($_SESSION['email'])) {
    header('Location: ./user/signin.php');
    exit('ログインしてください。');
}

$dbUserName = 'root';
$dbPassWord = 'password';
$pdo = new PDO(
    'mysql:host=mysql;dbname=blog;charset=utf8',
    $dbUserName,
    $dbPassWord
);

$sql = 'SELECT * FROM blogs WHERE user_id = :id';
$statement = $pdo->prepare($sql);
$statement->execute([':id' => $sessionId]);
$blogs = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>マイページ一覧</title>
</head>
<body>
  <header>
    <h3>こんにちは、<?php echo $name; ?> さん</h3>
    <a href="index.php">一覧ページ</a>&emsp;&emsp;<a href="logout.php" name="logout">ログアウト</a>
    <h1>blog一覧</h1>
  </header>
  <div>
      <form action="post/create.php">
        <button type="submit">新規作成</button>
      </form>
  </div>
  <table>
    <?php foreach ($blogs as $blog): ?>
      <tr>
      <td><?php echo $blog['title']; ?></td>
        <td><?php echo $blog['created_at']; ?></td>
        <td><?php echo mb_substr($blog['contents'], 0,15); ?><td>
        <td><a href="myarticledetail.php?id=<?php echo $blog[
            'id'
        ]; ?>">記事詳細へ</a></td>
      </tr>
    <?php endforeach; ?>
  </table>
</body>
</html>