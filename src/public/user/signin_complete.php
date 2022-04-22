<?php
require_once __DIR__ . '/../../app/Infrastructure/Dao/UserDao.php';
require_once __DIR__ . '/../../app/Infrastructure/Redirect/redirect.php';
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../app/Lib/Session.php';

use app\Lib\SessionKey;
use App\Infrastructure\Dao\UserDao;

$email = filter_input(INPUT_POST, 'email');
$password = filter_input(INPUT_POST, 'password');

session_start();
if (empty($email) || empty($password)) {
    $_SESSION['errors'][] = 'パスワードとメールアドレスを入力してください';
    redirect('./signin.php');
}

$userDao = new UserDao();
$member = $userDao->findByEmail($email);

if (!password_verify($password, $member['password'])) {
    $_SESSION['errors'][] = 'メールアドレスまたは<br/>パスワードが違います';
    redirect('./signin.php');
}

$_SESSION['formInputs']['userId'] = $member['id'];
$_SESSION['formInputs']['name'] = $member['name'];
redirect('../index.php');
?>