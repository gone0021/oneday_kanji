<?php
require_once("../../App/config.php");

// クラスの読み込み
use App\Util\CommonUtil;
use App\Util\ValidationUtil;
use App\Model\BaseModel;
use App\Model\DetailModel;

// echo '<pre> : post';
// var_dump($_POST);
// echo '</pre>';
// echo '<pre> : session';
// var_dump($_SESSION);
// echo '</pre>';
// die('die');

// CSRF対策
CommonUtil::csrf($_SESSION['token'], $_POST['token']);
unset($_SESSION['token']);

// サニタイズ
$post = CommonUtil::sanitaize($_POST);

// POSTされてきた値をSESSIONに代入（入力画面で再表示）
$_SESSION['post'] = $post;
unset($post['token']);

// バリデーション
$validityCheck = array();
// タグid
$validityCheck[] = validationUtil::isNum(
   $post['tag_id'],
   $_SESSION['msg']['newTag_id']
);
// 金額
$validityCheck[] = validationUtil::isNum(
   $post['price'],
   $_SESSION['msg']['newPrice']
);
// 回収金額
if (empty($post['is_recived'])) {
   $post['is_recived'] = 0;
} else {
   $validityCheck[] = validationUtil::isNum(
      $post['is_recived'],
      $_SESSION['msg']['newIs_recived']
   );
}
// メモ
$validityCheck[] = validationUtil::isValidLenght(
   $post['memo'],
   100,
   $_SESSION['msg']['newMemo']
);


// バリデーションで不備があった場合
foreach ($validityCheck as $k => $v) {
   // $vにnullが代入されている可能性があるので「===」で比較
   if ($v === false) {
      $_SESSION['msg']['new'] = '入力に不備があります。';
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit;
   }
}

// postとmsgのセッションをクリア
require_once '../../unsession.php';


// データベースに登録する内容を連想配列にする。
$data = array(
   'item_id' => $post['item_id'],
   'tag_id' => $post['tag_id'],
   'price' => $post['price'],
   'memo' => $post['memo'],
   'is_recived' => $post['is_recived'],
);

try {
   $db = BaseModel::getInstance();
   $dbDetail = new DetailModel($db);
   // insert
   $dbDetail->insert($data);
   header('Location: ' . $_SERVER['HTTP_REFERER']);
   // header('Location: ./');
} catch (Exception $e) {
   // var_dump($e);exit;
   header('Location: ' . $_SERVER['HTTP_REFERER']);
}
