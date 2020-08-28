<?php
include 'header.php';
 ?>

<div class="container-fluid mb-4">
  <div class="row">
<?php
$sorgu = $database->query("SELECT RecId, ResourceCode, Explanation FROM Erp_Resource WHERE ResourceCode LIKE 'OR%' ORDER BY ResourceCode")->fetchAll();

foreach ($sorgu as $s) {

  $orgrungetir = $database->select("OrguRun","*",[
    "ResourceId" => $s["RecId"],
  ]);

$arizakontrol = $database->query("SELECT COUNT(RecId) FROM Erp_ResourceOutOfUse WHERE ResourceId = '".$s["RecId"]."' AND EndDate IS NULL")->fetchAll();

if ($arizakontrol[0][0] == 1) {
  $arizakodu = $database->query("SELECT * FROM Erp_ResourceOutOfUse WHERE ResourceId = '".$s["RecId"]."' AND EndDate IS NULL")->fetchAll();
  $arizaid = $arizakodu[0]["ReasonId"];
  $arizaaciklamasi = $database->select("Erp_ResourceOutOfUseReason","Explanation",[
    "RecId" => $arizaid,
  ]);

  $arizarecid = $arizakodu[0]["RecId"];


}



  @$orulecek = $orgrungetir[0]["Quantity"] - $orgrungetir[0]["Tartim"];

    if (@$orgrungetir[0]["WorkOrderNo"] != "") {
      echo '<div class="col-2 mt-4">
      <div class="card">';
        if ($arizakontrol[0][0] == 1) {
          echo '<div class="card-header bg-dark text-white text-center">';

        } else {
          echo '<div class="card-header bg-success text-white text-center">';
        }

         echo '<b>'.$s["ResourceCode"].'</b>
        </div>';
    } else {
      echo '<div class="col-2 mt-4">
      <div class="card">';
      if ($arizakontrol[0][0] == 1) {
        echo '<div class="card-header bg-dark text-white text-center">';

      } else {
        echo '<div class="card-header text-center">';
      }
         echo '<b>'.$s["ResourceCode"].'</b>
        </div>';
    }





    if (@$orgrungetir[0]["Tartim"] >= @$orgrungetir[0]["Quantity"] && @$orgrungetir[0]["Quantity"] != "") {
      if ($arizakontrol[0][0] == 1) {
        echo '<div class="card-body bg-secondary text-center">';
        echo '<div class="alert alert-danger mb-2">'.$arizaaciklamasi[0].'</div>';
        echo '<a href="arizacikis.php?recid='.$arizarecid.'" class="btn btn-success btn-block mb-2">ARIZA ÇIKIŞI</a>';
      } else {
        echo '<div class="card-body bg-warning text-center">';
        echo '<div class="dropdown mb-2">
  <button class="btn btn-secondary btn-block dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    ARIZA GİRİŞ
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="arizagiris.php?ariza=1&makid='.$s["RecId"].'">MEKANİK ARIZA</a>
    <a class="dropdown-item" href="arizagiris.php?ariza=2&makid='.$s["RecId"].'">İPLİK BEKLİYOR</a>
    <a class="dropdown-item" href="arizagiris.php?ariza=3&makid='.$s["RecId"].'">OKEY BEKLİYOR</a>
    <a class="dropdown-item" href="arizagiris.php?ariza=4&makid='.$s["RecId"].'">ELEMAN YOK</a>
  </div>
</div>';
      }

    } else {
      if ($arizakontrol[0][0] == 1) {
        echo '<div class="card-body bg-secondary text-center">';
          echo '<div class="alert alert-danger mb-2">'.$arizaaciklamasi[0].'</div>';
          echo '<a href="arizacikis.php?recid='.$arizarecid.'" class="btn btn-success btn-block mb-2">ARIZA ÇIKIŞI</a>';

      } else {
      echo '<div class="card-body text-center">';
      echo '<div class="dropdown mb-2">
<button class="btn btn-secondary btn-block dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
  ARIZA GİRİŞ
</button>
<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
  <a class="dropdown-item" href="arizagiris.php?ariza=1&makid='.$s["RecId"].'">MEKANİK ARIZA</a>
  <a class="dropdown-item" href="arizagiris.php?ariza=2&makid='.$s["RecId"].'">İPLİK BEKLİYOR</a>
  <a class="dropdown-item" href="arizagiris.php?ariza=3&makid='.$s["RecId"].'">OKEY BEKLİYOR</a>
  <a class="dropdown-item" href="arizagiris.php?ariza=4&makid='.$s["RecId"].'">ELEMAN YOK</a>
</div>
</div>';
      }
    }



      echo ' <p class="alert alert-secondary"><b>'.@$orgrungetir[0]["WorkOrderNo"].'-'.@$orgrungetir[0]["ItemOrderNo"].'</b></p>
        <p>'.(@$orgrungetir[0]["MusteriAdi"] == "" ? "-": @$orgrungetir[0]["MusteriAdi"]).'</p>
        <p>'.(@$orgrungetir[0]["InventoryName"] == "" ? "-" : @$orgrungetir[0]["InventoryName"]).'</p>

        <div class="kapsayici">
          <div class="container">
            <div class="row">


            <div class="col-6 text-left">
              S.MiKTARI :
            </div>

            <div class="col-6 text-right">
              '.@number_format($orgrungetir[0]["Quantity"],3,'.',',').' KG
            </div>

            <div class="col-6 text-left">
              ÖRÜLEN :

            </div>



            <div class="col-6 text-right">
              '.@number_format($orgrungetir[0]["Tartim"],3,'.',',').' KG
            </div>

            <div class="col-6 text-left">
             ÖRÜLECEK :
            </div>

            <div class="col-6 text-right">
             '.@$orulecek.'KG
            </div>
            </div>
          </div>




        </div>
      </div>
    </div>
  </div>';
}


 ?>




  </div>
</div>

<?php
include 'footer.php';
 ?>
