<?php
// code...
?>

<section id="itemList" class="section c">
   <div class="title c mb-3">タグ一覧</div>

   <?php if (!empty($_SESSION["msg"]["list"])) : ?>
      <p class="error">
         <?= $_SESSION["msg"]["list"] ?>
      </p>
   <?php endif ?>

   <form method="POST" action="./list_action.php">
      <input type="hidden" name="token" id="" value="<?= $token ?>">
      <input type="hidden" name="user_id" id="" value="<?= $user['id'] ?>">
      <!-- <table class="c table table-hover"> -->
      <table class="table">
         <tr>
            <!-- <th class="">No.</th> -->
            <th class="vm">削除</th>
            <th class="vm">タグ名</th>
         </tr>

         <!-- 共通タグ：消さない -->
         <?php for ($i = 0; $i < 6; $i++) : ?>
            <input type="hidden" name="[]" value="<?= $tags[$i]['id'] ?>">
            <tr>
               <!-- <td class="vm">
                  <span><?= $k + 1 ?></span>
               </td> -->
               <td class="vm">
                  削除できません
               </td>
               <td colspan="3" class="l vm">
                  <input type="search" name="[]" id="" class="form-control" placeholder="メモ" value="<?= $tags[$i]['tag_name'] ?>" disabled>
               </td>
            </tr>
         <?php endfor; ?>

         <!-- ユーザーのオリジナル -->
         <?php for ($j = 6; $j < count($tags); $j++) : ?>
            <input type="hidden" name="id[]" id="" class="tagDel" value="<?= $tags[$j]['id'] ?>">
            <tr>
               <!-- <td class="vm">
                  <span><?= $k + 1 ?></span>
               </td> -->
               <td class="vm">
                  <input type="checkbox" name="del[]" id="" value="<?= $tags[$j]['id'] ?>">
               </td>
               <td colspan="3" class="l vm">
                  <?php if (!empty($_SESSION["msg"]["listTag_name"][$j])) : ?>
                     <p class="error">
                        <?= $_SESSION["msg"]["listTag_name"][$j] ?>
                     </p>
                  <?php endif ?>

                  <input type="search" name="tag_name[]" id="" class="form-control" placeholder="メモ" value="<?= $tags[$j]['tag_name'] ?>">
               </td>
            </tr>
         <?php endfor; ?>
      </table>

      <div class="c my-3">
         <input type="submit" name="" id="tagSubmit" class="btn mr-3" value="更新">
         <input type="reset" name="" id="" class="btn mr-3" value="リセット">
         <a href="../" class="btn mr-3">HOME</a>
      </div>
   </form>
</section>