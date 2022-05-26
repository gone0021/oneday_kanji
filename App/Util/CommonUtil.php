<?php
namespace App\Util;

/**
 * 共通関数クラスです。
 */
class CommonUtil
{
   /**
    * POSTされたデータをサニタイズする
    *
    * @param array $before サニタイズ前のPOST配列
    * @return array サニタイズ後のPOST配列
    */
   public static function sanitaize($before)
   {
      $after = array();

      // postされたデータを
      foreach ($before as $k => $v) {
         $after[$k] = htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
      }

      return $after;
   }

   /**
    * postされた値とsessionに保存された値のチェック
    * @param int $session sessionに保存された値
    * @param int $post postで受け取った値
    * @return void
    */
   public static function csrf($session, $post)
   {
      if (!isset($session) || $session !== $post) {
         $_SESSION['msg']['error'] = "不正な処理が行われました。";
         header('Location: ' . $_SERVER['HTTP_REFERER']);
         exit;
      } else {
         // unset($post);
      }
   }

   /**
    * 値の有無をチェック  
    * 引数に値があればそのまま返す
    * @param array 保存されている値
    * @return array 保存されている値
    */
   public static function checkVal($val)
   {
      if (empty($val)) {
         // 未ログインのとき
         header('Location: ../');
      } else {
         // ログイン済みのとき
         return $val;
      }
   }
}
