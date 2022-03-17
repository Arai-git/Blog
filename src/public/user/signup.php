<?php
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

if ($clientInfomation['email'] === $email) {
    $message = '同じメールアドレスが存在します。';
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
    $message = '会員登録が完了しました。';
    $link = '<a href="../index.php">ブログ一覧ページ</a>';
    echo $message . "\n" . $link;
}

if ($_POST['create']) {
    //指定したハッシュがパスワードにマッチしているかチェック
    if (password_verify($password, $clientInfomation['password'])) {
        //DBのユーザー情報をッションに保存
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $message = 'ログインしました。';
        $link = '<a href="../index.php">ホーム</a>';
        echo $message . "\n" . $link;
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
        <a href="../mypage.php" name="mypage">マイページ</a><a href="../logout.php" name="logout">ログアウト</a>
        <h1>blog一覧</h1>
      </header>
      <h1>会員登録</h1>
      <form action="" method="post">
          <input type="text" name="name" size="50" placeholder="User name"></input>
          <br>
          <input type="text" name="email" size="50" placeholder="Email" required></input>
          <br>
          <input type="password" name="passWord" size="50" placeholder="PassWord" required></input>
          <br>
          <input type="password" name="confirmPassWord" size="50" placeholder="確認のためもう一度ご入力お願いいたします" required></input>
          <br>
          <input type="submit" name="create" value="アカウント作成">
          <br>
          <a href="signin.php">ログイン画面へ</a>
      </form>
  </body>
</html>