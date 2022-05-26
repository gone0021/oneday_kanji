<?php
// 共通ファイル
require_once("../../App/config.php");

// クラス
use App\Util\CommonUtil;
use App\Util\ValidationUtil;

// CSRF対策）
CommonUtil::csrf($_SESSION['token'], $_POST['token']);
// サニタイズ
$post = CommonUtil::sanitaize($_POST);

// POSTされてきた値をSESSIONに代入（入力画面で再表示）
$_SESSION['post'] = $post;

// バリデーションチェック
$validityCheck = array();
// ユーザー名
$validityCheck[] = validationUtil::isValidName(
   $post['name'],
   $_SESSION['msg']['name']
);
// ユーザー名の重複
$validityCheck[] = validationUtil::isUsedName(
   $post['name'],
   $_SESSION['msg']['name']
);
// メールアドレス
$validityCheck[] = validationUtil::isValidEmail(
   $post['email'],
   $_SESSION['msg']['email']
);
// メールアドレスの重複
$validityCheck[] = validationUtil::isUsedEmail(
   $post['email'],
   $_SESSION['msg']['email']
);
// 誕生日
$validityCheck[] = validationUtil::isBirthday(
   $post['birthday'],
   $_SESSION['msg']['birthday']
);
// パスワード
$validityCheck[] = validationUtil::isValidPass(
   $post['pass1'],
   $_SESSION['msg']['pass1']
);
// パスワード（確認用）
$validityCheck[] = validationUtil::isValidPass(
   $post['pass2'],
   $_SESSION['msg']['pass2']
);
// ダブルチェック
$validityCheck[] = validationUtil::isDoubleCheck(
   $post['pass1'],
   $post['pass2'],
   $_SESSION['msg']['pass2']
);

// バリデーションで不備があった場合
foreach ($validityCheck as $k => $v) {
   // $vにnullが代入されている可能性があるので「===」で比較
   if ($v === false) {
      header('Location: ./');
      exit;
   }
}

// パスワードを伏せ字に
$pass = str_repeat('*', strlen($post["pass2"]));
// $hide = $post["pass2"];

// // パスワードの暗号化：パスワードチェックを行うため登録時に実行する
// $hash = password_hash($post['pass2'], PASSWORD_DEFAULT);

// エラーメッセージをクリア
unset($_SESSION['msg']);
$_SESSION['msg'] = null;

// トークンの生成
$token = bin2hex(openssl_random_pseudo_bytes(108));
$_SESSION['token'] = $token;

//  var_dump($hide);
