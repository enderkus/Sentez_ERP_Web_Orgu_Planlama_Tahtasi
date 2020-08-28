<?php
include 'header.php';
 ?>

<div class="container">
  <div class="row">
    <form class="col-12"  action="raporsonuc.php" method="post">
    <div class="col-12 mt-4">
      <div class="card border-secondary">
        <div class="card-header bg-secondary text-white">
          <b>ÜRETİM RAPORU ALMAK İSTEDİĞİNİZ TARİHİ BELİRLEYİN</b>
        </div>
        <div class="card-body">
          <div class="row">





          <div class="col-4">
            <label for="gun">GÜN :</label>
            <div class="form-group">
              <select class="form-control" name="gun" id="gun">
                <?php
                for ($i=1; $i <= 31 ; $i++) {
                  echo '<option value="'.$i.'">'.$i.'</option>';
                }
                 ?>
              </select>
            </div>
          </div>
          <div class="col-4">
            <label for="ay">AY :</label>
            <div class="form-group">
              <select class="form-control" name="ay" id="ay">
                <?php

                for ($i=1; $i <= 12 ; $i++) {
                  echo '<option value="'.$i.'">'.$i.'</option>';
                }

                 ?>
              </select>
            </div>
          </div>
          <div class="col-4">
            <label for="yil">YIL :</label>
            <div class="form-group">
              <select class="form-control" name="yil" id="yil">
                <?php
                  for ($i=date('Y'); $i >= 2018 ; $i--) {
                    echo '<option value="'.$i.'">'.$i.'</option>';
                  }
                 ?>
              </select>
            </div>
          </div>

          <div class="col-12">
            <input type="submit" class="btn btn-success btn-block" value="RAPORU GETİR">
          </div>
          </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



<?php
include 'footer.php';
 ?>
