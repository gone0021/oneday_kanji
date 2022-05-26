<?php
require_once("../../App/config.php");

use App\Model\BaseModel;
use App\Model\TagModel;

// ユーザー情報を保存
// --- ログインの確認 ---
if (empty($_SESSION['user'])) {
   // 未ログインのとき
   header('Location: ../');
} else {
   // ログイン済みのとき
   $user = $_SESSION['user'];
}

// 保存されたパスワードを削除
$_SESSION['user']['password'] = '';
unset($_SESSION['user']['password']);

// トークンの保存
$_SESSION['token'] = $token;

// itemsの一覧を取得
try {
   $db = BaseModel::getInstance();
   $dbTag = new TagModel($db);
   $tags = $dbTag->getTag($user['id']);
} catch (Exception $e) {
   var_dump($e);die;
   header('Location: ./error.php');
}

