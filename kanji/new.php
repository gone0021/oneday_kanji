<?php
require_once 'new_util.php';
?>

<section id="new" class="section c">
   <?php if (!empty($_SESSION["msg"]["new"])) : ?>
      <p class="error">
         <?= $_SESSION["msg"]["new"] ?>
      </p>
   <?php endif ?>

   <div class="title acdTitle mb-3">新規登録</div>
   <div class="acdItem">
   <!-- <div> -->
      <form action="./new_action.php" method="POST">
         <input type="hidden" name="token" value="<?= $token ?>">

         <div class="mb-3">
            <div class="mb-3">
               <?php if (!empty($_SESSION["msg"]["newTitle"])) : ?>
                  <p class="error">
                     <?= $_SESSION["msg"]["newTitle"] ?>
                  </p>
               <?php endif ?>
               <input type="search" name="title" id="" class="form-control" placeholder="タイトル（50文字まで）" value="<?= $title ?>" required>
            </div>

            <div class="mb-3">
               <?php if (!empty($_SESSION["msg"]["newDate"])) : ?>
                  <p class="error">
                     <?= $_SESSION["msg"]["newDate"] ?>
                  </p>
               <?php endif ?>
               <input type="date" name="date" id="" class="form-control" placeholder="" value="<?= $date ?>">
            </div>

            <div class="mb-3">
               <?php if (!empty($_SESSION["msg"]["newNum"])) : ?>
                  <p class="error">
                     <?= $_SESSION["msg"]["newNum"] ?>
                  </p>
               <?php endif ?>
               <input type="number" name="num" id="" class="form-control" placeholder="人数（自分も含めて入力）" value="<?= $num ?>">
            </div>

            <div class="mb-3">
               <?php if (!empty($_SESSION["msg"]["newBudget"])) : ?>
                  <p class="error">
                     <?= $_SESSION["msg"]["newBudget"] ?>
                  </p>
               <?php endif ?>
               <input type="number" name="budget" id="" class="form-control" placeholder="予算" value="<?= $budget ?>">
            </div>

            <div>
               <input type="submit" value="登録" class="btn mr-3">
               <input type="reset" value="リセット" class="btn">
            </div>
         </div>
      </form>
   </div>
</section>