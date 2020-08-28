<?php

include 'header.php';
$makineid = $_GET["makineid"];
$sirano = $_GET["sirano"];


$ustsayi = $sirano - 1;

// Üste taşınmasını istediğimiz satırın recid değerini aldık.
$planlamailkid = $database->select("Erp_Planning",[
  "RecId"
],[
  "ResourceId" => $makineid,
  "ItemOrderNo" => $sirano,
]);

// Üstteki mevcut satırın id değerini aldık.
$planlamaikinciid = $database->select("Erp_Planning",[
  "RecId"
],[
  "ResourceId" => $makineid,
  "ItemOrderNo" => $ustsayi,
]);

// Şimdi işlem yapmak istediğimiz satırın ItemOrderNo değerini 1 eksiltip kaydediyoruz.
$satirarttir = $database->update("Erp_Planning",[
  "ItemOrderNo" => $ustsayi,
],[
  "RecId" => $planlamailkid[0]["RecId"],
]);

// şimdi bir üst satırdaki ItemOrderNo değerini değiştirmek istediğimiz satırınki ile değiştiriyoruz.

$satirarttir = $database->update("Erp_Planning",[
  "ItemOrderNo" => $sirano,
],[
  "RecId" => $planlamaikinciid[0]["RecId"],
]);


header("Location:index.php#".$makineid."");

 ?>








<?php
include 'footer.php';
 ?>
