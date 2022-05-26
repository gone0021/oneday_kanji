<?php
require_once 'index_util.php';
?>

<!DOCTYPE html>
<html lang="ja">
<?php include_once("./head.php"); ?>

<body>
   <div id="container">
      <header>
         <!-- <h1 class="c h1">1dey幹事</h1> -->
      </header>
      <?php include_once("./navi.php"); ?>
      <div id="contents">
         <div class="inner">
            <h3 class="c">
               アイテム一覧
            </h3>
            <?php if (!empty($user)) {
               require_once("./new.php");
            }
            ?>

            <?php require_once("./list.php"); ?>
         </div>
         <!--/.inner-->

      </div>
      <!--/#contents-->

   </div>
   <!--/#container-->
   <?php require_once("../unsession.php"); ?>

</body>

</html>