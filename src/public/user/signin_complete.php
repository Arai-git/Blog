<?php

require_once(__DIR__ . '/../../app/Lib/findUserByMail.php');
require_once(__DIR__ . '/../../app/Lib/pdoInit.php');
require_once(__DIR__ . '/../../app/Lib/redirect.php');
require_once(__DIR__ . '/../../app/Lib/session.php');

session_start();
$email = filter_input(INPUT_POST, 'email');
$password = filter_input(INPUT_POST, 'password');

$user = findUserByMail($email);
if (empty($email) || empty($password)) appendError("パスワードとメールアドレスを入力してください");
if (!password_verify($password, $user['password'])) appendError("メールアドレスまたはパスワードが違います");
if (!empty($_SESSION['errors'])) {
  $_SESSION['formInputs']['email'] = $email;
  $_SESSION['formInputs']['name'] = $name;
  redirect('signin.php');
}

$_SESSION['id'] = $user['id'];
$_SESSION['name'] = $user['name'];
header('Location: ../index.php');
exit();
?>