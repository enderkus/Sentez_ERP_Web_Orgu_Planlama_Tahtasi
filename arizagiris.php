<?php
include 'header.php';
$arizakodu = $_GET["ariza"];
$makineid = $_GET["makid"];

$arizagiris = $database->insert("Erp_ResourceOutOfUse",[
  "ResourceId" => $makineid,
  "StartDate" => date('Y-m-d H:i:s'),
  "ReasonId" => $arizakodu,

]);

if ($arizagiris) {
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
