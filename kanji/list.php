<?php
require_once 'list_util.php';
?>

<section id="list" class="section c">
   <div class="title c mb-3">予定一覧</div>

   <?php if (!empty($_SESSION["msg"]["list"])) : ?>
      <p class="error">
         <?= $_SESSION["msg"]["list"] ?>
      </p>
   <?php endif ?>

   <form method="POST" action="./list_action.php">
      <input type="hidden" name="token" id="" value="<?= $token ?>">
      <table class="table mb-4">
         <tr>
            <th rowspan="2" class="vm c">削除</th>
            <th class="vm c">タイトル/日付</th>
            <th class="vm c">人数<br>予算</th>
            <th colspan="1"></th>
         </tr>

         <tbody>
            <?php foreach ($items  as $key => $val) : ?>
               <input type="hidden" name="id[]" id="" value="<?= $val['id'] ?>">
               <tr>
                  <!-- 削除 -->
                  <td class="vm c" rowspan="2">
                     <input type="checkbox" name="del[]" id="" class="w25" value="<?= $val['id'] ?>">
                  </td>

                  <td class="vm c">
                     <!-- タイトル -->
                     <?php if (!empty($_SESSION["msg"]["listTitle"][$key])) : ?>
                        <p class="error">
                           <?= $_SESSION["msg"]["listTitle"][$key] ?>
                        </p>
                     <?php endif ?>
                     <p>
                        <input type="search" name="title[]" id="" class="simpleForm itemTitle w150" value="<?= $val['title'] ?>">
                     </p>

                     <!-- 日付 -->
                     <?php if (!empty($_SESSION["msg"]["listDate"][$key])) : ?>
                        <p class="error">
                           <?= $_SESSION["msg"]["listDate"][$key] ?>
                        </p>
                     <?php endif ?>
                     <p>
                        <input type="date" name="date[]" id="" class="simpleForm itemDate w150" value="<?= $val['date'] ?>">
                     </p>

                  </td>

                  <td class="vm c">
                     <!-- 人数 -->
                     <p>
                        <input type="number" name="num[]" id="" class="simpleForm w75" value="<?= $val['num'] ?>"> &emsp;人
                     </p>
                     <!-- 予算 -->
                     <p>
                        <input type="number" name="budget[]" id="" class="simpleForm w75" value="<?= $val['budget'] ?>">&emsp;円
                     </p>
                  </td>

                  <td class="vm c" rowspan="2">
                     <span class=""><a href="./detail/index.php?item_id=<?= $val['id'] ?>">詳細</a></span>
                  </td>
               </tr>
               <tr>
                  <!-- 未収金額 -->
                  <td class="vm c" colspan="2">
                     <span>未収残高：</span>
                     <span><?= number_format($balance[$key]) ?>
                     </span>
                     <span>
                        円
                     </span>
                  </td>
               </tr>
            <?php endforeach; ?>
         </tbody>
      </table>
      <div class="c mb-4">
         <input type="submit" name="" id="" class="btn mr-3" value="更新">
         <input type="reset" name="" id="" class="btn mr-3" value="リセット">
      </div>
   </form>
   <div class="">
      <?php echo $pageing->html ?>
   </div>
   <div class="adSpace"></div>
</section>