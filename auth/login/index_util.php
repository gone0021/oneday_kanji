<?php
// 共通ファイル
require_once("../../App/config.php");

// トークンの保存
$_SESSION['token'] = $token;

// POSTされてきた値をSESSIONに代入（入力画面で再表示）
$email = "";
if (!empty($_SESSION['post']['email'])) {
   $email = $_SESSION['post']['email'];
}
