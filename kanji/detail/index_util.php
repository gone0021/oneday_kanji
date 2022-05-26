<?php
require_once("../../App/config.php");

use App\Model\BaseModel;
use App\Model\ItemModel;
use App\Model\DetailModel;
use App\Model\TagModel;
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

// 

// ページング設定
$page = 1;
$row = 10;
if(isset($_GET['page']) && is_numeric($_GET['page'])){
    $page = (int)$_GET['page'];
}
if(!$page){
    $page = 1;
}


// 該当するidのitemを取得
try {
   $db = BaseModel::getInstance();
   $dbItem = new ItemModel($db);
   $item = $dbItem->getItemById($_GET['item_id']);
   // var_export($items);
} catch (Exception $e) {
   var_dump($e);die;
   header('Location: ./error.php');
}

// detailsの取得
try {
   $dbDetail = new DetailModel($db);
   $dbTag = new TagModel($db);
   $allDetails = $dbDetail->getDetailByItemId($item['id']);
   $details = $dbDetail->getDetailByItemIdNum($item['id'], $page, $row);
} catch (Exception $e) {
   echo $e;die;
   header('./');
}

// tagsの取得
try {
   $dbTag = new TagModel($db);
   $tags = $dbTag->getTag($user['id']);
} catch (Exception $e) {
   // echo $e;die;
   header('Location: ' . $_SERVER['HTTP_REFERER']);
}

// echo '<pre>';
// var_dump($_SESSION);
// echo '</pre>';
// die('die');


//オブジェクトを生成
$pageing = new Paging();
// オリジナル
// $pref = $pageing->usePafing($_GET['page']);
$pageing -> count = $row;
$pageing -> setHtml(count($allDetails));
