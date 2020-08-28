<?php
include 'header.php';
@$parti = $_GET["parti"];
$makineid = $_GET["makineid"];
$makkod = $_GET["makkod"];
// Gelen partinin RecId bilgisini alıyoruz.
$partirecid = $database->query("SELECT RecId FROM Erp_WorkOrder WHERE WorkOrderNo = '".$parti."'")->fetchAll();
// Gelen RecId değerine göre satır bilgilerini alıyoruz.
@$partisatirgetir = $database->select("Erp_WorkOrderItem",[
  "RecId",
  "ItemOrderNo",
],[
  "WorkOrderId" => $partirecid[0]['RecId']
]);

$i = 1;

 ?>

<div class="container">
  <div class="row justify-content-md-center">
    <div class="col-6 mt-4">

      <div class="alert alert-warning">
        EKLEMEK İSTEDİĞİNİZ SATIRLARI SEÇEREK SATIRLARI EKLE BUTONUNA BASINIZ.
      </div>

      <div class="card">
        <div class="card-header">
          EKLENECEK SATIRLARI SEÇİN <b><?= $parti; ?></b>
        </div>
        <div class="card-body">


<form class="" action="partisecisle.php" method="post">




<?php foreach ($partisatirgetir as $ps): ?>

  <div class="form-check">
    <input class="form-check-input" name="recids[]" type="checkbox" value="<?= $ps["RecId"]; ?>" id="defaultCheck<?= $i; ?>">
    <label class="form-check-label" for="defaultCheck<?= $i; ?>">
      <?= $parti; ?>-<?= $ps["ItemOrderNo"]; ?>
    </label>
  </div>
<?php $i++; endforeach; ?>

<input type="hidden" name="makineid" value="<?= $makineid; ?>">
<input type="hidden" name="makinekodu" value="<?= $makkod; ?>">
<hr>
<input type="submit" class="btn btn-success btn-block" name="" value="SATIRLARI EKLE">
</form>



        </div>

        <div class="card-footer">
          EKLEME YAPILACAK MAKİNE : <b><?= $makkod; ?></b>
        </div>

      </div>


    </div>
  </div>
</div>


<?php
include 'footer.php';
 ?>
