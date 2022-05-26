<?php
require_once("../../App/config.php");

// クラス
use App\Util\CommonUtil;
use App\Util\ValidationUtil;
use App\Model\BaseModel;
use App\Model\UserModel;

// フォームで送信されてきたトークンが正しいかどうか確認（CSRF対策）
CommonUtil::csrf($_SESSION['token'], $_POST['token']);

// サニタイズ
$post = CommonUtil::sanitaize($_POST);

// POSTされてきた値をSESSIONに代入（入力画面で再表示）
$_SESSION['post'] = $post;

// ログインユーザーの情報を変数に保存
// --- ログインの確認 ---
if (empty($_SESSION['user'])) {
   header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
   $user = $_SESSION['user'];
}

try {
   $db = BaseModel::getInstance();
   $dbUser = new UserModel($db);
   $rec = $dbUser->getUserById($user['id']);
} catch (Exception $e) {
   // var_dump($e);exit;
   header('Location: ' . $_SERVER['HTTP_REFERER']);
}

if (!password_verify($post['pass'], $rec['password'])) {
   // ユーザーの情報が一致しなかったとき
   // die('ng');

   // 他のエラーメッセージを削除
   $_SESSION['msg'] = '';
   unset($_SESSION['msg']);

   // エラーメッセージをSESSIONに保存
   $_SESSION['msg']['setting'] = '情報が一致しません';

   // 新規登録ページへリダイレクト
   header('Location: ' . $_SERVER['HTTP_REFERER']);
}

// バリデーションチェック
$validityCheck = array();
if ($user['user_name'] != $post['user_name']) {
   $validityCheck[] = validationUtil::isValidName(
      $post['user_name'],
      $_SESSION['msg']['user_name']
   );
   // ユーザー名の重複
   $validityCheck[] = $dbUser->isUsedName(
      $post['user_name'],
      $_SESSION['msg']['user_name']
   );
}
if ($user['email'] != $post['email']) {
   $validityCheck[] = validationUtil::isValidEmail(
      $post['email'],
      $_SESSION['msg']['email']
   );
   // メールアドレスの重複
   $validityCheck[] = $dbUser->isUsedEmail(
      $post['email'],
      $_SESSION['msg']['email']
   );
}
if ($user['birthday'] != $post['birthday']) {
   $validityCheck[] = validationUtil::isBirthday(
      $post['birthday'],
      $_SESSION['msg']['birthday']
   );
}
// 現在のパスワード
$validityCheck[] = validationUtil::isValidPass(
   $post['pass'],
   $_SESSION['msg']['pass']
);
// postするパスワードの値
$post_pass = $post['pass'];

// 新しいパスワード
// ダブルチェック
if (!empty($post['pass1']) || !empty($post['pass2'])) {
   $validityCheck[] = validationUtil::isDoubleCheck(
      $post['pass1'],
      $post['pass2'],
      $_SESSION['msg']['pass2']
   );
   // postするパスワードの値を上書き
   $post_pass = $post['pass2'];
}

// バリデーションで不備があった場合
foreach ($validityCheck as $k => $v) {
   // $vにnullが代入されている可能性があるので「===」で比較
   if ($v === false) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit;
   }
}


// postとmsgのセッションをクリア
require_once("../../unsession.php");

// トークンの生成
$_SESSION['token'] = $token;

// パスワードを伏せ字に
$pass = str_repeat('*', strlen($post_pass));

// echo '<pre>';
// var_dump($post);
// echo '</pre>';
// die('die');
