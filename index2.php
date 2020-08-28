<?php



if ($_SESSION['uyeadi'] == "") {
  @header("Location:giris.php");
}

include 'header.php';





 ?>









     <div class="container-fluid pt-4">
       <div class="row flex-row flex-nowrap">


         <?php

         $sorgu = $database->query("SELECT RecId, ResourceCode, Explanation FROM Erp_Resource WHERE ResourceCode LIKE 'OR%' ORDER BY ResourceCode")->fetchAll();



          ?>


          <?php foreach ($sorgu as $s): ?>
            <div class="col-2">
              <h4 class="alert alert-success text-center mb-1 sticky-top" id="<?= $s["RecId"]; ?>"><?= $s["ResourceCode"]; ?><hr class="mb-1 mt-1"> <span style="font-size:0.5em;"><b style="font-size:1.5em;"><?= $s["ResourceCode"]; ?></b> | <?= $s["Explanation"]; ?></span> </h4>
              <?php

              $i=0;
              $hamsaat = 0;

              $saattoplam = $database->query("SELECT WorkOrderItemId,OrtSure FROM aaa WHERE ResourceCode = '".$s['ResourceCode']."' GROUP BY WorkOrderItemId,OrtSure")->fetchAll();

              foreach ($saattoplam as $saatsatir) {

                if ($saatsatir['OrtSure'] > 0) {
                  $hamsaat += $saatsatir['OrtSure'];
                }



                $i++;
              }

              $kisasaat =  number_format($hamsaat,2,'.',',');

              $saatbol = explode(".",$kisasaat);

              $dakikahesapla = $saatbol[1] * 60 / 100;

              $gunhesapla = $saatbol[0] / 24;
              $gundenkalan = $saatbol[0]%24;






               ?>

              <h6 class="alert alert-secondary text-center mb-1"><?= $i; ?> ADET</h6>

              <?php if ($_SESSION['yetki'] == 2): ?>
                <a href="partiekle.php?recid=<?= $s["RecId"]; ?>" class="btn btn-dark btn-block mt-2 mb-2">PARTİ EKLE</a>
              <?php endif; ?>




               <div class="alert alert-warning text-center">
                 ORTALAMA İŞ SÜRESİ<br><b> <?= floor($gunhesapla); ?> GÜN <?= $gundenkalan ?> SAAT <?= number_format($dakikahesapla,0) ?> DAKİKA</b>
               </div>

              <!-- Kart Başlangıcı -->

              <?php
              $sorgu2 = $database->query("SELECT WorkOrderNo,ItemOrderNo,CurrentAccountName,CustomerOrderNo,ResourceCode,RecId,PlanningType,WorkOrderId,WorkOrderItemId,ResourceId,Capacity,IsCompleted,Quantity,SiraNo,Ud_Next,InOut,StartProductionDate,StartProductionTime,ProductionDate,ProductionTime,Orulen,Orulecek,OrtSure,KumasAdi,KumasKodu,FabricGram,FabricWidth,FabricPus,FabricFein,FabricDenier,LabRecipeName FROM aaa WHERE ResourceCode = '".$s['ResourceCode']."' group by WorkOrderNo,ItemOrderNo,CurrentAccountName,CustomerOrderNo,ResourceCode,RecId,PlanningType,WorkOrderId,WorkOrderItemId,ResourceId,Capacity,IsCompleted,Quantity,SiraNo,Ud_Next,InOut,StartProductionDate,StartProductionTime,ProductionDate,ProductionTime,Orulen,Orulecek,OrtSure,KumasAdi,KumasKodu,FabricGram,FabricWidth,FabricPus,FabricFein,FabricDenier,LabRecipeName  order by InOut,SiraNo,WorkOrderItemId")->fetchAll();

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
                    <div class="card border-success mb-3" style="max-width: 18rem;">
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
                              <?php

                              $kisasaattek =  number_format($s2["OrtSure"],2,'.',',');

                              $saatboltek = explode(".",$kisasaattek);

                              $dakikahesaplatek = $saatboltek[1] * 60 / 100;

                              $gunhesaplatek = $saatboltek[0] / 24;
                              $gundenkalantek = $saatboltek[0]%24;

                               ?>
                               <div class="alert alert-warning text-center">
                                 ORTALAMA İŞ SÜRESİ<br><b> <?= floor($gunhesaplatek); ?> GÜN <?= $gundenkalantek ?> SAAT <?= number_format($dakikahesaplatek,0) ?> DAKİKA</b>
                               </div>
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

                               <?php if ($_SESSION['yetki'] == 2): ?>
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
                               <?php endif; ?>




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
                        <p class="card-text">RENK : <?= $s2["LabRecipeName"]; ?></p>
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
                  <?php }elseif ($s2["InOut"] == 2 && $s2["WorkOrderItemId"] != @$oncekideger ) { ?>
                     <div class="card border-danger mb-3" style="max-width: 18rem;">
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
                               <?php

                               $kisasaattek =  number_format($s2["OrtSure"],2,'.',',');

                               $saatboltek = explode(".",$kisasaattek);

                               $dakikahesaplatek = $saatboltek[1] * 60 / 100;

                               $gunhesaplatek = $saatboltek[0] / 24;
                               $gundenkalantek = $saatboltek[0]%24;

                                ?>
                                <div class="alert alert-warning text-center">
                                  ORTALAMA İŞ SÜRESİ<br><b> <?= floor($gunhesaplatek); ?> GÜN <?= $gundenkalantek ?> SAAT <?= number_format($dakikahesaplatek,0) ?> DAKİKA</b>
                                </div>

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

                                <?php if ($_SESSION['yetki'] == 2): ?>
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
                                <?php endif; ?>
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
                           <p class="card-text text-center">RENK : <?= $s2["LabRecipeName"]; ?></p>
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

                  <div class="card border-primary mb-3" style="max-width: 18rem;">
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

                            <?php

                            $kisasaattek =  number_format($s2["OrtSure"],2,'.',',');

                            $saatboltek = explode(".",$kisasaattek);

                            $dakikahesaplatek = $saatboltek[1] * 60 / 100;

                            $gunhesaplatek = $saatboltek[0] / 24;
                            $gundenkalantek = $saatboltek[0]%24;

                             ?>
                             <div class="alert alert-warning text-center">
                               ORTALAMA İŞ SÜRESİ<br><b> <?= floor($gunhesaplatek); ?> GÜN <?= $gundenkalantek ?> SAAT <?= number_format($dakikahesaplatek,0) ?> DAKİKA</b>
                             </div>
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

                             <?php if ($_SESSION['yetki'] == 2): ?>
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
                             <?php endif; ?>
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
                        <p class="card-text text-center">RENK : <?= $s2["LabRecipeName"]; ?></p>
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
            </div>

          <?php endforeach; ?>
















       </div>
   </div>




<?php include 'footer.php'; ?>
