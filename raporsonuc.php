<?php
include 'header.php';
$gun = $_POST["gun"];
$ay = $_POST["ay"];
$yil = $_POST["yil"];



$birlestir = $gun."-".$ay."-".$yil;
$tarihedonustur = strtotime($birlestir);
$yeniformat = date('Y-m-d',$tarihedonustur);
$birgunsonra = date('Y-m-d', strtotime("+1 day", strtotime($yeniformat)));

 ?>

<div class="container">
  <div class="row">
    <div class="col-12 bg-white mt-4">
      <div class="alert alert-success text-center mt-3">
        <b>GETİRİLEN RAPOR TARİHİ : <?= $yeniformat; ?></b>
      </div>
      <hr>

      <table class="table">
  <thead>
    <tr>
      <th scope="col">MAKİNE</th>
      <th scope="col">08:00-16:00</th>
      <th scope="col">ADET</th>
      <th scope="col">16:00-24:00</th>
      <th scope="col">ADET</th>
      <th scope="col">24:00-08.00</th>
      <th scope="col">ADET</th>
      <th scope="col">TOPLAM AD.</th>
      <th scope="col">TOPLAM KG</th>
    </tr>
  </thead>
  <tbody>

    <?php
      $makinelersorgu = $database->query("SELECT RecId, ResourceCode, Explanation FROM Erp_Resource WHERE ResourceCode LIKE 'OR%' ORDER BY ResourceCode")->fetchAll();
      $sekizdorttoplamkilo = 0;
      $sekizdorttoplamadet = 0;
      $dortonikitoplamkilo = 0;
      $dortonikitoplamadet = 0;
      $onikisekiztoplamkilo = 0;
      $onikisekiztoplamadet = 0;
      $toptoplam = 0;
      $geneltoplamkilo = 0;
      foreach ($makinelersorgu as $ms) {
        echo '<tr>
          <th scope="row">'.$ms["ResourceCode"].'</th>';
          $sekizdortkilo = $database->sum("Erp_InventorySerialCard","NetQuantity",[
            "ResourceId" => $ms["RecId"],
            "InsertedAt[<>]" => [$yeniformat." 08:00:00",$yeniformat." 15:59:00"],
          ]);

          $sekizdortadet = $database->count("Erp_InventorySerialCard","RecId",[
            "ResourceId" => $ms["RecId"],
            "InsertedAt[<>]" => [$yeniformat." 08:00:00",$yeniformat." 15:59:00"],
          ]);

          $dortonikikilo = $database->sum("Erp_InventorySerialCard","NetQuantity",[
            "ResourceId" => $ms["RecId"],
            "InsertedAt[<>]" => [$yeniformat." 16:00:00",$yeniformat." 23:59:00"],
          ]);

          $dortonikiadet = $database->count("Erp_InventorySerialCard","RecId",[
            "ResourceId" => $ms["RecId"],
            "InsertedAt[<>]" => [$yeniformat." 16:00:00",$yeniformat." 23:59:00"],
          ]);
          // 12 -8 Kilo bilgisi bir gün sonranın tarihi ile alınacak.
          $onikisekizkilo = $database->sum("Erp_InventorySerialCard","NetQuantity",[
            "ResourceId" => $ms["RecId"],
            "InsertedAt[<>]" => [$birgunsonra." 00:00:01",$birgunsonra." 07:59:00"],
          ]);
          // 12-8 Top adet bilgisi için bir gün sonrası kullanılacak.
          $onikisekizadet = $database->count("Erp_InventorySerialCard","RecId",[
            "ResourceId" => $ms["RecId"],
            "InsertedAt[<>]" => [$birgunsonra." 00:00:00",$birgunsonra." 07:59:00"],
          ]);

          $toplamtop = $sekizdortadet + $dortonikiadet + $onikisekizadet;
          $sekizdortkilo = number_format($sekizdortkilo,'2','.',',');
          $dortonikikilo = number_format($dortonikikilo,'2','.',',');
          $onikisekizkilo = number_format($onikisekizkilo,'2','.',',');
          $toplamkg = $sekizdortkilo + $dortonikikilo + $onikisekizkilo;
          echo '<td>'.($sekizdortkilo == "" ? "0" : $sekizdortkilo).'</td>
          <td>'.$sekizdortadet.'</td>
          <td>'.($dortonikikilo == "" ? "0" : $dortonikikilo).'</td>
          <td>'.$dortonikiadet.'</td>
          <td>'.($onikisekizkilo == "" ? "0" : $onikisekizkilo).'</td>
          <td>'.$onikisekizadet.'</td>
          <td>'.$toplamtop.'</td>
          <td>'.number_format($toplamkg,'2','.',',').'</td>
        </tr>';
        $sekizdorttoplamkilo = $sekizdorttoplamkilo + $sekizdortkilo;
        $sekizdorttoplamadet = $sekizdorttoplamadet + $sekizdortadet;

        $dortonikitoplamkilo = $dortonikitoplamkilo + $dortonikikilo;
        $dortonikitoplamadet = $dortonikitoplamadet + $dortonikiadet;
        $onikisekiztoplamkilo = $onikisekiztoplamkilo + $onikisekizkilo;
        $onikisekiztoplamadet = $onikisekiztoplamadet + $onikisekizadet;
        $toptoplam = $toptoplam + $toplamtop;
        $geneltoplamkilo = $geneltoplamkilo + $toplamkg;
      }



     ?>

     <tr>
       <td><b>GENEL TOPLAM</b></td>
       <td><?= $sekizdorttoplamkilo ?></td>
       <td><?= $sekizdorttoplamadet ?></td>
       <td><?= $dortonikitoplamkilo ?></td>
       <td><?= $dortonikitoplamadet ?></td>
       <td><?= $onikisekiztoplamkilo ?></td>
       <td><?= $onikisekiztoplamadet ?></td>
       <td><?= $toptoplam ?></td>
       <td><?= number_format($geneltoplamkilo,'2','.',',') ?></td>
     </tr>



  </tbody>
</table>




    </div>
  </div>
</div>


<?php
include 'footer.php';
 ?>
