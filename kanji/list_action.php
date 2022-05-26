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

for ($i = 0; $i < count($_POST['id']); $i++) {
   // 多重配列のため個々にサニタイズする
   // id、item_idはhiddenのためサニタイズしていない
   $title = CommonUtil::sanitaize($_POST['title']);
   $date = CommonUtil::sanitaize($_POST['date']);
   $num = CommonUtil::sanitaize($_POST['num']);
   $budget = CommonUtil::sanitaize($_POST['budget']);
   
   // var_dump($title['1']);
   // echo '<br><hr>';
   
   // 削除
   if (!empty($_POST['del'])) {
      // delはidを取得するだけなのでサニタイズしない
      // $del = CommonUtil::sanitaize($_POST['del']);
      foreach ($_POST['del'] as $v) {
         try {
            $db = BaseModel::getInstance();
            $dbDetail = new ItemModel($db);
            $dbDetail->softDelete($v);
         } catch (Exception $e) {
            // var_dump($e);exit;
            header('Location: ' . $_SERVER['HTTP_REFERER']);
         }
      }
   }

   // バリデーション：1つ目のエラーしか検出しないがとりあえずはOK
   $validityCheck = array();
   // メモ
   $validityCheck[] = validationUtil::isValidLenght(
      $title[$i],
      50,
      $_SESSION['msg']['listTitle'][$i]
   );
   // 日付
   $validityCheck[] = validationUtil::isDate(
      $date[$i],
      $_SESSION['msg']['listDate'][$i]
   );

   // var_dump($validityCheck);die;

   foreach ($validityCheck as $k => $v) {
      // $vにnullが代入されている可能性があるので「===」で比較
      if ($v === false) {
         $_SESSION['msg']['list'] = '入力に不備があります。';
         header('Location: ' . $_SERVER['HTTP_REFERER']);
         exit;
      }
   }

   // postとmsgのセッションをクリア
   require_once '../unsession.php';

   // データベースに登録する内容を連想配列にする
   $data = array(
      'id' => $_POST['id'][$i],
      'item_id' => $_POST['item_id'],
      'title' => $title[$i],
      'date' => $date[$i],
      'num' => $num[$i],
      'budget' => $budget[$i],
   );

   // var_dump($data);die;

   // 更新
   try {
      $db = BaseModel::getInstance();
      $dbDetail = new ItemModel($db);
      $dbDetail->update($data);
      header('Location: ' . $_SERVER['HTTP_REFERER']);
   } catch (Exception $e) {
      var_dump($e);
      exit;
      header('Location: ' . $_SERVER['HTTP_REFERER']);
   }
}
