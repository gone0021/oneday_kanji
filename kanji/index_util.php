<?php
// use app\model\ItemModel;
require_once("../App/config.php");

// クラス
use App\Model\BaseModel;
use App\Model\ItemModel;
use App\Model\DetailModel;
use App\Util\Paging;

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

// ページング設定
$page = 1;
$row = 10;
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
   $page = (int)$_GET['page'];
}
if (!$page) {
   $page = 1;
}

// itemsの一覧を取得
try {
   $db = BaseModel::getInstance();
   $dbItem = new ItemModel($db);
   // 対象の全てのカラムを取得：計算用
   $allItems = $dbItem->getUserItem($user['id']);
   // 表示するカラムを取得：表示用
   $items = $dbItem->getItemNum($user['id'], $page, $row);
   // var_export($items);
} catch (Exception $e) {
   // var_dump($e);
   header('Location: ./error.php');
}


// detailの一覧を取得：残額の計算用
try {
   $db = BaseModel::getInstance();
   $dbDetail = new DetailModel($db);
   // 一覧で取得するためforで配列に保存する
   foreach ($items as $k => $v) {
      $details[$k] = $dbDetail->getDetailByItemId($v['id']);
   }
   // var_export($details);
} catch (Exception $e) {
   // var_dump($e);
   header('Location: ./error.php');
}



// echo '<pre>';
// var_dump($_SESSION);
// echo '</pre>';
// die('die');

//オブジェクトを生成
$pageing = new Paging();
// オリジナル
// $pref = $pageing->usePafing($_GET['page']);
$pageing->count = $row;
$pageing->setHtml(count($allItems));
