<?php
require_once 'new_util.php';
?>

<section id="new" class="section c">
   <!-- エラーメッセージ -->
   <div>
      <?php if (!empty($_SESSION["msg"]["new"])) : ?>
         <p class="error">
            <?= $_SESSION["msg"]["new"] ?>
         </p>
      <?php endif ?>
   </div>
   <div class="title acdTitle mb-3">新規登録</div>
   <div class="acdItem">
   <!-- <div> -->
      <form action="./new_action.php" method="POST">
         <input type="hidden" name="token" value="<?= $token ?>">
         <input type="hidden" name="item_id" value="<?= $item['id'] ?>">

         <div class="mb-3">
            <div class="mb-3">
               <?php if (!empty($_SESSION["msg"]["newTag_id"])) : ?>
                  <p class="error">
                     <?= $_SESSION["msg"]["newTag_id"] ?>
                  </p>
               <?php endif ?>
               <select name="tag_id" id="tag_id" class="form-control">
                  <?php foreach ($tags as $k => $v) : ?>
                     <option value="<?= $v['id'] ?>" <?php if($tagId == $v['id']) echo 'selected'; ?>><?= $v['tag_name'] ?></option>
                  <?php endforeach ?>
               </select>
            </div>

            <div class="mb-3">
               <?php if (!empty($_SESSION["msg"]["newPrice"])) : ?>
                  <p class="error">
                     <?= $_SESSION["msg"]["newPrice"] ?>
                  </p>
               <?php endif ?>
               <input type="number" name="price" id="" class="form-control" placeholder="金額" value="<?= $price ?>" required>
            </div>

            <div class="mb-3">
               <?php if (!empty($_SESSION["msg"]["newIs_recived"])) : ?>
                  <p class="error">
                     <?= $_SESSION["msg"]["newIs_recived"] ?>
                  </p>
               <?php endif ?>
               <input type="number" name="is_recived" id="" class="form-control" placeholder="回収金額" value="<?= $isRecived ?>">
            </div>

            <div class="mb-3">
               <?php if (!empty($_SESSION["msg"]["newMemo"])) : ?>
                  <p class="error">
                     <?= $_SESSION["msg"]["newMemo"] ?>
                  </p>
               <?php endif ?>
               <input type="search" name="memo" id="" class="form-control" placeholder="メモ" value="<?= $memo ?>">
            </div>

            <div class="mb-3">
               <input type="submit" value="追加" class="btn mr-3">
               <input type="reset" value="リセット" class="btn">
            </div>

            <div>タグの編集は<a href="<?= $url ?>/kanji/tag/" target="blank">こちら</a></div>
            <div>※ タグを編集した再は当ページを更新してください</div>

         </div>
      </form>
   </div>
</section>