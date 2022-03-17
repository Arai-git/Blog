<?php

session_start();
$id = $_SESSION['id'];
$name = $_SESSION['name'];

if (empty($name)) {
    $name = 'ゲスト';
}

$email = filter_input(INPUT_POST, 'email');
$password = filter_input(INPUT_POST, 'password');

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
    //指定したハッシュがパスワードにマッチしているかチェック
    if (password_verify($password, $clientInfomation['password'])) {
        //DBのユーザー情報をッションに保存
        $_SESSION['id'] = $clientInfomation['id'];
        $_SESSION['name'] = $clientInfomation['name'];
        $_SESSION['email'] = $clientInfomation['email'];
        $_SESSION['password'] = $clientInfomation['password'];
        $message = 'ログインしました。';
        $link = '<a href="../index.php">ホーム</a>';
        echo $message . "\n" . $link;
    } else {
        $message = 'メールアドレスもしくはパスワードが間違っています。';
        $link = '<a href="signin.php">戻る</a>';
        echo $message . "\n" . $link;
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
        <title>ログイン</title>
    </head>
    <body>
    <header>
      <h3>こんにちは、<?php echo $name; ?> さん</h3>
      <a href="../mypage.php" name="mypage">マイページ</a><a href="../logout.php" name="logout">ログアウト</a>
      <h1>blog一覧</h1>
    </header>
    <h1>ログイン</h1>
    <form action="" method="post">
        <input type="text" name="email" size="20" placeholder="Email"></input>
        <br>
        <input type="password" name="password" size="20" placeholder="Password"></input>
        <br>
        <input type="submit" name="create" value="ログイン">
        <br>
        <a href="signup.php">アカウントを作る</a>
    </form>
    </body>
</html>