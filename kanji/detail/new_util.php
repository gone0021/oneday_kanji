<?php


// バリデーションエラーが返った時に保存するsession
$tagId = "";
if (!empty($_SESSION['post']['tag_id'])) {
   $tagId = (int)$_SESSION['post']['tag_id'];
}
$price = "";
if (!empty($_SESSION['post']['price'])) {
   $price = (int)$_SESSION['post']['price'];
}

$isRecived = "";
if (!empty($_SESSION['post']['is_recived'])) {
   $isRecived = (int)$_SESSION['post']['is_recived'];
}

$memo = "";
if (!empty($_SESSION['post']['memo'])) {
   $memo = (string)$_SESSION['post']['memo'];
}
