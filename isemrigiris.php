<?php
include 'header.php';

$parti = $_GET["parti"];
$sira = $_GET["sira"];
$woi = $_GET["woi"];
$makineid = $_GET["makineid"];
$miktar = $_GET["miktar"];
$makkod = $_GET["makkod"];
 ?>

<div class="container">
  <div class="row">
    <div class="col-12 mt-4">
      <div class="alert alert-success text-center">
        <?php

        $calisankontrol = $database->query("SELECT RecId FROM Erp_WorkOrderProduction WHERE ResourceId = '".$makineid."' AND InOut = 1")->fetchAll();
        @$calisansonuc = $calisankontrol[0]['RecId'];

        if ($calisansonuc != "") {
          $isemricikis = $database->update("Erp_WorkOrderProduction",[
            "InOut" => 2,
          ],[
            "WorkOrderItemId" => $calisansonuc,
            "InOut" => 1
          ]);

          $isekle = $database->insert("Erp_WorkOrderProduction",[
            "WorkOrderItemId" => $woi,
            "ProductionType" => 1,
            "ProductionSubType" => 1,
            "ProcessId" => 1,
            "StartEmployeeId" => 47,
            "ResourceId" => $makineid,
            "InOut" => 1,
            "SourceType" => 1,
            "StartProductionDate" => date('Y-m-d'),
            "StartProductionTime" => "1899-12-30 ".date('H:i:s'),
            "StartQuantity" => $miktar,
            "WorkOrderItemOrderNo" => $sira,
            "InsertedAt" => date('Y-m-d H:i:s'),
            "InsertedBy" => 47,
          ]);

          echo "ÇALIŞAN İŞ EMRİNDEN ÇIKIŞ YAPILARAK : ".$parti."-".$sira." İÇİN GİRİŞ YAPILDI";


        } else {
          $isekle = $database->insert("Erp_WorkOrderProduction",[
            "WorkOrderItemId" => $woi,
            "ProductionType" => 1,
            "ProductionSubType" => 1,
            "ProcessId" => 1,
            "StartEmployeeId" => 47,
            "ResourceId" => $makineid,
            "InOut" => 1,
            "SourceType" => 1,
            "StartProductionDate" => date('Y-m-d'),
            "StartProductionTime" => "1899-12-30 ".date('H:i:s'),
            "StartQuantity" => $miktar,
            "WorkOrderItemOrderNo" => $sira,
            "InsertedAt" => date('Y-m-d H:i:s'),
            "InsertedBy" => 47,
          ]);
          echo "BELİRTİLEN : ".$parti."-".$sira." İÇİN GİRİŞ YAPILDI";
        }



        ?>
        <a href="index.php#<?= $makineid ?>" class="btn btn-success btn-block">ANA SAYFAYA DÖN</a>
      </div>
    </div>
  </div>
</div>


 <?php
include 'footer.php';
  ?>
