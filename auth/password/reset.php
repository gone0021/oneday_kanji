<?php
// 共通ファイル
require_once("../../App/config.php");

$_SESSION['token'] = $token;

?>

<!DOCTYPE html>
<html lang="ja">
<?php include_once($root . "/head.php"); ?>

<body>
   <div id="app">
      <div id="container">
         <?php include_once($root . "/navi.php"); ?>

         <div id="contents">
            <div class="inner">
               <section id="entry">
                  <h2 class="title">Reset Password</h2>
                  <h3>パスワードの再設定</h3>

                  <div class="mt-2 mb-4 c">メールアドレス：<?= $_SESSION["email"] ?></div>

                  <!-- エラーメッセージ -->
                  <?php if (!empty($_SESSION["msg"]["reset_pass"])) : ?>
                     <p class="error">
                        <?= $_SESSION["msg"]["reset_pass"] ?>
                     </p>
                  <?php endif ?>
                  <?php if (!empty($_SESSION["msg"]["error"])) : ?>
                     <p class="error">
                        <?= $_SESSION["msg"]["error"] ?>
                     </p>
                  <?php endif ?>

                  <!-- 送信フォーム -->
                  <form action="./comp.php" method="post" class="">
                     <input type="hidden" class="ws" name="token" value="<?= $token ?>">

                     <!-- ※パスワード -->
                     <div class="form-group col-6 mx-auto">
                        <!-- バリデーション -->
                        <?php if (isset($_SESSION['msg']['pass1'])) : ?>
                           <p class="error"><?= $_SESSION['msg']['pass1'] ?></p>
                        <?php endif ?>
                        <label for="pass1">パスワード（半角英数字で8文字以上）</label>
                        <!-- 入力フォーム -->
                        <input type="password" name="pass1" id="pass1" class="form-control">
                     </div>

                     <!-- ※確認用パスワード（送信対象） -->
                     <div class="form-group col-6 mx-auto">
                        <!-- バリデーション -->
                        <?php if (isset($_SESSION['msg']['pass2'])) : ?>
                           <p class="error"><?= $_SESSION['msg']['pass2'] ?></p>
                        <?php endif ?>
                        <label for="pass2">パスワード（確認用）</label>
                        <!-- 入力フォーム -->
                        <input type="password" name="pass2" id="pass2" class="form-control">
                     </div>
                     <div class="c mb-5">
                        <input type="submit" value="送信" class="btn mr-5" @click="onRegCheck()">
                        <input type="reset" value="リセット" class="btn">
                     </div>
                  </form>

                  <!-- <home-home></home-home> -->
               </section>

            </div>
            <!-- /#main -->

         </div>
         <!-- /#contents -->
         <!-- <div class="push"></div> -->
         <?php include_once($root . "/footer.php"); ?>

      </div>
      <!-- /#container -->
      <!--メニュー開閉ボタン-->
      <div id="menubar_hdr" class="close"></div>

   </div>
   <!-- /#app -->
</body>

</html>