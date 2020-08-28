<?php
include 'header.php';
$recids = $_POST["recids"];
$makineid = $_POST["makineid"];
$makinekodu = $_POST["makinekodu"];
 ?>

<div class="container">
  <div class="row justify-content-md-center">
    <div class="col-6 text-center">
      <div class="alert alert-success">
        <?php




        foreach ($recids as $rids) {

        $sirabilgileri = $database->select("Erp_WorkOrderItem",[
          "WorkOrderId",
          "RecipeId",
          "LabRecipeId",
          "Quantity",
        ],[
          "RecId" => $rids,
        ]);


        $planlamaekle = $database->insert("Erp_Planning",[
          "PlanningType" => 2,
          "WorkOrderId" => $sirabilgileri[0]['WorkOrderId'],
          "WorkOrderItemId" => $rids,
          "ResourceId" => $makineid,
          "Start" => date('Y.m.d H:i:s'),
          "Quantity" => $sirabilgileri[0]['Quantity'],
        ]);


        }

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


         ?>

         <div class="alert alet-success">
           SATIRLAR BAŞARIYLA EKLENDİ.
         </div>

         <a href="index.php#<?= $makineid ?>" class="btn btn-success btn-block">ANA SAYFAYA DÖN</a>

      </div>
    </div>
  </div>
</div>


 <?php
include 'footer.php'
  ?>
