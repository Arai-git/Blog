<?php
require_once __DIR__ . '/../app/Infrastructure/Redirect/redirect.php';
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/Lib/seachOrder.php';

session_start();

if (!isset($_SESSION['user']['id'])) {
    redirect('./user/signin.php');
}

$id = $_SESSION['id'];
$name = $_SESSION['name'];

$blogs = seachOrder();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
  <title>blog一覧</title>
</head>

<?php require_once(__DIR__ . '/../app/Lib/header.php'); ?>

<body>
  <div class="blogs__wraper bg-green-300 py-20 px-20">
    <div class="ml-8 mb-12">
    <h1>blog一覧</h1>
      <form action="index.php" method="get">
        <div>
            <input type="textarea" name="search" placeholder="キーワードを入力" value="<?php echo $searchWord ??
                ''; ?>">
            <button type="submit">検索</button>
        </div>
        <div>
          <button type="submit" name="order" value="desc">新しい順</button>
          <button type="submit" name="order" value="asc">古い順</button>
          <br>
          <br>
        </div>
      </form>
    </div>
  </div>
  <h2 class="mb-2 px-2 text-6xl font-bold text-green-800">blog一覧</h2>
  <table>
    <?php foreach ($blogs as $blog): ?>
      <tr>
        <td><?php echo $blog['title']; ?></td>
        <td><?php echo $blog['created_at']; ?></td>
        <td><?php echo mb_substr($blog['contents'], 0, 15); ?></td>
        <td><a href="detail.php?id=<?php echo $blog[
            'id'
        ]; ?>">記事詳細へ</a></td>
      </tr>
    <?php endforeach; ?>
  </table>

  
  
</body>
</html>