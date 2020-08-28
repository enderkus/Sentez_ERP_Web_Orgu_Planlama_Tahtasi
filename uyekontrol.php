<?php

ob_start();
session_start();

include 'db.php';

$kullaniciadi = $_POST["uyeadi"];
$sifre = $_POST["sifre"];

$uyevarmi = $database->count("Meta_User",[
  "UserName" => $kullaniciadi,
  "Ud_WebSifre" => $sifre,
]);

if ($uyevarmi == 1) {
  $_SESSION['uyeadi'] = $kullaniciadi;

  $yetkikontrol = $database->select("Meta_User",[
    "Ud_WebYetki",
  ],[
    "UserName" => $kullaniciadi,
  ]);

  $_SESSION['yetki'] = $yetkikontrol[0][Ud_WebYetki];


  header("Location:index.php");
} else {
  header("Location:giris.php?durum=hata");
}




 ?>
