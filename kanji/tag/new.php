<?php
// code...
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
         <input type="hidden" name="user_id" value="<?= $user['id'] ?>">

         <div class="mb-3">
            <div class="mb-3">
               <?php if (!empty($_SESSION["msg"]["newTag_name"])) : ?>
                  <p class="error">
                     <?= $_SESSION["msg"]["newTag_name"] ?>
                  </p>
               <?php endif ?>
               <input type="search" name="tag_name" id="" class="form-control" placeholder="タグ名" value="" required>
            </div>

            <div>
               <input type="submit" value="追加" class="btn mr-3">
               <input type="reset" value="リセット" class="btn">
            </div>
         </div>
      </form>
   </div>
</section>