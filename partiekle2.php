<?php
include 'header.php';
 ?>

<div class="container ">
  <div class="row justify-content-md-center">
    <div class="col-6 mt-4">




<?php

$makine = $_POST["recid"];
$parti = $_POST["partikodu"];
$makinekodu = $_POST["makine"];

$partisorgula = $database->count("Erp_WorkOrder",[
  'WorkOrderNo' => $parti,
]);

if ($partisorgula == 1) {

  $partibilgileri = $database->select("Erp_WorkOrder",[
  "RecId"
  ],[
   "WorkOrderNo" => $parti
  ]);

  $recid = $partibilgileri[0]['RecId'];

  $partisirabilgileri = $database->select("Erp_WorkOrderItem",[
    "RecId",
    "ItemOrderNo",
    "Quantity",
    "LabRecipeId",
    "RecipeId",
  ],[
    "WorkOrderId" => $recid
  ]);

  foreach ($partisirabilgileri as $psb) {


    $planlamaekle = $database->insert("Erp_Planning",[
      "PlanningType" => 2,
      "WorkOrderId" => $recid,
      "WorkOrderItemId" => $psb['RecId'],
      "ResourceId" => $makine,
      "Start" => date('Y.m.d H:i:s'),
      "Quantity" => $psb['Quantity'],
    ]);



  }


  $siralamakomutu = $database->select("Erp_Planning",[
    "RecId",
    "WorkOrderItemId"
  ],[
    "ResourceId" => $recid,
  ]);


  $calisan = 0;
  foreach ($siralamakomutu as $sk) {
    $calisankontrol = $database->query("SELECT COUNT(RecId) FROM Erp_WorkOrderProduction WHERE WorkOrderItemId = '".$sk["WorkOrderItemId"]."' AND InOut = 1");;
    $calisan = $calisan + $calisankontrol;
  }

if ($calisan == 0) {
  $i = 1;

 $yuklupartiler = $database->query("SELECT RecId FROM Erp_Planning WHERE ResourceId = '".$makine."'");
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
 $yuklupartiler2 = $database->query("SELECT RecId,WorkOrderItemId FROM Erp_Planning WHERE ResourceId = '".$makine."'");
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



 echo '<div class="h2 alert alert-success text-center">PARTİ BAŞARIYLA EKLENDİ <i class="fa fa-check"></i></div>';
 echo '<div class="alert alert-primary text-center">Partinin eklendiği makine : <b>'.$makinekodu.'</b></div>';
 echo '<a href="index.php#'.$makine.'" class="btn btn-success btn-block">ANA SAYFAYA DÖN</a>';
} elseif ($partisorgula == 0) {
  echo '<div class="h5 alert alert-danger">GEÇERSİZ BİR PARTİ NUMARASI GİRDİNİZ !</div>';
  echo '<div class="alert alert-warning">Geçerli bir parti numarası girdiğinizden emin olarak tekrar ekleme işlemi yapmayı deneyin.</div>';
  echo '<a href="index.php#'.$makine.'" class="btn btn-success btn-block">ANA SAYFAYA DÖN</a>';
} else {
  echo '<div class="h5 alert alert-danger">BELİRTTİĞİNİZ PARAMETRE İLE İLGİLİ HATA OLUŞTU !</div>';
  echo '<div class="alert alert-warning">Söz konusu durum tanımlanamayan bir hatadan kaynaklandı. Lütfen ilgili birim ile iletişime geçiniz.</div>';
  echo '<a href="index.php#'.$makine.'" class="btn btn-success btn-block">ANA SAYFAYA DÖN</a>';
}





 ?>

</div>
</div>
</div>



<?php
include 'footer.php';
 ?>
