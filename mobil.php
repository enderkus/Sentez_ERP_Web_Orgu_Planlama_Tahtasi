<?php
include 'db.php';
 ?>
 <!doctype html>
 <html lang="en">
   <head>
     <!-- Required meta tags -->
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

     <!-- Bootstrap CSS -->
     <link rel="stylesheet" href="css/bs.min.css">
     <link rel="stylesheet" href="css/all.css">

     <title>KARSAL | MOBİL</title>

     <style media="screen">
       body {
         background-color: #dedede;
       }

       .kapsayici {
         display: block;
         background-color: #dedede;
         border-radius: 5px;
         padding-top:5px;
         padding-bottom:5px;
         font-size: 0.9em;
       }


       .kapsayici .col-6 {
         border-bottom: 1px solid #c5c5c5ab;
         padding-bottom: 2px;
       }

       .kapsayici .col-6:last-child {
         border:none;
       }

       .kapsayici .col-6:nth-last-child(2) {
         border:none;
       }



     </style>


   </head>
   <body>

 <div class="container-fluid bg-dark mb-5">
   <div class="row">


   <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" >
     <a class="navbar-brand" href="#">KARSAL ÖRME</a>
     <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
       <span class="navbar-toggler-icon"></span>
     </button>
     <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
       <div class="navbar-nav">
         <a class="nav-item nav-link active" href="index.php">Ana Sayfa <span class="sr-only">(current)</span></a>
         <a class="nav-item nav-link" href="makinedurumlari.php">Makine Durumları</a>
         <a class="nav-item nav-link" href="vardiyauretimraporu.php">Vardiya Üretim Raporu</a>







       </div>



     </div>

   </nav>
     </div>
 </div>

 <div class="container ">
   <div class="row">
     <div class="col-12 mt-4">
       <div class="card">
         <div class="card-header bg-dark text-white">
           <h5>MAKİNE SEÇİN</h5>
         </div>


         <div class="card-body">
           <div class="alert alert-warning">
             Planlama durumunu görmek istediğiniz makineyi seçin ve görüntüle butonuna basın.
           </div>

           <form class="" action="mobil.php" method="get">
             <div class="form-group">
               <select class="form-control" name="makine">
                  <?php
                  $sorgu = $database->query("SELECT RecId, ResourceCode, Explanation FROM Erp_Resource WHERE ResourceCode LIKE 'OR%' ORDER BY ResourceCode")->fetchAll();
                   ?>

                   <?php foreach ($sorgu as $s): ?>
                     <option value="<?= $s["RecId"]; ?>"><?= $s["ResourceCode"]; ?></option>
                   <?php endforeach; ?>

               </select>
             </div>

             <div class="form-group">
               <input type="submit" class="btn btn-block btn-success"  value="GÖRÜNTÜLE">
             </div>


           </form>


         </div>


       </div>
     </div>
   </div>
 </div>


<?php if (@$_GET["makine"] != ""): ?>
  <div class="container">
    <div class="row">
      <div class="col-12 mt-4">
        <div class="alert alert-success text-center">
          <?php
            $makinebilgileri = $database->select("Erp_Resource","ResourceCode",[
              "RecId" => $_GET["makine"],
            ]);


           ?>
          <h5><?= $makinebilgileri[0] ?></h5>
        </div>

        <!-- Kart Dizilim Alanı -->
        <!-- Kart Başlangıcı -->

        <?php
        $sorgu2 = $database->query("SELECT WorkOrderNo,ItemOrderNo,CurrentAccountName,CustomerOrderNo,ResourceCode,RecId,PlanningType,WorkOrderId,WorkOrderItemId,ResourceId,Capacity,IsCompleted,Quantity,SiraNo,Ud_Next,InOut,StartProductionDate,StartProductionTime,ProductionDate,ProductionTime,Orulen,Orulecek,OrtSure,KumasAdi,KumasKodu,FabricGram,FabricWidth,FabricPus,FabricFein,FabricDenier,LabRecipeName FROM aaa WHERE ResourceCode = '".$makinebilgileri[0]."' group by WorkOrderNo,ItemOrderNo,CurrentAccountName,CustomerOrderNo,ResourceCode,RecId,PlanningType,WorkOrderId,WorkOrderItemId,ResourceId,Capacity,IsCompleted,Quantity,SiraNo,Ud_Next,InOut,StartProductionDate,StartProductionTime,ProductionDate,ProductionTime,Orulen,Orulecek,OrtSure,KumasAdi,KumasKodu,FabricGram,FabricWidth,FabricPus,FabricFein,FabricDenier,LabRecipeName  order by InOut,SiraNo,WorkOrderItemId")->fetchAll();

        ?>

        <?php
        foreach ($sorgu2 as $s2) {
            $maxdeger = $database->max("Erp_Planning","ItemOrderNo",[
            "ResourceId" => $s["RecId"],
          ]);
          ?>

            <?php
            if($s2["InOut"] == 1) {
              $oncekideger = $s2["WorkOrderItemId"];
            ?>
              <div class="card border-success mb-3">
                <div class="card-header bg-success text-white container-fluid">

                  <div class="row">
                    <div class="col-8 text-center">
                        <p class="mb-0 mt-2 h6"><?= $s2["WorkOrderNo"]; ?>-<?= $s2["ItemOrderNo"]; ?> (<?= $s2["SiraNo"]; ?>)</p>
                    </div>

                    <div class="col-4">
                      <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#detay-<?= $s2["WorkOrderNo"]; ?>-<?= $s2["ItemOrderNo"]; ?>">
                        DETAY
                      </button>

                    </div>
                  </div>
                </div>
                <!-- Modal Alanı -->
                <div class="modal fade" id="detay-<?= $s2["WorkOrderNo"]; ?>-<?= $s2["ItemOrderNo"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><?= $s2["WorkOrderNo"]; ?>-<?= $s2["ItemOrderNo"]; ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body text-center">
                        <p><?= $s2["KumasAdi"]; ?></p>
                        <p>Gramaj : <?= $s2["FabricGram"]; ?> | En : <?= $s2["FabricWidth"]; ?> | Pus : <?= $s2["FabricPus"]; ?> | Fein : <?= $s2["FabricFein"]; ?> | Denye : <?= $s2["FabricDenier"]; ?></p>
                        <?php
                        $aciklama2 = $database->select("Erp_WorkOrder","UD_GenisAciklama",[
                          'WorkOrderNo' => $s2["WorkOrderNo"],
                        ]);
                         ?>
                         <p class="alert alert-secondary"><?= $aciklama2[0]; ?></p>
                         <p>Renk : <?= $s2["LabRecipeName"]; ?></p>
                         <p class="alert">S.Miktarı : <?= number_format($s2["Quantity"],3,'.',','); ?> KG | Örülen : <?= number_format($s2["Orulen"],3,'.',','); ?> KG <br> Kalan : <?= number_format($s2["Orulecek"],3,'.',','); ?> KG</p>
                         <p class="text-center">FİŞ NO : <?= $s2["CustomerOrderNo"]; ?></p>

                         <hr>


                           <div class="btn-group btn-group-lg" role="group" aria-label="Basic example">
                              <a href="isemricikis.php?woi=<?= $s2["WorkOrderItemId"]; ?>&workorderno=<?= $s2["WorkOrderNo"]; ?>&workorderitem=<?= $s2["ItemOrderNo"]; ?>" class="btn btn-warning">ÇIKIŞ</a>
                              <div class="btn-group" role="group">
<button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
SİL
</button>
<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
<a class="btn btn-danger" href="isemrisil.php?workorderitemid=<?= $s2["WorkOrderItemId"]; ?>&makineid=<?= $s["RecId"]; ?>">SİLMEYİ ONAYLA</a>
</div>
</div>
                           </div>





                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">KAPAT</button>

                      </div>
                    </div>
                  </div>
                </div>
                <!-- Modal Alanı Bitti -->

                <div class="card-body text-center" <?php
                  if ($s2["KumasAdi"] == "") {
                    echo 'style="background-color:#93989c;"';
                  }
                  ?>>
                  <h5 class="card-title"><?= $s2["CurrentAccountName"]; ?></h5>
                  <p class="card-text"><?= $s2["KumasAdi"]; ?></p>
                  <p class="card-text">FİŞ NO : <?= $s2["CustomerOrderNo"]; ?></p>
                  <hr>
                  <div class="kapsayici">
                    <div class="container">
                      <div class="row">


                      <div class="col-6 text-left">
                        S.MiKTARI :
                      </div>

                      <div class="col-6 text-right">
                        <?= number_format($s2["Quantity"],3,'.',','); ?> KG
                      </div>

                      <div class="col-6 text-left">
                        ÖRÜLEN :

                      </div>



                      <div class="col-6 text-right">
                        <?= number_format($s2["Orulen"],3,'.',','); ?> KG
                      </div>

                      <div class="col-6 text-left">
                       ÖRÜLECEK :
                      </div>

                      <div class="col-6 text-right">
                        <?= number_format($s2["Orulecek"],3,'.',','); ?> KG
                      </div>
                      </div>
                    </div>




                  </div>


                  <div class="btn-group btn-block mt-2" role="group" aria-label="Basic example">

                     <?php if ($s2["SiraNo"] != 1): ?>
                       <a href="enustetasi.php?makineid=<?= $s["RecId"]; ?>&sirano=<?= $s2["SiraNo"]; ?>" class="btn btn-secondary" title="En Üste Taşı"><i class="fas fa-angle-double-up"></i></a>
                       <a href="yukaritasi.php?makineid=<?= $s["RecId"]; ?>&sirano=<?= $s2["SiraNo"]; ?>" class="btn btn-secondary" title="Üste Taşı"><i class="fas fa-chevron-up"></i></a>
                     <?php endif; ?>

                     <?php if ($s2["SiraNo"] != $maxdeger): ?>
                       <a href="asagitasi.php?makineid=<?= $s["RecId"]; ?>&sirano=<?= $s2["SiraNo"]; ?>" class="btn btn-secondary" title="Alta Taşı"><i class="fas fa-chevron-down"></i></a>
                       <a href="enaltatasi.php?makineid=<?= $s["RecId"]; ?>&sirano=<?= $s2["SiraNo"]; ?>" class="btn btn-secondary" title="En Alta Taşı"><i class="fas fa-angle-double-down"></i></a>
                     <?php endif; ?>
                 </div>

                </div>
              </div>
            <?php }elseif ($s2["InOut"] == 2 && $s2["WorkOrderItemId"] != $oncekideger ) { ?>
               <div class="card border-danger mb-3" >
                 <div class="card-header bg-danger text-white container-fluid">
                   <div class="row">
                     <div class="col-8 text-center">

                         <p class="mb-0 mt-2 h6"><?= $s2["WorkOrderNo"]; ?>-<?= $s2["ItemOrderNo"]; ?> (<?= $s2["SiraNo"]; ?>)</p>
                     </div>

                     <div class="col-4">
                       <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#detay-<?= $s2["WorkOrderNo"]; ?>-<?= $s2["ItemOrderNo"]; ?>">
                         DETAY
                       </button>

                     </div>
                   </div>


                 </div>

                 <!-- Modal Alanı -->
                 <div class="modal fade" id="detay-<?= $s2["WorkOrderNo"]; ?>-<?= $s2["ItemOrderNo"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                   <div class="modal-dialog" role="document">
                     <div class="modal-content">
                       <div class="modal-header">
                         <h5 class="modal-title" id="exampleModalLabel"><?= $s2["WorkOrderNo"]; ?>-<?= $s2["ItemOrderNo"]; ?></h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                         </button>
                       </div>
                       <div class="modal-body text-center">
                         <p><?= $s2["KumasAdi"]; ?></p>
                         <p>Gramaj : <?= $s2["FabricGram"]; ?> | En : <?= $s2["FabricWidth"]; ?> | Pus : <?= $s2["FabricPus"]; ?> | Fein : <?= $s2["FabricFein"]; ?> | Denye : <?= $s2["FabricDenier"]; ?></p>
                         <?php
                         $aciklama2 = $database->select("Erp_WorkOrder","UD_GenisAciklama",[
                           'WorkOrderNo' => $s2["WorkOrderNo"],
                         ]);
                          ?>
                          <p class="alert alert-secondary"><?= $aciklama2[0]; ?></p>
                          <p>Renk : <?= $s2["LabRecipeName"]; ?></p>
                          <p class="alert">S.Miktarı : <?= number_format($s2["Quantity"],3,'.',','); ?> KG | Örülen : <?= number_format($s2["Orulen"],3,'.',','); ?> KG <br> Kalan : <?= number_format($s2["Orulecek"],3,'.',','); ?> KG</p>
                          <p class="text-center">FİŞ NO : <?= $s2["CustomerOrderNo"]; ?></p>

                          
                            <div class="btn-group btn-group-lg" role="group" aria-label="Basic example">
                              <a href="isemrigiris.php?parti=<?= $s2["WorkOrderNo"] ?>&sira=<?= $s2["ItemOrderNo"] ?>&woi=<?= $s2["WorkOrderItemId"]; ?>&makineid=<?= $s["RecId"]; ?>&miktar=<?= number_format($s2["Quantity"],3,'.',','); ?>&makkod=<?= $s["ResourceCode"] ?>" class="btn btn-success">GİRİŞ</a>
                               <div class="btn-group" role="group">
<button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
 SİL
</button>
<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
 <a class="btn btn-danger" href="isemrisil.php?workorderitemid=<?= $s2["WorkOrderItemId"]; ?>&makineid=<?= $s["RecId"]; ?>">SİLMEYİ ONAYLA</a>
</div>
</div>
                            </div>

                       </div>
                       <div class="modal-footer">
                         <button type="button" class="btn btn-secondary" data-dismiss="modal">KAPAT</button>

                       </div>
                     </div>
                   </div>
                 </div>

                 <!-- Modal Alanı Bitti -->




                 <div class="card-body" <?php
                   if ($s2["KumasAdi"] == "") {
                     echo 'style="background-color:#93989c;"';
                   }
                   ?>>
                     <h5 class="card-title text-center"><?= $s2["CurrentAccountName"]; ?></h5>
                     <p class="card-text text-center"><?= $s2["KumasAdi"]; ?></p>
                     <p class="card-text text-center">FİŞ NO : <?= $s2["CustomerOrderNo"]; ?></p>

                     <hr>
                     <div class="kapsayici">
                       <div class="container">
                         <div class="row">


                         <div class="col-6 text-left">
                           S.MiKTARI :
                         </div>

                         <div class="col-6 text-right">
                           <?= number_format($s2["Quantity"],3,'.',','); ?> KG
                         </div>

                         <div class="col-6 text-left">
                           ÖRÜLEN :
                         </div>

                         <div class="col-6 text-right">
                           <?= number_format($s2["Orulen"],3,'.',','); ?> KG
                         </div>

                         <div class="col-6 text-left">
                          ÖRÜLECEK :
                         </div>

                         <div class="col-6 text-right">
                           <?= number_format($s2["Orulecek"],3,'.',','); ?> KG
                         </div>
                         </div>
                       </div>




                     </div>

                     <div class="btn-group btn-block mt-2" role="group" aria-label="Basic example">
                       <?php if ($s2["SiraNo"] != 1): ?>

                         <a href="enustetasi.php?makineid=<?= $s["RecId"]; ?>&sirano=<?= $s2["SiraNo"]; ?>" class="btn btn-secondary" title="En Üste Taşı"><i class="fas fa-angle-double-up"></i></a>

                         <a href="yukaritasi.php?makineid=<?= $s["RecId"]; ?>&sirano=<?= $s2["SiraNo"]; ?>" class="btn btn-secondary" title="Yukarı Taşı"><i class="fas fa-chevron-up"></i></a>

                       <?php endif; ?>
                       <?php if ($s2["SiraNo"] != $maxdeger): ?>
                         <a href="asagitasi.php?makineid=<?= $s["RecId"]; ?>&sirano=<?= $s2["SiraNo"]; ?>" class="btn btn-secondary" title="Alta Taşı"><i class="fas fa-chevron-down"></i></a>
                         <a href="enaltatasi.php?makineid=<?= $s["RecId"]; ?>&sirano=<?= $s2["SiraNo"]; ?>" class="btn btn-secondary" title="En Alta Taşı"><i class="fas fa-angle-double-down"></i></a>
                       <?php endif; ?>
                    </div>


                  </div>
               </div>
            <?php
          } elseif($s2['InOut'] == 3) {

            ?>

            <div class="card border-primary mb-3">
              <div class="card-header bg-primary text-white container-fluid">
                <div class="row">
                  <div class="col-8 text-center">
                      <p class="mb-0 mt-2 h6"><?= $s2["WorkOrderNo"]; ?>-<?= $s2["ItemOrderNo"]; ?> (<?= $s2["SiraNo"]; ?>)</p>
                  </div>

                  <div class="col-4">
                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#detay-<?= $s2["WorkOrderNo"]; ?>-<?= $s2["ItemOrderNo"]; ?>">
                      DETAY
                    </button>

                  </div>
                </div>


              </div>

              <!-- Modal Alanı -->
              <div class="modal fade" id="detay-<?= $s2["WorkOrderNo"]; ?>-<?= $s2["ItemOrderNo"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel"><?= $s2["WorkOrderNo"]; ?>-<?= $s2["ItemOrderNo"]; ?></h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body text-center">
                      <p><?= $s2["KumasAdi"]; ?></p>
                      <p>Gramaj : <?= $s2["FabricGram"]; ?> | En : <?= $s2["FabricWidth"]; ?> | Pus : <?= $s2["FabricPus"]; ?> | Fein : <?= $s2["FabricFein"]; ?> | Denye : <?= $s2["FabricDenier"]; ?></p>
                      <?php
                      $aciklama2 = $database->select("Erp_WorkOrder","UD_GenisAciklama",[
                        'WorkOrderNo' => $s2["WorkOrderNo"],
                      ]);
                       ?>
                       <p class="alert alert-secondary"><?= $aciklama2[0]; ?></p>
                       <p>Renk : <?= $s2["LabRecipeName"]; ?></p>
                       <p class="alert">S.Miktarı : <?= number_format($s2["Quantity"],3,'.',','); ?> KG | Örülen : <?= number_format($s2["Orulen"],3,'.',','); ?> KG <br> Kalan : <?= number_format($s2["Orulecek"],3,'.',','); ?> KG</p>
                       <p class="text-center">FİŞ NO : <?= $s2["CustomerOrderNo"]; ?></p>


                         <div class="btn-group btn-group-lg" role="group" aria-label="Basic example">
                           <a href="isemrigiris.php?parti=<?= $s2["WorkOrderNo"] ?>&sira=<?= $s2["ItemOrderNo"] ?>&woi=<?= $s2["WorkOrderItemId"]; ?>&makineid=<?= $s["RecId"]; ?>&miktar=<?= number_format($s2["Quantity"],3,'.',','); ?>&makkod=<?= $s["ResourceCode"] ?>" class="btn btn-success">GİRİŞ</a>
                            <div class="btn-group" role="group">
                            <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            SİL
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <a class="btn btn-danger" href="isemrisil.php?workorderitemid=<?= $s2["WorkOrderItemId"]; ?>&makineid=<?= $s["RecId"]; ?>">SİLMEYİ ONAYLA</a>
                            </div>
                            </div>                               </div>

                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">KAPAT</button>

                    </div>
                  </div>
                </div>
              </div>

              <!-- Modal Alanı Bitti -->




              <div class="card-body " <?php
                if ($s2["KumasAdi"] == "") {
                  echo 'style="background-color:#93989c;"';
                }
                ?>>
                  <h5 class="card-title text-center"><?= $s2["CurrentAccountName"]; ?></h5>
                  <p class="card-text text-center"><?= $s2["KumasAdi"]; ?></p>
                  <p class="card-text text-center">FİŞ NO : <?= $s2["CustomerOrderNo"]; ?></p>

                  <hr>
                  <div class="kapsayici">
                    <div class="container">
                      <div class="row">


                      <div class="col-6 text-left">
                        S.MiKTARI :
                      </div>

                      <div class="col-6 text-right">
                        <?= number_format($s2["Quantity"],3,'.',','); ?> KG
                      </div>

                      <div class="col-6 text-left">
                        ÖRÜLEN :
                      </div>

                      <div class="col-6 text-right">
                        <?= number_format($s2["Orulen"],3,'.',','); ?> KG
                      </div>

                      <div class="col-6 text-left">
                       ÖRÜLECEK :
                      </div>

                      <div class="col-6 text-right">
                        <?= number_format($s2["Orulecek"],3,'.',','); ?> KG
                      </div>
                      </div>
                    </div>




                  </div>

                  <div class="btn-group btn-block mt-2" role="group" aria-label="Basic example">
                    <?php if ($s2["SiraNo"] != 1): ?>
                      <a href="enustetasi.php?makineid=<?= $s["RecId"]; ?>&sirano=<?= $s2["SiraNo"]; ?>" class="btn btn-secondary" title="En Üste Taşı"><i class="fas fa-angle-double-up"></i></a>
                      <a href="yukaritasi.php?makineid=<?= $s["RecId"]; ?>&sirano=<?= $s2["SiraNo"]; ?>" class="btn btn-secondary" title="Üste Taşı"><i class="fas fa-chevron-up"></i></a>
                    <?php endif; ?>
                    <?php if ($s2["SiraNo"] != $maxdeger): ?>
                      <a href="asagitasi.php?makineid=<?= $s["RecId"]; ?>&sirano=<?= $s2["SiraNo"]; ?>" class="btn btn-secondary" title="Alta Taşı"><i class="fas fa-chevron-down"></i></a>
                      <a href="enaltatasi.php?makineid=<?= $s["RecId"]; ?>&sirano=<?= $s2["SiraNo"]; ?>" class="btn btn-secondary" title="En Alta Taşı"><i class="fas fa-angle-double-down"></i></a>
                    <?php endif; ?>
                 </div>

               </div>
            </div>


            <?php
          }
             ?>





                        <?php
                        $oncekideger = $s2["WorkOrderItemId"];
                        }


                         ?>




        <!-- Kart Bitişi -->

        <!-- Kart Dizilim Alanı Bitti -->




      </div>
    </div>
  </div>
<?php endif; ?>







<?php
include 'footer.php';
 ?>
