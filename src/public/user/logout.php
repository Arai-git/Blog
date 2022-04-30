<?php

require_once __DIR__ . '/../../app/Infrastructure/Redirect/redirect.php';

use App\Infrastructure\Redirect\Redirect;

session_start();

$_SESSION = [];
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 4200, '/');
}
session_destroy();
Redirect::handler('./signin.php');
?>