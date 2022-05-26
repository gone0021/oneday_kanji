<?php
// バリデーションエラーが返った時に保存するsession
$title = "";
if (!empty($_SESSION['post']['title'])) {
   $title = $_SESSION['post']['title'];
}

$date = date("Y-m-d");
if (!empty($_SESSION['post']['date'])) {
   $date = (string)$_SESSION['post']['date'];
}

$num = "";
if (!empty($_SESSION['post']['num'])) {
   $num = (int)$_SESSION['post']['num'];
}

$budget = "";
if (!empty($_SESSION['post']['budget'])) {
   $budget = (int)$_SESSION['post']['budget'];
}
