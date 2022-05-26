<?php

namespace App\Controllers;

use App\Model\BaseModel;
use App\Model\UserModel;
use Exception;

/**
 * ItemContorollerクラス
 */
class UserController
{
   /** @var object インスタンス */

   protected $db;
   protected $dbUser;

   public function __construct()
   {
      // $this->$db = Base::getInstance();
      $db = BaseModel::getInstance();
      $this->dbUser = new UserModel($db);
   }

   public function isCurrentPass($id, $pass, &$msg)
   {
      // $db = BaseModel::getInstance();
      // $dbUser = new UserModel($db);

      // $rec = $dbUser->getUserById($id);
      $rec = $this->dbUser->getUserById($id);
      if (!password_verify($pass, $rec['password'])) {
         $msg = "パスワードが異なります";
         return false;
      }

      return true;
   }

   /**
    * メールアドレスからユーザーを検索してパスワードをチェック
    * @param string $email メールアドレス
    * @param string $password パスワード
    * @return array ユーザー情報の配列（該当のユーザーが見つからないときは空の配列）
    */
   public function checkPassEmail($email, $pass)
   {

      $rec = $this->dbUser->getUserByEmail($email);

      // var_dump($rec);die;

      if (!password_verify($pass, $rec['password'])) {
         return array();
      }

      unset($rec['password']);

      return $rec;
   }

   /**
    * メールアドレスからユーザーを検索して誕生日をチェック
    * @param string $email メールアドレス
    * @param string $password パスワード
    * @return array ユーザー情報の配列（該当のユーザーが見つからないときは空の配列）
    */
   public function checkBirthdayEmail($email, $birthday)
   {
      $rec = $this->dbUser->getUserByEmail($email);

      if ($birthday != $rec['birthday']) {
         return array();
      }

      unset($rec['password']);

      return $rec;
   }
}
