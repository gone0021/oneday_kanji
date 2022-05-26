<?php
require_once('../App/config.php');
?>

<!DOCTYPE html>
<html lang="ja">
<?php include_once("./head.php"); ?>

<body>
   <div id="app">
      <div id="container">
         <?php include_once($root . "/navi.php"); ?>

         <div id="contents">
            <div class="inner">
               <section id="weight">
                  <h2 class="title">WARIKAN</h2>
                  <h3>簡易割り勘</h3>

                  <!-- 身長 -->
                  <div class="form-group col-6 mx-auto mt-3">
                     <label for="testNum">人数</label>
                     <input type="number" name="testNum" value="0" id="testNum" class="form-control" placeholder="人">
                  </div>

                  <!-- 体重 -->
                  <div class="form-group col-6 mx-auto">
                     <!-- 入力フォーム -->
                     <label for="testPrice">金額</label>
                     <input type="number" name="testPrice" value="0" id="testPrice" class="form-control" placeholder="円">
                  </div>

                  <h3 class="">一人あたり：
                     <span id="calcPrice"></span>
                  </h3>

                  <!-- ※ボタン -->
                  <div class="c mt-4">
                     <button type="button" id="calc" class="btn mr-3">計算</button>
                     <button type="button" id="reset" class="btn mr-3">リセット</button>
                     <a href="../" class="btn">戻る</a>
                  </div>

               </section>

            </div>
            <!-- /#main -->

         </div>
         <!-- /#contents -->
         <?php include_once($root . "/footer.php"); ?>

      </div>
      <!-- /#container -->
      <!--メニュー開閉ボタン-->
      <div id="menubar_hdr" class="close"></div>
   </div>
   <!-- /#app -->
</body>

</html>