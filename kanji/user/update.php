<?php
require_once("../../App/config.php");

// クラス
use App\Util\CommonUtil;
use App\Model\BaseModel;
use App\Model\UserModel;

// フォームで送信されてきたトークンが正しいかどうか確認（CSRF対策）
CommonUtil::csrf($_SESSION['token'], $_POST['token']);

// サニタイズ
$post = CommonUtil::sanitaize($_POST);

unset($post['token']);

// パスワードの暗号化
$hash = password_hash($post['password'], PASSWORD_DEFAULT);

// データベースに登録する内容を連想配列にする。
$data = array(
   'id' => $post['id'],
   'user_name' => $post['user_name'],
   'email' => $post['email'],
   'birthday' => $post['birthday'],
   'password' => $hash,
);

// echo '<pre> data : ';
// var_export($data);
// echo '</pre>';
// die('die');

try {
   $db = BaseModel::getInstance();
   $dbUser = new UserModel($db);
   $dbUser->updateUser($data);

   // セッションをクリア
   $_SESSION['msg'] = '';
   unset($_SESSION['msg']);
   $_SESSION['user']['password'] = '';
   unset($_SESSION['user']['password']);

   $_SESSION['user'] = $data;

   header('Location: ./');
} catch (Exception $e) {
   var_dump($e);
   exit;
   header('Location: ../error.php');
}


// ユーザーページへ遷移
