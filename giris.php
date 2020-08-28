<?php
include 'header.php';
 ?>


<div class="container">
  <div class="row justify-content-md-center">
    <div class="col-sm-6 mt-4">
      <?php

      if (@$_GET['durum'] != "") {
        echo '<div class="alert alert-danger">HATALI BİR ŞİFRE GİRDİNİZ !</div>';
      }

       ?>

      <div class="card">
        <div class="card-header text-center">
          <h4>KULLANICI GİRİŞ EKRANI</h4>
        </div>
        <div class="card-body">

          <form class="" action="uyekontrol.php" method="post">

            <div class="form-group">
              <label for="uyeadi">KULLANICI ADINIZI SEÇİN : </label>
              <select id="uyeadi" class="form-control" name="uyeadi">



                <?php


                $uyeadlari = $database->query("SELECT UserName FROM Meta_User")->fetchAll();

                foreach ($uyeadlari as $uyead) {
                  echo '<option value="'.$uyead["UserName"].'">'.$uyead["UserName"].'</option>';
                }


                 ?>

              </select>
            </div>


            <div class="form-group">
              <label for="sifre">ŞİFRENİZ :</label>
              <input type="password" name="sifre" placeholder="SentezLive Şifreniz" class="form-control" required>
            </div>

            <div class="form-group">

                <input type="submit" class="btn btn-success btn-block" value="GİRİŞ YAP">
                <input type="reset"  value="FORMU TEMİZLE" class="btn btn-dark btn-block">

            </div>

          </form>


        </div>
        <div class="card-footer text-center">
          <p>&copy; 2020 KARSAL ÖRME</p>
        </div>
      </div>


    </div>
  </div>
</div>


 <?php

include 'footer.php';

  ?>
