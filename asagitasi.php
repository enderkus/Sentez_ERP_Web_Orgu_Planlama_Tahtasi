<?php

include 'header.php';
$makineid = $_GET["makineid"];
$sirano = $_GET["sirano"];


$altsira = $sirano - 1;

// Mevcut satırın RecId değerini alıyoruz.
$mevcutsatirrecid = $database->select("Erp_Planning",[
  "RecId"
],[
  "ResourceId" => $makineid,
  "ItemOrderNo" => $sirano,
]);



// Bir alttaki satırın RecId değerini arıyoruz.
$altsatirrecid = $database->select("Erp_Planning",[
  "RecId"
],[
  "ResourceId" => $makineid,
  "ItemOrderNo" => $altsira,
]);

$altsatirrecid[0]["RecId"];


$mevcutsatirguncelle = $database->update("Erp_Planning",[
  "ItemOrderNo" => $altsira,
],[
  "RecId" => $mevcutsatirrecid[0]["RecId"],
]);

$altsatirguncelle = $database->update("Erp_Planning",[
  "ItemOrderNo" => $sirano,
],[
  "RecId" => $altsatirrecid[0]["RecId"],
]);


header("Location:index.php#".$makineid."");

 ?>








<?php
include 'footer.php';
 ?>
