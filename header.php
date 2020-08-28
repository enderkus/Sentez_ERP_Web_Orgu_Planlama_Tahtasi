<?php




include 'mobiledetect.php';
include 'ayarlar.php';
include 'db.php';


$detect = new Mobile_Detect;

// Any mobile device (phones or tablets).
if ( $detect->isMobile() ) {
  header("Location:mobil.php");
}

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

    <title><?= $baslik; ?></title>

    <style media="screen">
      body {
        background-color: #dedede;
      }

      /* width */
::-webkit-scrollbar {
  width: 10px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1;
}

/* Handle */
::-webkit-scrollbar-thumb {
  background: #888;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #555;
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
  <div class="row flex-row flex-nowrap">


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

        <?php if (@$_SESSION['uyeadi'] != ""): ?>
          <div class="dropdown">
    <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      KULLANICI : <?= $_SESSION['uyeadi']; ?> | <?= $_SESSION['yetki']; ?>
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
      <a class="dropdown-item" href="sifredegistir.php">Şifre Değiştir</a>
      <a class="dropdown-item" href="cikis.php">Çıkış Yap</a>

    </div>
  </div>
        <?php endif; ?>






      </div>



    </div>

  </nav>
    </div>
</div>
