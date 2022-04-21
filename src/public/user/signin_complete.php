<?php
require_once __DIR__ . '/../../app/Infrastructure/Dao/UserDao.php';
require_once __DIR__ . '/../../app/Infrastructure/Redirect/redirect.php';
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../app/Lib/Session.php';
use app\Lib\SessionKey;

$mail = filter_input(INPUT_POST, 'mail');
$password = filter_input(INPUT_POST, 'password');

$session = Session::getInstance();
if (empty($email) || empty($password)) {
    $session->appendError("パスワードとメールアドレスを入力してください");
    redirect('./signin.php');
}

$userDao = new UserDao();
$member = $userDao->findByEmail($email);

if (!password_verify($password, $member['password'])) {
    $session->appendError("メールアドレスまたは<br/>パスワードが違います");
    redirect('./signin.php');
}

$_SESSION['formInputs']['userId'] = $member['id'];
$_SESSION['formInputs']['name'] = $member['name'];
redirect('../index.php');
?>