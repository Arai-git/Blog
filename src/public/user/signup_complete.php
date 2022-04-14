<?php
// require_once(__DIR__ . '/../../app/Lib/findUserByMail.php');
// require_once(__DIR__ . '/../../app/Lib/redirect.php');
// require_once(__DIR__ . '/../../app/Lib/createUser.php');
// require_once(__DIR__ . '/../../app/Lib/session.php');

// session_start();
// $email = filter_input(INPUT_POST, 'email');
// $name = filter_input(INPUT_POST, 'name');
// $password = filter_input(INPUT_POST, 'password');
// $confirmPassword = filter_input(INPUT_POST, 'confirmPassword');

// if (empty($password) || empty($confirmPassword)) appendError("パスワードを入力してください");
// if ($password !== $confirmPassword) appendError("パスワードが一致しません");
// if (!empty($_SESSION['errors'])) {
//   $_SESSION['formInputs']['name'] = $name;
//   $_SESSION['formInputs']['email'] = $email;
//   redirect('signup.php');
// }

// $user = findUserByMail($email);
// if (!is_null($user)) appendError("すでに登録済みのメールアドレスです");
// if (!empty($_SESSION['errors'])) redirect('signup.php');

// createUser($name, $email, $password);
// $_SESSION['registed'] = "登録できました。";
// redirect('signin.php');

require_once __DIR__ . '/../../app/Lib/pdoInit.php';
require_once __DIR__ . '/../../app/Lib/findUserByMail.php';
require_once __DIR__ . '/../../app/Lib/createUser.php';
require_once __DIR__ . '/../../app/Lib/redirect.php';
require_once __DIR__ . '/../../app/Lib/session.php';

$mail = filter_input(INPUT_POST, 'mail');
$userName = filter_input(INPUT_POST, 'userName');
$password = filter_input(INPUT_POST, 'password');
$confirmPassword = filter_input(INPUT_POST, 'confirmPassword');

$session = Session::getInstance();
if (empty($password) || empty($confirmPassword)) {
    $session->appendError('パスワードを入力してください');
}
if ($password !== $confirmPassword) {
    $session->appendError('パスワードが一致しません');
}

if ($session->existsErrors()) {
    $formInputs = [
        'mail' => $mail,
        'userName' => $userName,
    ];
    $session->setFormInputs($formInputs);
    redirect('./signin.php');
}

// // メールアドレスに一致するユーザーの取得
$user = findUserByMail($mail);

if (!is_null($user)) {
    $session->appendError('すでに登録済みのメールアドレスです');
}

if (!empty($_SESSION['errors'])) {
    redirect('./signup.php');
}

// // ユーザーの保存
createUser($userName, $mail, $password);

$successRegistedMessage = '登録できました。';
$session->setMessage($successRegistedMessage);
redirect('./signin.php');
?>