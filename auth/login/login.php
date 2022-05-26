<?php
// 共通ファイル
require_once("../../App/config.php");

// クラス
use App\Util\CommonUtil;
use App\Model\BaseModel;
use App\Model\UserModel;
use App\Controllers\UserController;

// CSRF対策）
CommonUtil::csrf($_SESSION['token'], $_POST['token']);

// サニタイズ
$post = CommonUtil::sanitaize($_POST);

// POSTされてきた値をSESSIONに代入（入力画面で再表示）
$_SESSION['post'] = $post;

unset($post['token']);

try {
   // ユーザー情報の取得
   $db = BaseModel::getInstance();
   $dbUser = new UserModel($db);
   $conUser = new UserController();
   $user = $conUser->checkPassEmail($post["email"], $post["password"]);

   if (empty($user)) {
      // --- ユーザーの情報が取得できなかったとき ---
      // エラーメッセージをSESSIONに保存
      $_SESSION["msg"]["login"] = "情報が一致しません";

      // POSTされてきたメールアドレスをSESSIONに保存
      $_SESSION["post"]["email"] = $post["email"];

      // ログインページへリダイレクト
      header("Location: ./");
   } else {
      // --- ユーザー情報が取得できたとき ---
      // ユーザー情報をSESSIONに保存
      // session_destroy();

      $_SESSION["user"] = $user;
      $dbUser->updateUserLastLogin($user['id']);

      // SESSIONに保存されているエラーメッセージをクリア
      $_SESSION["msg"] = "";
      unset($_SESSION["msg"]);

      // SESSIONに保存されているPOSTされてきたデータをクリア
      $_SESSION["post"] = "";
      unset($_SESSION["post"]);

      $_SESSION["token"] = "";
      unset($_SESSION["token"]);

      // var_dump($_SESSION);die;

      // itemsページへリダイレクト
      header("Location: ../../kanji/");
   }
} catch (Exception $e) {
   // echo '<pre>';
   // var_dump($e);exit;
   // echo '</pre>';
   header("Location: ../../error.php");
}
