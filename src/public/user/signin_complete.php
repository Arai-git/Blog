<?php
// require_once(__DIR__ . '/../../app/Lib/findUserByMail.php');
// require_once(__DIR__ . '/../../app/Lib/pdoInit.php');
// require_once(__DIR__ . '/../../app/Lib/redirect.php');
// require_once(__DIR__ . '/../../app/Lib/session.php');

// session_start();
// $email = filter_input(INPUT_POST, 'email');
// $password = filter_input(INPUT_POST, 'password');

// $user = findUserByMail($email);
// if (empty($email) || empty($password)) appendError("パスワードとメールアドレスを入力してください");
// if (!password_verify($password, $user['password'])) appendError("メールアドレスまたはパスワードが違います");
// if (!empty($_SESSION['errors'])) {
//   $_SESSION['formInputs']['email'] = $email;
//   $_SESSION['formInputs']['name'] = $name;
//   redirect('signin.php');
// }

// $_SESSION['id'] = $user['id'];
// $_SESSION['name'] = $user['name'];
// header('Location: ../index.php');
// exit();

require_once __DIR__ . '/../../app/Lib/pdoInit.php';
require_once __DIR__ . '/../../app/Lib/findUserByMail.php';
require_once __DIR__ . '/../../app/Lib/redirect.php';
require_once __DIR__ . '/../../app/Lib/session.php';

$mail = filter_input(INPUT_POST, 'mail');
$password = filter_input(INPUT_POST, 'password');

$session = Session::getInstance();
if (empty($mail) || empty($password)) {
    $session->appendError('パスワードとメールアドレスを入力してください');
    redirect('./signin.php');
}

// $userDao = new UserDao();
// $member = $userDao->findByMail($mail);
$users = findUserByMail($mail);

if (!password_verify($password, $users['password'])) {
    $session->appendError('メールアドレスまたは<br />パスワードが違います');
    redirect('./signin.php');
}

$formInputs = [
    'userId' => $users['id'],
    'userName' => $users['user_name'],
];
$session->setFormInputs($formInputs);
redirect('../index.php');
?>