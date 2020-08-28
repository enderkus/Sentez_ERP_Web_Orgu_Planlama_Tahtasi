<?php
include 'header.php';

if ($_SESSION['uyeadi']  == "") {
  header("Location:giris.php");
}


$sifre1 = $_POST["yenisifre"];
$sifre2 = $_POST["yenisifre2"];
$uye = $_POST["uyeadi"];

 ?>

<div class="container">
  <div class="row justify-content-md-center">
    <div class="col-8 mt-4 text-center">

      <?php

      if ($sifre1 == $sifre2) {
        $sifreguncelle = $database->update("Meta_User",[
          "Ud_WebSifre" => $sifre1,
        ],[
          "UserName" => $_SESSION["uyeadi"],
        ]);

        echo '<div class="alert alert-success"><h5>Şifreniz başarılı ile değiştirildi  <i class="fa fa-check"></i></h5></div>';
      } else {
        echo '<div class="alert alert-danger"><h5>Yenilemek istediğiniz şifre iki alana da aynı yazılmak zorunda.</h5></div>';
      }


       ?>



    </div>
  </div>
</div>





 <?php
include 'footer.php';
  ?>
