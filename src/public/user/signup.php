<?php
require_once __DIR__ . '/../../app/Lib/session.php';

session_start();

$session = Session::getInstance();
$errors = $session->popAllErrors();
$formInputs = $session->getFormInputs();

$userName = $formInputs['userName'] ?? '';
$mail = $formInputs['mail'] ?? '';
// require_once(__DIR__ . '/../../app/Lib/session.php');

// session_start();
// $errors = errorsInit();
// $name = $_SESSION['formInputs']['name'] ?? '';
// $mail = $_SESSION['formInputs']['mail'] ?? '';
?>

<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
        <title>会員登録</title>
    </head>
    <body>
      <h1>会員登録</h1>
      <?php foreach ($errors as $error): ?>
        <p><?php echo $error; ?></p>
      <?php endforeach; ?>
      <form action="./signup_complete.php" method="POST">
        <p><input placeholder="User name" type=“text” name="name" required value="<?php echo $name; ?>"></p>
        <p><input placeholder="Email" type=“mail” name="email" required value="<?php echo $mail; ?>"></p>
        <p><input placeholder="Password" type="password" name="password"></p>
        <p><input placeholder="Password確認" type="password" name="confirmPassword"></p>
        <button type="submit">アカウント作成</button>
      </form>
      <a href="signin.php">ログイン画面へ</a>
  </body>
</html>