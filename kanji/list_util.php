<?php
// --- 残額用の計算 ---
// 未収残高
$balance = array();

foreach ($details as $key => $val) {
   // 合計金額
   $toTotalPrice = 0;
   // 合計回収額
   $toTotalRecived = 0;
   // 未収残高
   $toBalrance = 0;

   foreach ($val as $k => $v) {
      $toTotalPrice += $v['price'];
      $toTotalRecived += $v['is_recived'];
   }

   // detailが未入力の場合は0で返す
   if (empty($v['price'])) {
      $v['price'] = 0;
   } else {
      $totalPrice[$key] = $v['price'];
   }

   // detailが未入力の場合は0で返す
   if (empty($v['is_recived'])) {
      $v['is_recived'] = 0;
   } else {
      $totalRecived[$key] = $v['is_recived'];
   }

   // 未収残高
   if ($items[$key]['num'] == 1) {
      // 一人の場合は
      $toBalrance = $toTotalPrice - $toTotalRecived;
   } else {
      $toBalrance = $toTotalPrice - $toTotalRecived - ($toTotalPrice / $items[$key]['num']);
   }

   $balance[$key] = $toBalrance;
}
