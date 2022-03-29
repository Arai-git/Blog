<?php
session_start();
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);

$name = filter_input(INPUT_POST, 'name');

if (empty($name)) {
    $name = 'ゲスト';
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
      <?php foreach ($errors as $error): ?>
        <p><?php echo $error; ?></p>
      <?php endforeach; ?>
      <form action="./signup_complete.php" method="POST">
        <p>
          <input placeholder="User name" type=“text” name="name" required value="<?php if (
              isset($_SESSION['name'])
          ) {
              echo $_SESSION['name'];
          } ?>">
        </p>
        <p><input placeholder="Email" type=“mail” name="email" required value="<?php if (
            isset($_SESSION['email'])
        ) {
            echo $_SESSION['email'];
        } ?>"></p>
        <p><input placeholder="Password" type="password" name="password"></p>
        <p><input placeholder="Password確認" type="password" name="confirmPassword"></p>
        <button type="submit">アカウント作成</button>
      </form>
      <a href="signin.php">ログイン画面へ</a>
  </body>
</html>