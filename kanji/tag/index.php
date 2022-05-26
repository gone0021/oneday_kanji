   <?php
require_once 'index_util.php';
?>

<!DOCTYPE html>
<html lang="ja">
<?php require_once("../head.php"); ?>

<body>
   <div id="container">
      <header>
      </header>
      <?php include_once("../navi.php"); ?>
      <div id="contents">
         <div class="inner">
            <h3 class="c">
               タグ編集
            </h3>
            <?php require_once("./new.php"); ?>
            <?php require_once("./list.php"); ?>
         </div>
         <!--/.inner-->

      </div>
      <!--/#contents-->

   </div>
   <!--/#container-->
   <?php require_once("../../unsession.php"); ?>

</body>

</html>