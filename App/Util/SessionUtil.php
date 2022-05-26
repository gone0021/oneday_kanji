<?php
/**
 * セッション関連のユーティリティクラス
 */
class SessionUtil
{
   /**
    * セッションスタート
    *
    * @return void
    */
   public static function sessionStart()
   {
      if (!isset($_SESSION)) {
         session_start();
         session_regenerate_id(true);
      }
   }
}
