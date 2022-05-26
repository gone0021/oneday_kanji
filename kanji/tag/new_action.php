<?php
require_once("../../App/config.php");

// クラスの読み込み
use App\Util\CommonUtil;
use App\Util\ValidationUtil;
use App\Model\BaseModel;
use App\Model\TagModel;

// CSRF対策
CommonUtil::csrf($_SESSION['token'], $_POST['token']);
unset($_SESSION['token']);

// サニタイズ
$post = CommonUtil::sanitaize($_POST);

// POSTされてきた値をSESSIONに代入（入力画面で再表示）
$_SESSION['post'] = $post;
unset($post['token']);

// バリデーション
// メモ
$validityCheck[] = validationUtil::isValidLenght(
   $post['tag_name'],
   50,
   $_SESSION['msg']['newTag_name']
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
   'user_id' => $post['user_id'],
   'tag_name' => $post['tag_name'],
);
// die;

try {
   $db = BaseModel::getInstance();
   $dbTag = new TagModel($db);
   $dbTag->insert($data);
   header('Location: ' . $_SERVER['HTTP_REFERER']);
   // header('Location: ./');
} catch (Exception $e) {
   // var_dump($e);exit;
   header('Location: ' . $_SERVER['HTTP_REFERER']);
}
