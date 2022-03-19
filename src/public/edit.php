<?php
session_start();

$id = $_SESSION['id'];
$name = $_SESSION['name'];

if (!isset($_SESSION['email'])) {
    header('Location: ./user/signin.php');
    exit('ログインしてください。');
}


$id = filter_input(INPUT_GET, 'id');
$dbUserName = 'root';
$dbPassWord = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=blog; charset=utf8',
    $dbUserName,
    $dbPassWord
);

$sql = 'SELECT * FROM blogs WHERE id = :id';
$statement = $pdo->prepare($sql);
$statement->execute([':id' => $id]);
$blog = $statement->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
  <head>
  <meta charset="utf-8">
      <title>メモ編集ページ</title>
  </head>
  <body>
    <header>
      <h3>こんにちは、<?php echo $name; ?> さん</h3>
      <a href="index.php">一覧ページ</a>&emsp;&emsp;<a href="logout.php" name="logout">ログアウト</a>
    </header>
    <h1>メモ編集</h1>
    <form action="update.php?id=<?php echo $blog['id']; ?>" method="post">
      <p>タイトル</p>
      <input value="<?php echo $blog[
          'title'
      ]; ?>" type="text" name="title" size="20"></input>
      <br>
      <br>
      <p>内容</p>
      <textarea name="contents" style="width:300px; height:100px;"><?php echo $blog[
          'contents'
      ]; ?></textarea><br>
      <br>
      <input type="submit"  value="編集">
    </form>
  </body>
</html>