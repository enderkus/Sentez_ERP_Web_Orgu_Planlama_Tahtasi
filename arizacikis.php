<?php
include 'header.php';
$recid = $_GET["recid"];



$arizakapat = $database->update("Erp_ResourceOutOfUse",[
  "EndDate" => date('Y-m-d H:i:s'),
],[
  "RecId" => $recid,
]);


if ($arizakapat) {
  header("Location:makinedurumlari.php");
} else {
  echo '<div class="container">
    <div class="row mt-4">
      <div class="col-12">
        <div class="alert alert-danger">
          HAY AKASİ ! BİRŞEYLER TERS GİTTİ LÜTFEN DAHA SONRA TEKRAR DENEYİN YA DA BİLGİ İŞLEM BİRİMİNİ HABER VERİN.
        </div>
      </div>
    </div>
  </div>';
}


 ?>








 <?php
include 'footer.php';
  ?>
