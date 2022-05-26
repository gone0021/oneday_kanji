$(function () {
   $(".onClose").click(function (e) {
      $("#menubar-s").hide();
      // e.preventDefault();
   });

   // 画面幅が変わった時
   $(window).resize(function () {
      //
   });

   // アコーディオン
   $(".acdTitle").on("click", function () {
      if (!$(this).hasClass('acdOpen')) {
         $(this).addClass("acdOpen");
         $(this).next().slideDown(200);
      } else {
         $(this).removeClass("acdOpen");
         $(this).next().slideUp(200);
      }
   });

   // パスワード再設定ページのアコーディオン
   $(".editPass").on("click", function () {
      if (!$(this).hasClass('acdOpen')) {
         $(this).addClass("acdOpen");
         $(this).next().slideDown(200);
         $(".new_pass").prop("disabled", false);
         $(".new_pass").prop("required", true);
      } else {
         $(this).removeClass("acdOpen");
         $(this).next().slideUp(200);
         $(".new_pass").prop("disabled", true);
         $(".new_pass").prop("required", false);
      }
   });

   // 詳細ページの一括回収アコーディオン
   $("#allRecive").on("click", function () {
      if (!$(this).hasClass('acdOpen')) {
         $(this).addClass("acdOpen");
         $(this).next().slideDown(200);
         $("#reciveNum").prop("disabled", false);
      } else {
         $(this).removeClass("acdOpen");
         $(this).next().slideUp(200);
         $("#reciveNum").prop("disabled", true);
      }
   });

   $("#calcRecive").on("click", function (e) {
      let people = parseInt($("#people").text());
      let reciveNum = $("#reciveNum").val();

      // 入力の人数が設定人数より多ければ処理を中断
      var msg = "回収人数に誤りがあります。"
         + "\n自分も含めていませんか？";
      if (people == 1) {
         // 一人の時のみ超で判定
         if (reciveNum > people) {
            alert(msg);
            return false;
         }
      } else {
         // 2人以上の時は以上で判定
         if (reciveNum >= people) {
            alert(msg);
            return false;
         }
      }

      // バグがないように単価の数をとる
      let oneceNum = $(".onece").length;

      // アイテムがなければアラートを出して処置を中断
      var msg = "計算する投稿がまだありません。";
      if (oneceNum < 1) {
         alert(msg);
         return false;
      }

      for (var i = 0; i < oneceNum; i++) {
         let onece = parseInt($(`#onece${i}`).text().replace(",", ""));
         let calc = reciveNum * onece;

         $(`#isRecived${i}`).val(calc);

      }
      // let oneceNum = $(".onece").text();
      //   console.log(oneceNum);
      var msg = "計算しました。確認して更新してください。\n"
         + "他のページがあれば同様に続けてください。";
      alert(msg);

   });

   // タグ削除のチェックボックス
   // 急がんけど案内作る

   $("#tagSubmit").on("click", function (e) {
      let del = [];
      $("[name='del[]']:checked").each(function () {
         del.push(this.value);
      });
      if (del.length > 0) {
         let msg = "使用しているタグを削除すれば「未使用」に戻ります。\n";
         msg += "よろしいですか？";
         if (!window.confirm(msg)) {
            e.preventDefault();
         }
      }
   });


   // 現状はphpでバリデーションしている
   // アラート出してもいいけどいらん気もしてる

   // --- バリデーション ---
   // ※ セレクト、数字は省略
   // let val_flg;
   // item-title
   // $(".itemTitle").on("blur", function (e) {
   //    let itemTitle = $(this).val().length;
   //    // console.log(itemTitle);
   //    if (itemTitle > 50) {
   //       alert("50文字以内で入力してください。");
   //       val_flg = 1;
   //    } else {
   //       val_flg = 0;
   //    }
   // });

   // // item-date
   // $(".itemDate").on("blur", function (e) {
   //    let itemDate = $(this).val();
   //    let ret = itemDate.split('-');
   //    // console.log(ret);
   //    if (ret['0'] > 3000) {
   //       alert("2000年代で入力してください");
   //       val_flg = 1;
   //    } else {
   //       val_flg = 0;
   //    }
   //    console.log(val_flg);

   // });

   // // detail-memo
   // $(".detailMemo").on("blur", function (e) {
   //    let detailMemo = $(this).val().length;
   //    // console.log(detailMemo);
   //    if (detailMemo > 100) {
   //       alert("100文字以内で入力してください。");
   //       val_flg = 1;
   //    } else {
   //       val_flg = 0;
   //    }
   // });

   // // tag-name
   // $(".tagName").on("blur", function (e) {
   //    let tagName = $(this).val().length;
   //    // console.log(tagName);
   //    if (tagName > 50) {
   //       alert("50文字以内で入力してください。");
   //       val_flg = 1;
   //    } else {
   //       val_flg = 0;
   //    }
   //    console.log(val_flg);
   // });

   // // tag-name
   // $('input[type="reset"]').on("click", function (e) {
   //    val_flg = 0;
   // });

   // // submit
   // $("form").on("submit", function (e) {
   //    if (val_flg == 1) {
   //       alert("入力に不備があります");
   //       return false;
   //    }
   // });



   // // アコーディオン
   // var flg = 0;
   // $(".acdTitle").on("click", function () {
   //    // if (flg == 0) {
   //    if (!$(this).hasClass('acdOpen')) {
   //       $(this).next().slideDown(200);
   //       $(this).addClass("acdOpen");
   //       flg = 1;
   //    } else {
   //       $(this).next().slideUp(200);
   //       $(this).removeClass("acdOpen");
   //       flg = 0;
   //    }
   // });
   // $(".acdTitleOpen").on("click", function () {
   //    // if (flg == 0) {
   //    if (!$(this).hasClass('acdOpen')) {
   //       $(this).next().slideDown(200);
   //       $(this).addClass("acdOpen");
   //       flg = 1;
   //    } else {
   //       $(this).next().slideUp(200);
   //       $(this).removeClass("acdOpen");
   //       flg = 0;
   //    }
   // });


   // // パスワード再設定ページのアコーディオン
   // $(".editPass").on("click", function () {
   //    console.log("click");

   //    if (!$(this).hasClass('acdOpen')) {
   //       $(this).next().slideDown(200);
   //       $(this).addClass("acdOpen");
   //       $(".new_pass").prop("disabled", false);
   //       $(".new_pass").prop("required", true);
   //    } else {
   //       $(this).next().slideUp(200);
   //       $(this).removeClass("acdOpen");
   //       $(".new_pass").prop("disabled", true);
   //       $(".new_pass").prop("required", false);
   //    }
   // });

});