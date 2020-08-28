<?php

include 'header.php';
$woi = $_GET["woi"];
$workorderno = $_GET["workorderno"];
$workorderitem = $_GET["workorderitem"];

$isemricikis = $database->update("Erp_WorkOrderProduction",[
  "InOut" => 2,
],[
  "WorkOrderItemId" => $woi,
  "InOut" => 1
]);

 ?>


<div class="container">
  <div class="row">
    <div class="col-12 mt-4 text-center">
      <div class="alert alert-success">
        <?php
        if ($isemricikis) {
          echo "ÇIKIŞ YAPILAN İŞ EMRi :".$workorderno."-".$workorderitem;
        } else {
          echo "ÇIKIŞ YAPARKEN BİR HATAYLA KARŞILAŞILDI !";
        }

         ?>

         <a href="index.php" class="btn btn-success btn-block">ANA SAYFAYA DÖN</a>


      </div>
    </div>
  </div>
</div>




 <?php

include 'footer.php';

 ?>
