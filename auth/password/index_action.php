<?php
// 共通ファイル
require_once("../../App/config.php");

// クラスの読み込み
use App\Util\CommonUtil;
use App\Util\ValidationUtil;
use App\Controllers\UserController;

// CSRF対策）
CommonUtil::csrf($_SESSION['token'], $_POST['token']);

// サニタイズ
$post = CommonUtil::sanitaize($_POST);

// POSTされてきた値をSESSIONに代入（入力画面で再表示）
$_SESSION['post'] = $post;

// バリデーションチェック
$validityCheck = array();

// メールアドレス
$validityCheck[] = validationUtil::isValidEmail(
   $post['email'],
   $_SESSION['msg']['email']
);
// 誕生日
$validityCheck[] = validationUtil::isBirthday(
   $post['birthday'],
   $_SESSION['msg']['birthday']
);

// バリデーションで不備があった場合
foreach ($validityCheck as $k => $v) {
   // $vにnullが代入されている可能性があるので「===」で比較
   if ($v === false) {
      // POSTされてきた値をSESSIONに代入（入力画面で再表示）
      $_SESSION["post"]["email"] = $post["email"];
      $_SESSION["post"]["birthday"] = $post["birthday"];
      header('Location: ./');
      exit;
   }
}

try {
   // ユーザーの検索とユーザー情報の取得
   $conUser = new UserController();

   // 入力フォームで入力されたemailとpasswordをgetUserの引数にpost
   $user = $conUser->checkBirthdayEmail($post["email"], $post["birthday"]);

   if (empty($user)) {
      // ユーザーの情報が取得できなかったとき
      // エラーメッセージをセッション変数に保存 → ログインページに表示
      $_SESSION["msg"]["reset"] = "情報が一致しません";

      // POSTされてきた値をSESSIONに代入（入力画面で再表示）
      $_SESSION["post"]["email"] = $post["email"];
      $_SESSION["post"]["birthday"] = $post["birthday"];

      // ログインページへリダイレクト
      header("Location: ./");

   } else {
      // メールアドレスの情報が取得できたとき
      // セッション変数に保存されているエラーメッセージをクリア
      $_SESSION["msg"]["reset"] = "";
      unset($_SESSION["msg"]["reset"]);

      // セッション変数に保存されているPOSTされてきたデータをクリア
      $_SESSION["post"] = "";
      unset($_SESSION["post"]);

      // POSTされてきたメールをセッションに保存→updateのwhereに使用
      $_SESSION["email"] = $post["email"];

      // // 作業一覧ページを表示
      header('Location: ./reset.php');
   }
} catch (Exception $e) {
   // var_dump($e);exit;
   header("Location: ../../error.php");
}
