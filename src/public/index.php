<?php

session_start();

if (!isset($_SESSION['email'])) {
  header('Location: ./user/signin.php');
  exit();
}

$id = $_SESSION['id'];
$name = $_SESSION['name'];

if (isset($_GET['order'])) {
    $direction = $_GET['order'];
} else {
    $direction = 'desc';
}

if (isset($_GET['search'])) {
    $title = '%' . $_GET['search'] . '%';
    $content = '%' . $_GET['search'] . '%';
} else {
    $title = '%%';
    $content = '%%';
}

$dbUserName = 'root';
$dbPassWord = 'password';
$pdo = new PDO(
    'mysql:host=mysql;dbname=blog;charset=utf8',
    $dbUserName,
    $dbPassWord
);
$sql = "SELECT * FROM blogs WHERE title LIKE :title OR contents LIKE :contents ORDER BY id $direction";
$statement = $pdo->prepare($sql);
$statement->bindValue(':title', $title, PDO::PARAM_STR);
$statement->bindValue(':contents', $content, PDO::PARAM_STR);
$statement->execute();
$blogs = $statement->fetchAll(PDO::FETCH_ASSOC);

$sql = 'SELECT * FROM users';
$statement = $pdo->prepare($sql);
$statement->execute();
$user = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>blog一覧</title>
</head>
<body>
  <header>
    <h3>こんにちは、<?php echo $name; ?> さん</h3>
    <a href="mypage.php" name="mypage">マイページ</a>&emsp;&emsp;<a href="logout.php" name=logout>ログアウト</a>
  </header>
  <div>
    <h1>blog一覧</h1>
      <form action="index.php" method="get">
        <div>
            <input type="textarea" name="search" placeholder="キーワードを入力" value="<?php echo $searchWord ??
                ''; ?>">
            <button type="submit">検索</button>
        </div>
        <div>
          <button type="submit" name="order" value="desc">新しい順</button>
          <button type="submit" name="order" value="asc">古い順</button>
        </div>
      </form>
  </div>
  <table>
    <?php foreach ($blogs as $blog): ?>
      <tr>
        <td><?php echo $blog['title']; ?></td>
        <td><?php echo $blog['created_at']; ?></td>
        <td><?php echo $blog['contents']; ?></td>
        <td><a href="detail.php?id=<?php echo $blog[
            'id'
        ]; ?>">記事詳細へ</a></td>
      </tr>
    <?php endforeach; ?>
  </table>

  
  
</body>
</html>