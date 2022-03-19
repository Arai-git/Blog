<?php
session_start();
$name = filter_input(INPUT_POST, 'name');

if (empty($name)) {
    $name = 'ゲスト';
}

$email = filter_input(INPUT_POST, 'email');
$passWord = filter_input(INPUT_POST, 'passWord');
$confirmPassWord = filter_input(INPUT_POST, 'confirmPassWord');

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    $_SESSION['errors'][] = 'POST送信になっていません！';
}

if ($_POST['create']) {
    if ($passWord !== $confirmPassWord) {
        echo 'パスワードと確認用パスワードを一致させてください。';
    }
}

try {
    $dbUserName = 'root';
    $dbPassWord = 'password';
    $pdo = new PDO(
        'mysql:host=mysql;dbname=blog;charset=utf8',
        $dbUserName,
        $dbPassWord
    );
    $sql = 'SELECT * FROM users WHERE email = :email';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':email', $email, PDO::PARAM_STR);
    $statement->execute();
    $clientInfomation = $statement->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $message = $e->getMessage();
}

if ($_POST['create']) {
    if ($clientInfomation['email'] === $email) {
        $message = '同じメールアドレスが存在します。';
        echo $message;
    } else {
        $hashPassWord = password_hash($passWord, PASSWORD_DEFAULT);
        $hashConfirmPassWord = password_hash($confirmPassWord, PASSWORD_DEFAULT);
        $sql =
            'INSERT INTO users (name, email, password) VALUES (:name, :email, :password)';
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':name', $name, PDO::PARAM_STR);
        $statement->bindValue(':email', $email, PDO::PARAM_STR);
        $statement->bindValue(':password', $hashConfirmPassWord, PDO::PARAM_STR);
        $statement->execute();
        header('Location: signin.php');
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
        <title>会員登録</title>
    </head>
    <body>
      <header>
        <h3>こんにちは、<?php echo $name; ?> さん</h3>
      </header>
      <h1>会員登録</h1>
      <form action="" method="post">
          <input type="text" name="name" size="25" placeholder="User name"></input>
          <br>
          <br>
          <input type="text" name="email" size="25" placeholder="Email" required></input>
          <br>
          <br>
          <input type="password" name="passWord" size="25" placeholder="PassWord" required></input>
          <br>
          <br>
          <input type="password" name="confirmPassWord" size="25" placeholder="確認用Password" required></input>
          <br>
          <br>
          <input type="submit" name="create" value="アカウント作成">
          <br>
          <br>
          <br>
          <a href="signin.php">ログイン画面へ</a>
      </form>
  </body>
</html>