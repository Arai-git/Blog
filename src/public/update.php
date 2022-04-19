<?php
require_once(__DIR__ . '/../app/Lib/redirect.php');
require_once(__DIR__ . '/../app/Lib/session.php');
require_once(__DIR__ . '/../app/Lib/updateBlog.php');

$id = filter_input(INPUT_GET, 'id');
$title = filter_input(INPUT_POST, 'title');
$contents = filter_input(INPUT_POST, 'contents');

$session = Session::getInstance();
if (empty($title) || empty($contents)) {
    $session->appendError('タイトルまたは本文が記入されていません！');
    header('Location: edit.php');
}

$blog = updateBlog($id, $title, $contents);

header('Location: myarticledetail.php?id=' . $id);
exit();
?>