<?php

require_once __DIR__ . '/../../app/Lib/session.php';

$session = Session::getInstance();
$errors = $session->popAllErrors();
$successRegistedMessage = $session->getMessage();

$name = $_SESSION['name'];

if (!isset($id)) {
    header('Location: ../user/signin.php');
    exit('ログインしてください。');
}
?>

<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
        <title>メモ登録ページ</title>
    </head>
    <body>
    <header>
        <h3>こんにちは、<?php echo $name; ?> さん</h3>
        <a href="../mypage.php">マイページ</a>&emsp;&emsp;<a href="../logout.php" name="logout">ログアウト</a>
    </header>
    <?php foreach ($errors as $error): ?>
        <p><?php echo $error; ?></p>
    <?php endforeach; ?>
    <h1>メモ登録</h1>
    <form action="create_complete.php" method="post">
        <p>タイトル</p>
        <input type="text" name="title" size="20"></input>
        <br>
        <br>
        <p>内容</p>
        <textarea name="contents" style="width:300px; height:100px;"></textarea><br>
        <br>
        <input type="submit" action="create_complete.php" name="create" value="新規作成">
    </form>
    </body>
</html>