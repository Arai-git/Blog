<?php

session_start();

if (!isset($_SESSION['email'])) {
    header('Location: ../user/signin.php');
    exit('ログインしてください。');
}

$id = $_SESSION['id'];
$name = $_SESSION['name'];

if ($_POST['create']) {
    $dbUserName = 'root';
    $dbPassWord = 'password';
    $pdo = new PDO(
        'mysql:host=mysql; dbname=blog; charset=utf8',
        $dbUserName,
        $dbPassWord
    );

    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        $_SESSION['errors'][] = 'POST送信になっていません！';
    }

    $title = filter_input(INPUT_POST, 'title');
    $contents = filter_input(INPUT_POST, 'contents');

    if (empty($title) || empty($contents)) {
        $_SESSION['errors'][] = 'タイトルまたは本文が記入されていません！';
    }

    $sql =
        'INSERT INTO blogs (user_id, title, contents) VALUES(:id, :title, :contents)';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->bindValue(':title', $title, PDO::PARAM_STR);
    $statement->bindValue(':contents', $contents, PDO::PARAM_STR);
    $statement->execute();

    header('Location: ../mypage.php');
    exit();
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
        <a href="index.php">一覧ページ</a>&emsp;&emsp;<a href="logout.php" name="logout">ログアウト</a>
    </header>
    <h1>メモ登録</h1>
    <form action="create.php" method="post">
        <p>タイトル</p>
        <input type="text" name="title" size="20"></input>
        <br>
        <br>
        <p>内容</p>
        <textarea name="contents" style="width:300px; height:100px;"></textarea><br>
        <br>
        <input type="submit" action="" name="create" value="新規作成">
    </form>
    </body>
</html>