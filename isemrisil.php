<?php 
ob_start();

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>


    <div class="container">
      <div class="row">
        <div class="col-12 text-center">
          <?php

          include 'db.php';
          $workorderitemid = $_GET["workorderitemid"];
          $makineid = $_GET["makineid"];

          $sil = $database->delete("Erp_Planning",[
            "WorkOrderItemId" => $workorderitemid,
          ]);


          $siralamakomutu = $database->select("Erp_Planning",[
            "RecId",
            "WorkOrderItemId"
          ],[
            "ResourceId" => $makineid,
          ]);


          $calisan = 0;
          foreach ($siralamakomutu as $sk) {
            $calisankontrol = $database->count("Erp_WorkOrderProduction",[
              "WorkOrderItemId" => $sk['WorkOrderItemId'],
              "InOut" => 1,
            ]);
            $calisan = $calisan + $calisankontrol;
          }


        if ($calisan == 0) {
          $i = 1;

         $yuklupartiler = $database->query("SELECT RecId FROM Erp_Planning WHERE ResourceId = '".$makineid."'");
        foreach ($yuklupartiler as $yp) {
          $siralamaguncelle = $database->update("Erp_Planning",[
            "ItemOrderNo" => $i,
          ],[
            "RecId" => $yp["RecId"],
          ]);
          $i++;
        }


        } else if ($calisan > 0) {
         $i = 2;
         $yuklupartiler2 = $database->query("SELECT RecId,WorkOrderItemId FROM Erp_Planning WHERE ResourceId = '".$makineid."'");
         foreach ($yuklupartiler2 as $yp2) {

           $calisanikincikontrol = $database->query("SELECT COUNT(RecId) FROM Erp_WorkOrderProduction WHERE WorkOrderItemId = '".$yp2["WorkOrderItemId"]."'");
           if ($calisanikincikontrol == 1) {
             $siralamabirinci = $database->update("Erp_Planning",[
               "ItemOrderNo" => 1,
             ],[
               "RecId" => $yp2["RecId"],
             ]);
           } else {
             $arttiraraksirala = $database->update("Erp_Planning",[
               "ItemOrderNo" => $i,
             ],[
               "RecId" => $yp2["RecId"],
             ]);
             $i++;
           }


         }
        }

          if ($sil) {
            echo '
            <h3>SİLME İŞLEMİ BAŞARILI YÖNLENDİRİLİYORSUNUZ...</h3>
            <div class="progress">
            <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
            </div>';
            header("Location:index.php#".$makineid."");
          }

          ?>
        </div>
      </div>
    </div>



    <script src="js/jq.slim.js"></script>
    <script src="js/popper.min.js" ></script>
    <script src="js/bs.min.js"></script>
  </body>
</html>
