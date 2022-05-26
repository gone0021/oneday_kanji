<?php
require_once("../../App/config.php");

// クラスの読み込み
use App\Util\CommonUtil;
use App\Util\ValidationUtil;
use App\Model\BaseModel;
use App\Model\DetailModel;

// CSRF対策
CommonUtil::csrf($_SESSION['token'], $_POST['token']);
unset($_SESSION['token']);

for ($i = 0; $i < count($_POST['id']); $i++) {
   // 多重配列のため個々にサニタイズする
   // id、item_idはhiddenのためサニタイズしていない
   $tag_id = CommonUtil::sanitaize($_POST['tag_id']);
   $price = CommonUtil::sanitaize($_POST['price']);
   $is_recived = CommonUtil::sanitaize($_POST['is_recived']);
   $memo = CommonUtil::sanitaize($_POST['memo']);

   // var_dump($del);die;
   // echo '<br><hr>';

   // 削除
   if (!empty($_POST['del'])) {
      // delはidを取得するだけなのでサニタイズしない
      // $del = CommonUtil::sanitaize($_POST['del']);
      foreach ($_POST['del'] as $v) {
         try {
            $db = BaseModel::getInstance();
            $dbDetail = new DetailModel($db);
            $dbDetail->softDelete($v);
         } catch (Exception $e) {
            var_dump($e);
            exit;
            // header('Location: ' . $_SERVER['HTTP_REFERER']);
         }
      }
   }

   // バリデーション：1つ目のエラーしか検出しないがとりあえずはOK
   $validityCheck = array();
   // メモ
   $validityCheck[] = validationUtil::isValidLenght(
      $memo[$i],
      100,
      $_SESSION['msg']['listMemo'][$i]
   );

   foreach ($validityCheck as $k => $v) {
      // $vにnullが代入されている可能性があるので「===」で比較
      if ($v === false) {
         $_SESSION['msg']['list'] = '入力に不備があります。';
         header('Location: ' . $_SERVER['HTTP_REFERER']);
         exit;
      }
   }


   // データベースに登録する内容を連想配列にする
   $data = array(
      'id' => $_POST['id'][$i],
      'item_id' => $_POST['item_id'],
      'tag_id' => $tag_id[$i],
      'price' => $price[$i],
      'is_recived' => $is_recived[$i],
      'memo' => $memo[$i],
   );

   // var_dump($data);die;

   // 更新
   try {
      $db = BaseModel::getInstance();
      $dbDetail = new DetailModel($db);
      $dbDetail->update($data);
      header('Location: ' . $_SERVER['HTTP_REFERER']);
   } catch (Exception $e) {
      var_dump($e);
      exit;
      // header('Location: ' . $_SERVER['HTTP_REFERER']);
   }
}
