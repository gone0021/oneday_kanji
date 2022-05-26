<?php
require_once ("./index_util.php");
?>

<!DOCTYPE html>
<html lang="ja">
<?php require_once("../head.php"); ?>

<body>
   <div id="container">
      <header>
      </header>
      <?php require_once("../navi.php"); ?>

      <div id="contents">
         <div class="inner">
            <h3 class="c">
               ユーザー設定
            </h3>
            <section id="itemList" class="section c">

               <div class="title mb-3">ユーザー情報</div>
               <!-- エラーメッセージ -->
               <?php if (!empty($_SESSION["msg"]["err"])) : ?>
                  <p class="error">
                     <?= $_SESSION["msg"]["err"] ?>
                  </p>
               <?php endif ?>
               <?php if (!empty($_SESSION["msg"]["setting"])) : ?>
                  <p class="error">
                     <?= $_SESSION["msg"]["setting"] ?>
                  </p>
               <?php endif ?>

               <!-- 送信フォーム -->
               <form action="./check.php" method="post">
                  <!-- トークンの送信 -->
                  <input type="hidden" name="token" value="<?= $token ?>">

                  <!-- ユーザー名 -->
                  <div class="form-group col-6 mx-auto mt-3">
                     <!-- バリデーション -->
                     <?php if (isset($_SESSION['msg']['user_name'])) : ?>
                        <p class="error"><?= $_SESSION['msg']['user_name'] ?></p>
                     <?php endif ?>
                     <!-- 入力フォーム -->
                     <label for="user_name">ユーザー名</label>
                     <input type="text" name="user_name" value="<?= $name ?>" id="user_name" class="form-control" placeholder="ユーザー名" autocomplete="off" required>
                  </div>

                  <!-- メールアドレス -->
                  <div class="form-group col-6 mx-auto">
                     <!-- バリデーション -->
                     <?php if (isset($_SESSION['msg']['email'])) : ?>
                        <p class="error"><?= $_SESSION['msg']['email'] ?></p>
                     <?php endif ?>
                     <!-- 入力フォーム -->
                     <label for="email">メールアドレス</label>
                     <input type="text" name="email" value="<?= $email ?>" id="email" class="form-control" placeholder="メールアドレス" autocomplete="off" required>
                  </div>

                  <!-- 誕生日 -->
                  <div class="form-group col-6 mx-auto">
                     <!-- バリデーション -->
                     <?php if (isset($_SESSION['msg']['birthday'])) : ?>
                        <p class="error"><?= $_SESSION['msg']['birthday'] ?></p>
                     <?php endif ?>
                     <!-- 入力フォーム -->
                     <label for="birthday">誕生日</label>
                     <input type="date" name="birthday" value="<?= $birthday ?>" id="birthday" class="form-control" autocomplete="off" required>
                  </div>

                  <!-- ※パスワード -->
                  <div class="form-group col-6 mx-auto mb-4">
                     <!-- バリデーション -->
                     <?php if (isset($_SESSION['msg']['check'])) : ?>
                        <p class="error"><?= $_SESSION['msg']['check'] ?></p>
                     <?php endif ?>
                     <!-- 入力フォーム -->
                     <label for="pass">現在のパスワード</label>
                     <input type="password" name="pass" id="pass" class="form-control" placeholder="半角英数字で8文字以上" autocomplete="off" required value="">
                  </div>


                  <!-- バリデーション -->
                  <?php if (isset($_SESSION['msg']['pass2'])) : ?>
                     <p class="error c mt-4">新しいパスワード：<?= $_SESSION['msg']['pass2'] ?></p>
                  <?php endif ?>
                  <div class="title editPass mb-3">
                     パスワードを変更する場合
                  </div>
                  <div class="acdItem">
                     <!-- ※新しいパスワード -->
                     <div class="form-group col-6 mx-auto">
                        <!-- バリデーション -->
                        <?php if (isset($_SESSION['msg']['pass1'])) : ?>
                           <p class="error"><?= $_SESSION['msg']['pass1'] ?></p>
                        <?php endif ?>
                        <!-- 入力フォーム -->
                        <label for="pass1">新しいパスワード</label>
                        <input type="password" name="pass1" id="pass1" class="form-control new_pass" placeholder="半角英数字で8文字以上" autocomplete="off" disabled>
                     </div>

                     <!-- ※確認用パスワード（送信対象） -->
                     <div class="form-group col-6 mx-auto">
                        <!-- バリデーション：上部に移動 -->
                        <!-- 入力フォーム -->
                        <label for="pass2">パスワード（確認用）</label>
                        <input type="password" name="pass2" id="pass2" class="form-control new_pass" placeholder="確認用" autocomplete="off" disabled>
                     </div>
                  </div>

                  <!-- ※ボタン -->
                  <div class="c mt-4">
                     <input type="submit" value="確認" class="btn mr-3" @click="onRegCheck()">
                     <input type="reset" value="リセット" class="btn mr-3">
                     <!-- <a href="<?= $url . "/divers" ?>/" class="btn">戻る</a> -->
                     <a href="../" class="btn">戻る</a>
                  </div>

               </form>
            </section>
         </div>

      </div>
      <!-- /#main -->

   </div>
   <!-- /#contents -->

   </div>
   <!-- /#container -->
   <?php require_once("../../unsession.php"); ?>
</body>

</html>