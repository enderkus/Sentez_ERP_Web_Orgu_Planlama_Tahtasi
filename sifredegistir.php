<?php
include 'header.php';
 ?>


<div class="container">
  <div class="row justify-content-md-center">
    <div class="col-6 mt-4">
      <div class="alert alert-success">
        KULLANICI ADINIZ : <b><?= $_SESSION['uyeadi']; ?></b>
      </div>


      <div class="card">
        <div class="card-header">
          <h5>ŞİFRE DEĞİŞTİRME EKRANI</h5>
        </div>
        <div class="card-body">
          <form class="" action="sifreguncelle.php" method="post">
            <div class="form-group">
              <input type="text" name="yenisifre" placeholder="Yeni Şifreniz" class="form-control">
            </div>

            <div class="form-group">
              <input type="text" name="yenisifre2" placeholder="Yeni Şifrenizi Onaylayın" class="form-control">
            </div>

            <input type="hidden" name="uyeadi" value="<?= $_SESSION['uyeadi']; ?>">

            <input type="submit" class="btn btn-success btn-block" value="ŞİFREMİ DEĞİŞTİR">



          </form>
        </div>
      </div>

      <div class="alert alert-warning mt-2">
        <b>DİKKAT : Yeni şifrenizin doğruluğundan emin olmak için belirlemek istediğiniz yeni şifreyi onay alanına tekrar yazınız.</b>
      </div>


    </div>
  </div>
</div>



 <?php
include 'footer.php';
  ?>
