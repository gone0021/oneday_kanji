<?php
namespace App\Util;

use App\Model\BaseModel;
use App\Model\UserModel;

/**
 * バリデーションチェック
 */
class ValidationUtil
{
   // --- auth関連 ---
   /**
    * ユーザー名のチェック
    * @param string $name 名前
    * @param string $msg エラーメッセージ
    * @return boolean
    */
   public static function isValidName($name, &$msg): bool
   {
      $msg = '';

      if (empty($name)) {
         $msg = "ユーザー名を入力してください";
         return false;
      }
      if (strlen($name) > 50) {
         $msg = "名前は50文字以内で入力してください";
         return false;
      }
      return true;
   }
   /**
    * ユーザー名の重複チェック
    * @param string $name 名前
    * @param string $msg エラーメッセージ
    * @return boolean
    */
   public static function isUsedName($name, &$msg): bool
   {
      $db = BaseModel::getInstance();
      $dbUser = new UserModel($db);
      $msg = '';
      $checkName = $dbUser->getUserByName($name);

      if (!empty($checkName)) {
         $msg = "このユーザー名は既に使われています";
         return false;
      }
      return true;
   }

   /**
    * メールアドレスのチェック
    * @param string $email メールアドレス
    * @param string $msg エラーメッセージ
    * @return boolean
    */
   public static function isValidEmail($email, &$msg): bool
   {
      $msg = '';

      if (empty($email)) {
         $msg = "メールアドレスを入力してください";
         return false;
      }
      if (!empty($email) && !preg_match('|^[0-9a-z_./?-]+@([0-9a-z-]+\.)+[0-9a-z-]+$|', $email)) {
         $msg = "メールアドレスを正しく入力してください";
         return false;
      }
      if (strlen($email) > 256) {
         $msg = "メールアドレスは256文字以内で入力してください";
         return false;
      }

      return true;
   }

   /**
    * メールアドレスの重複チェック
    * @param string $email メールアドレス
    * @param string $msg エラーメッセージ
    * @return boolean
    */
   public static function isUsedEmail($email, &$msg): bool
   {
      $db = BaseModel::getInstance();
      $dbUser = new UserModel($db);
      $msg = '';
      $checkEmail = $dbUser->getUserByEmail($email);

      if (!empty($checkEmail)) {
         $msg = "このメールアドレスは既に使われています";
         return false;
      }
      return true;
   }


   /**
    * 日付形式のチェック
    * @param string $date 日付形式の文字列
    * @return boolean 正しいとき：true、正しくないとき：false
    */
   public static function isBirthday($date, &$msg): bool
   {
      // strtotime()で正しい日付か確認
      // https://www.php.net/manual/ja/function.strtotime.php
      $msg = '';
      if (empty($date)) {
         $msg = "誕生日を入力してください";
         return false;
      }
      if (!strtotime($date)) {
         $msg = "正しい日付を入力してください";
         return false;
      }
      if (strlen($date) > 10) {
         $msg = "正しい日付を入力してください";
         return false;
      }
      return true;
   }

   /**
    * パスワードのチェック
    * @param string $pass パスワード
    * @param string $msg エラーメッセージ
    * @return boolean
    */
   public static function isValidPass($pass, &$msg): bool
   {
      $msg = '';
      if (empty($pass)) {
         $msg = "パスワードを入力してください";
         return false;
      }
      //  if (strlen($pass) < 8) {
      //    $msg = "8文字以上で入力してください";
      //    return false;
      //  }
      //  if (!empty($pass) && !preg_match('/(?=.*?[a-z])(?=.*?[0-9])[a-z0-9]/', $pass)) {
      //    $msg = "半角英数字を含めて入力してください";
      //  return false;
      //  }

      return true;
   }

   /**
    * パスワードのダブルチェック
    * @param string $item1 入力内容1
    * @param string $item2 入力内容2
    * @param string $msg エラーメッセージ
    * @return boolean
    */
   public static function isDoubleCheck($item1, $item2, &$msg): bool
   {
      $msg = '';
      if (empty($item1)) {
         $msg = "パスワードを入力してください";
         return false;
      }
      if (empty($item2)) {
         $msg = "確認用のパスワードを入力してください";
         return false;
      }
      if ($item1 != $item2) {
         $msg = "入力が一致しません";
         return false;
      }
      return true;
   }

   //+------------------------------------------------------------------+
   //| item check                                                       |
   //+------------------------------------------------------------------+
   /**
    * 正しい日付形式の文字列かどうかを判定
    * @param string $date 日付形式の文字列
    * @return boolean 正しいとき：true、正しくないとき：false
    */
   public static function isDate($date, &$msg): bool
   {
      $msg = '';
      if (empty($date)) {
         $msg = "日付を入力してください";
         return false;
      }

      if (!strtotime($date)) {
         $msg = "正しい日付を入力してください";
         return false;
      }
      
      $ret = explode('-',$date);
      // var_dump($ret);die;
      if ((int)$ret['0'] > 3000) {
         $msg = "正しい日付を入力してください";
         return false;
      }

      return true;
   }


   /**
    * 数字（INT型）のチェック
    * @param int $num int型の整数
    * @return bool boool型
    */
   public static function isNum($num, &$msg): bool
   {
      $msg = '';
      if (!is_numeric($num)) {
         $msg = "整数で入力してください";
         return false;
      }
      return true;
   }

   /**
    * item名のチェック
    * @param string $item item名
    * @param string $msg エラーメッセージ
    * @return boolean
    */
   public static function isValidItem($item, &$msg): bool
   {
      $msg = '';
      if (empty($item)) {
         $msg = "255文字以内で入力してください";
         return false;
      }
      if (strlen($item) > 255) {
         $msg = "255文字以内でご入力ください";
         return false;
      }
      return true;
   }

   /**
    * 備考のチェックします。
    *
    * @param  $comment 備考の内容
    * @param string $msg エラーメッセージ
    * @return boolean
    */
   public static function isValidComment($comment, &$msg): bool
   {
      $msg = '';
      if (strlen($comment) > 1000) {
         $msg = "コメントは1,000文字以内で入力してください。";
         return false;
      }
      return true;
   }

   // --- items, boards ---
   /**
    * 文字数のチェック
    * @param string $data 文字列
    * @param string $cnt 文字数
    * @return boolean 正しいとき：true、正しくないとき：false
    */
   public static function isValidLenght($data, $cnt, &$msg)
   {
      $msg = '';
      if (strlen($data) > $cnt) {
         $msg = $cnt . '文字以内でご入力ください';
         return false;
      }

      return true;
   }
}
