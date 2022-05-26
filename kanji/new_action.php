<?php
require_once("../App/config.php");

// クラスの読み込み
use App\Util\CommonUtil;
use App\Util\ValidationUtil;
use App\Model\BaseModel;
use App\Model\ItemModel;

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
$validityCheck[] = validationUtil::isValidLenght(
   $post['title'],
   50,
   $_SESSION['msg']['newTitle']
);

$validityCheck[] = validationUtil::isDate(
   $post['date'],
   $_SESSION['msg']['newDate']
);

$validityCheck[] = validationUtil::isNum(
   $post['num'],
   $_SESSION['msg']['newNum']
);

if (empty($post['budget'])) {
   $post['badget'] = 0;
} else {
   $validityCheck[] = validationUtil::isNum(
      $post['budget'],
      $_SESSION['msg']['newBudget']
   );
}

// バリデーションで不備があった場合
foreach ($validityCheck as $k => $v) {
   // $vにnullが代入されている可能性があるので「===」で比較
   if ($v === false) {
      $_SESSION['msg']['new'] = '入力に不備があります。';
      header('Location: ./');
      exit;
   }
}

// postとmsgのセッションをクリア
require_once '../unsession.php';


// データベースに登録する内容を連想配列にする。
$data = array(
   'user_id' => $_SESSION['user']['id'],
   'title' => $post['title'],
   'date' => $post['date'],
   'num' => $post['num'],
   'budget' => $post['budget'],
);

try {
   $db = BaseModel::getInstance();
   $dbItem = new ItemModel($db);
   // insert
   $dbItem->insert($data);
   header('Location: ./');
} catch (Exception $e) {
   var_dump($e);
   exit;
   // header('Location: ../error.php');
}
