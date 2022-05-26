<?php
require_once("./list_util.php");

// var_dump($remaining);
// echo '<pre>';
// var_dump($details);
// echo '</pre>';

?>

<section id="list" class="section c">
   <div class="title mb-3">詳細</div>

   <div class="c mb-3">
      <h3 class="d-inline mr-4 vm">
         <span id="people">
            <?= $item['num'] ?>
         </span>
         <span>
            人：
         </span>
         <span>
            予算<?= number_format($item['budget']) ?>円
         </span>
      </h3>
      <button type="button" id="allRecive" class="btn acdRecive vm">一括回収</button>
      <div class="acdItem my-3">
         回収人数：
         <input type="number" id="reciveNum" class="simpleForm w75 mr-3" value="1" disabled>
         <button type="button" id="calcRecive" class="btn">自動計算</button>
      </div>
   </div>

   <?php if (!empty($_SESSION["msg"]["list"])) : ?>
      <p class="error">
         <?= $_SESSION["msg"]["list"] ?>
      </p>
   <?php endif ?>

   <form method="POST" action="./list_action.php">
      <input type="hidden" name="token" id="" value="<?= $token ?>">
      <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
      <!-- <table class="c table table-hover"> -->
      <table class="c table">
         <tr>
            <!-- <th class="">No.</th> -->
            <th class="vm">削除</th>
            <th class="vm">タグ名</th>
            <th class="vm">金額 <br>単価 </th>
            <th class="vm">回収金額<br>残額</th>
         </tr>

         <?php foreach ($details  as $k => $v) : ?>
            <input type="hidden" name="id[]" id="id<?= $k ?>" class="id" value="<?= $v['id'] ?>">
            <!-- タグ -->
            <tr>
               <!-- <td class="vm">
                  <span><?= $k + 1 ?></span>
               </td> -->
               <td rowspan="2" class="vm">
                  <input type="checkbox" name="del[]" id="" value="<?= $v['id'] ?>">
               </td>
               <td class="vm">
                  <select name="tag_id[]" id="" class="simpleForm w100">
                     <?php foreach ($tags as $tag) : ?>
                        <option value="<?= $tag['id'] ?>" <?php if ($v['tag_id'] == $tag['id']) echo 'selected'; ?>><?= $tag['tag_name'] ?></option>
                     <?php endforeach ?>
                  </select>
               </td>
               <td class="vm">
                  <p>
                     <!-- 金額 -->
                     <span>
                        <input type="number" name="price[]" id="" class="simpleForm w75" value="<?= $v['price'] ?>">
                     </span>
                     <span>
                        円
                     </span>
                  </p>
                  <!-- 単価 -->
                  <span id="onece<?= $k ?>" class="onece">
                     <!-- <span id="" class="onece"> -->
                     <?= number_format($onece[$k]) ?>
                  </span>
                  <span>
                     円 / 人
                  </span>
               </td>
               <td class="vm">
                  <p>
                     <!-- 回収金額 -->
                     <span>
                        <input type="number" name="is_recived[]" id="isRecived<?= $k ?>" class="simpleForm w75 isRecived" value="<?= $v['is_recived'] ?>">
                     </span>
                     <span>
                        円
                     </span>
                  </p>
                  <!-- 残額 -->
                  <span>
                     残額
                  </span>
                  <span>
                     <?= number_format($remaining[$k]) ?>
                  </span>
                  <span>
                     円
                  </span>
               </td>
               <!-- <td>
                  <textarea name="memo[]" id="" class="memo" cols="30" rows="3"><?= $v['memo'] ?></textarea>
               </td> -->
            </tr>
            <tr>
               <td colspan="3" class="l vm">
                  <?php if (!empty($_SESSION["msg"]["listMemo"][$k])) : ?>
                     <p class="error">
                        <?= $_SESSION["msg"]["listMemo"][$k] ?>
                     </p>
                  <?php endif ?>
                  <input type="search" name="memo[]" id="" class="form-control simpleForm" placeholder="メモ" value="<?= $v['memo'] ?>">
               </td>
            </tr>
         <?php endforeach; ?>
      </table>
      <!-- <th class="">No.</th> -->
      <h3 class="c mb-4">
         <div class="mb-2">合計金額：<?= number_format($totalPrice) .  "円" .  "（一人" . number_format($onceTotal) . " 円）" ?></div>
         <div class="mb-2">回収金額：<?= number_format($totalRecived) . " 円" ?></div>
         <div class="">未収金額：<?= number_format($balance) . " 円" ?></div>
      </h3>

      <div class="c my-3">
         <input type="submit" name="" id="" class="btn mr-3" value="更新">
         <input type="reset" name="" id="" class="btn mr-3" value="リセット">
         <a href="../" class="btn mr-3">HOME</a>
      </div>
   </form>
   <?php echo $pageing->html ?>
   <div class="adSpace"></div>
</section>