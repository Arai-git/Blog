<?php

session_start();

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
    if (password_verify($password, $clientInfomation['password'])) {
        $_SESSION['id'] = $clientInfomation['id'];
        $_SESSION['name'] = $clientInfomation['name'];
        $_SESSION['email'] = $clientInfomation['email'];
        $_SESSION['password'] = $clientInfomation['password'];
        header('Location: ../index.php');
    } else {
        $message = 'メールアドレスもしくはパスワードが間違っています。';
        echo $message;
    }
}

if (empty($_SESSION['name'])) {
    $name = 'ゲスト';
} else {
    $name = $_SESSION['name'];
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
    </header>
    <h1>ログイン</h1>
    <form action="" method="post">
        <input type="text" name="email" size="20" placeholder="Email"></input>
        <br>
        <br>
        <input type="password" name="password" size="20" placeholder="Password"></input>
        <br>
        <br>
        <input type="submit" name="create" value="ログイン">
        <br>
        <br>
        <a href="signup.php">アカウントを作る</a>
    </form>
    </body>
</html>