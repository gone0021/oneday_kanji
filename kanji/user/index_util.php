<?php
require_once("../../App/config.php");

// セッションに保存した値を変数に代入
$name = $_SESSION['user']['user_name'];
if (!empty($_SESSION['post']['user_name'])) {
   $name =  $_SESSION['post']['user_name'];
}
$email = $_SESSION['user']['email'];
if (!empty($_SESSION['post']['email'])) {
   $email = $_SESSION['post']['email'];
}
$birthday = date("2000-01-01");
if (!empty($_SESSION['post']['birthday'])) {
   $birthday = $_SESSION['post']['birthday'];
}

// トークンの保存
$_SESSION['token'] = $token;

// ログインユーザーの情報を変数に保存
if (!empty($_SESSION['user'])) {
   $user = $_SESSION['user'];
}


// echo '<pre>';
// var_dump($_SESSION['post']);
// echo '</pre>';
