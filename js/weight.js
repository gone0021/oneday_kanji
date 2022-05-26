// --- items全体 ---
$(function () {
   // 計算ボタン
   $("#calc").on("click", function () {
      let num = $("#testNum").val();
      let price = $("#testPrice").val();

      let ret = price / num;

      if (!num || !price) {
         alert("値を入力してください");
      } else {
         $("#calcPrice").text(ret + "円");
      }

   });

   // リセット用の値
   let rh = $("#testNum").val();
   let rw = $("#testNum").val();
   // リセットボタン
   $("#reset").on("click", function () {
      $("#testNum").val(0);
      $("#testPrice").val(0);
   });


});

