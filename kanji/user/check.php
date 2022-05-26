<?php
require_once("./check_util.php");
?>

<!DOCTYPE html>
<html lang="jp">
<?php include_once("../head.php"); ?>

<body>
   <div id="container">
      <header>
         <!-- <h1 class="c h1">1dey幹事</h1> -->
      </header>
      <?php include_once("../navi.php"); ?>
      <div id="contents">
         <div class="inner">
            <h3 class="c">
               ユーザー設定
            </h3>
            <section id="itemList" class="section c">

               <div class="title c mb-3">更新内容の確認</div>
               <form action="./update.php" method="post" class="mx-4">
                  <!-- トークンの送信 -->
                  <input type="hidden" name="token" value="<?= $token ?>">
                  <input type="hidden" name="id" value="<?= $user['id'] ?>">

                  <table class="table table-hover">
                     <tr>
                        <th class="">ユーザー名</th>
                        <td>
                           <?= $post['user_name'] ?>
                           <input type="hidden" name="user_name" value="<?= $post['user_name'] ?>">
                        </td>
                     </tr>
                     <tr>
                        <th>メールアドレス</th>
                        <td>
                           <?= $post['email'] ?>
                           <input type="hidden" name="email" value="<?= $post['email'] ?>">
                        </td>
                     </tr>
                     <tr>
                        <th>誕生日</th>
                        <td>
                           <?= $post['birthday'] ?>
                           <input type="hidden" name="birthday" value="<?= $post['birthday'] ?>">
                        </td>
                     </tr>
                     <tr>
                        <th>パスワード</th>
                        <td>
                           <?= $post_pass ?>
                           <input type="hidden" name="password" value="<?= $post_pass ?>">
                        </td>
                     </tr>
                  </table>

                  <div class="c">
                     <input type="submit" value="送信" class="btn mr-3">
                     <!-- <button onclick="location.href='./';"> 戻る</button> -->
                     <input type="button" value="戻る" class="btn " onclick="location.href='./';">
                  </div>
               </form>
            </section>
         </div>
         <!-- /#main -->

      </div>
      <!-- /#contents -->
   </div>
   <!-- /#container -->
   <?php require_once("../../unsession.php"); ?>
</body>

</html>