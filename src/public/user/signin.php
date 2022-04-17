<?php
require_once __DIR__ . '/../../app/Lib/session.php';

$session = Session::getInstance();
$errors = $session->popAllErrors();
$successRegistedMessage = $session->getMessage();
?>

<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
        <title>ログイン</title>
    </head>
    <body>
    <h1>ログイン</h1>
    <?php foreach ($errors as $error): ?>
        <p><?php echo $error; ?></p>
    <?php endforeach; ?>
    <form action="signin_complete.php" method="post">
        <p><input type=“text” name="email" type="mail" required placeholder="Email" value="<?php echo $mail; ?>"></p>
        <p><input type="password" placeholder="password" name="password" required></p>
        <button type="submit">ログイン</button>
        <br>
        <a href="signup.php">アカウントを作る</a>
    </form>
    </body>
</html>