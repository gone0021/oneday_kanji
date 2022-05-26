<?php
require_once("../../App/config.php");

// クラスの読み込み
use App\Util\CommonUtil;
use App\Util\ValidationUtil;
use App\Model\BaseModel;
use App\Model\TagModel;

// CSRF対策
CommonUtil::csrf($_SESSION['token'], $_POST['token']);
unset($_SESSION['token']);

for ($i = 0; $i < count($_POST['id']); $i++) {
   // 多重配列のため個々にサニタイズする
   // hiddenはサニタイズしていない
   $tag_name = CommonUtil::sanitaize($_POST['tag_name']);

   // 削除
   if (!empty($_POST['del'])) {
      // delはidを取得するだけなのでサニタイズしない
      // $del = CommonUtil::sanitaize($_POST['del']);
      $db = BaseModel::getInstance();
      $dbTag = new TagModel($db);
      foreach ($_POST['del'] as $v) {
         try {
            $dbTag->hardDelete($v);
         } catch (Exception $e) {
            var_dump($e);
            exit;
            // header('Location: ' . $_SERVER['HTTP_REFERER']);
         }
      }
   }

   // バリデーション：1つ目のエラーしか検出しないがとりあえずはOK
   $validityCheck = array();
   // タグ名：最初の5つはデフォルト値のため編集しない
   $validityCheck[] = validationUtil::isValidLenght(
      $tag_name[$i],
      50,
      $_SESSION['msg']['listTag_name'][$i+5]
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

   // データベースに登録する内容を連想配列にする
   $data = array(
      'user_id' => $_POST['user_id'],
      'id' => $_POST['id'][$i],
      'tag_name' => $tag_name[$i],
   );

   // var_dump($data);die;

   // 更新
   try {
      $db = BaseModel::getInstance();
      $dbTag = new TagModel($db);
      $dbTag->update($data);
      header('Location: ' . $_SERVER['HTTP_REFERER']);
   } catch (Exception $e) {
      var_dump($e);
      exit;
      // header('Location: ' . $_SERVER['HTTP_REFERER']);
   }
}
