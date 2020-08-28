<?php

include 'header.php';
$makineid = $_GET["makineid"];
$sirano = $_GET["sirano"];


$satirrecid = $database->select("Erp_Planning",[
  "RecId"
],[
  "ResourceId" => $makineid,
  "ItemOrderNo" => $sirano,
]);


$satirid = $satirrecid[0]["RecId"];

// Şimdi tüm satırları dizi izine alıyoruz.

$tumsatirlar = $database->select("Erp_Planning","RecId",[
  "ResourceId" => $makineid,
]);

$satirlarisay = $database->count("Erp_Planning","RecId",[
  "ResourceId" => $makineid,
]);


$tumsatirlar = array_diff($tumsatirlar,array($satirid));

// En alta taşımak istediğimiz satıra toplam kayıt sayısının değerini verdik.
$satirorderguncelle = $database->update("Erp_Planning",[
  "ItemOrderNo" => $satirlarisay,
],[
  "RecId" => $satirid,
]);

// Diğer satırları şimdi tekrar order ediyoruz.
$i=1;
foreach ($tumsatirlar as $ts) {
  $satirlariorderet = $database->update("Erp_Planning",[
    "ItemOrderNo" => $i,
  ],[
    "RecId" => $ts,
  ]);

  $i++;
}


header("Location:index.php#".$makineid."");

 ?>
