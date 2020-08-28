<?php
include 'header.php';

$recid = $_GET["recid"];

 ?>

           <?php

           $makinebilgilerigetir = $database->query("SELECT * FROM Erp_Resource WHERE RecId = '".$recid."'")->fetchAll();



            ?>
<div class="container">
  <div class="row ">
    <div class="col-8 mt-4">
      <div class="alert alert-danger alert-block">
        Bu kısımda parti talimat kodunu tam olarak giriniz. <b>Örnek : 04-2000123</b> şeklinde.
      </div>

      <div class="card">
        <div class="card-header">
          <h4><i class="fa fa-angle-right"></i> PARTİ EKLEME FORMU</h4>
        </div>
        <div class="card-body">
          <form class="" action="partiekle2.php" method="post">
            <div class="form-group">
              <label>PARTİ KODU :</label>
              <input type="text" name="partikodu" placeholder="Parti Kodu" class="form-control form-control-lg">
            </div>
            <input type="hidden" name="recid" value="<?= $recid; ?>">
            <input type="hidden" name="makine" value="<?= $makinebilgilerigetir[0]["ResourceCode"]; ?>">
            <div class="form-group">
              <input type="submit" name="" value="PARTİ EKLE" class="btn btn-success btn-block btn-lg">
            </div>
          </form>
        </div>
      </div>

      <div class="alert alert-danger mt-4">
        SATIR SEÇEREK GİRİŞ SAĞLAMAK İÇİN PARTİ KODUNU BU FORMA GİRİNİZ
      </div>

      <div class="card">
        <div class="card-header">
          <h4><i class="fa fa-angle-right"></i> PARTİ EKLEME FORMU</h4>
        </div>
        <div class="card-body">
          <form class="" action="partisec.php" method="get">
            <div class="form-group">
              <label>PARTİ KODU :</label>
              <input type="text" name="parti" placeholder="Parti Kodu" class="form-control form-control-lg">
            </div>
            <input type="hidden" name="makineid" value="<?= $recid; ?>">
            <input type="hidden" name="makkod" value="<?= $makinebilgilerigetir[0]["ResourceCode"]; ?>">
            <div class="form-group">
              <input type="submit" name="" value="SATIRLARI LİSTELE" class="btn btn-success btn-block btn-lg">
            </div>
          </form>
        </div>
      </div>





    </div>

    <div class="col-4 mt-4">
      <div class="card">
        <div class="card-header bg-dark text-white">
          MAKİNE BİLGİLERİ
        </div>
        <div class="card-body">
          <p class="alert alert-warning">Planlama tahtasına eklenecek makine bilgileri aşağıdaki gibidir.<br> Aksaklık çıkmaması adına göz atmanız önerilir.</p>
          <!-- Makine bilgileri çekiliyor -->




          <p><i class="fa fa-angle-right"></i> Makine Kodu : <b><?= $makinebilgilerigetir[0]["ResourceCode"]; ?></b> </p>
          <hr>
          <p><i class="fa fa-angle-right"></i> Makine :</p>
          <p><b><?= $makinebilgilerigetir[0]["Explanation"]; ?></b> </p>
          <hr>
          <p><i class="fa fa-angle-right"></i> Günlük Kapasite :</p>
          <p><b><?= number_format($makinebilgilerigetir[0]["Capacity"],2,',','.'); ?> KG</b> </p>
          <p><i class="fa fa-angle-right"></i> Marka :</p>
          <p><b><?= $makinebilgilerigetir[0]["UD_Marka"]; ?></b> </p>
        </div>
      </div>
    </div>


  </div>
</div>



 <?php
include 'footer.php';
 ?>
