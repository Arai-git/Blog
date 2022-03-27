<?php

session_start();
$registed = $_SESSION['registed'] ?? '';
$error = $_SESSION['errors'] ?? '';

$_SESSION['registed'] = '';
unset($_SESSION['errors']);

if(empty($name)) {
    $name = "ゲスト";
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
    <form action="signin_complete.php" method="post">
        <p><input type=“text” name="email" type="mail" required placeholder="Email" value="<?php if (
            isset($_SESSION['email'])
        ) {
            echo $_SESSION['email'];
        } ?>"></p>
        <p><input type="password" placeholder="password" name="password" required></p>
        <button type="submit">ログイン</button>
        <br>
        <a href="signup.php">アカウントを作る</a>
    </form>
    </body>
</html>