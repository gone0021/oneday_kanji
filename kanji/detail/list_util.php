<?php
// --- 計算 ---
// 単価（合計金額ー人数）
$onece = array();
// 合計金額
$totalPrice = 0;
// 合計回収額
$totalRecived = 0;

// 残額（合計金額ー単価ー回収金額）
$remaining = array();

// ページング内の計算：個々の単価と一括回収（js）の計算で使用
foreach ($details as $k => $v) {
   // 単価
   $onece[$k] = $v['price'] / $item['num'];

   // 残額
   if ($item['num']  == 1) {
      // 一人の場合
      $remaining[$k] = $v['price'] - $v['is_recived'];
   } else {
      $remaining[$k] = $v['price'] - $onece[$k] - $v['is_recived'];
   }
}

// 全値での計算
foreach ($allDetails as $k => $v) {   
   $totalPrice += $v['price'];
   $totalRecived += $v['is_recived'];
}

// 未収残高
$balance = 0;
$onceTotal = 0;
if ($item['num'] == 1) {
   // 一人の場合
   $balance = $totalPrice - $totalRecived ;
} else {
   $onceTotal = $totalPrice / $item['num'];

   $balance = $totalPrice - $totalRecived - ($totalPrice / $item['num']);
}
