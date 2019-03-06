<?php

include '../network/baglan.php';
include '../fonksiyonlar.php';
date_default_timezone_set('Europe/Istanbul');

$id = $_GET["kullanici"];

if (!$id) {
    header('Location:../yonetim/index.php');
    exit;
}

$kullanici = $db->prepare("select * from kullanici where kullanici_id=:kullanici_id");
$kullanici->execute(array(
    "kullanici_id" => $id
));

$kullanicibilgileri = $kullanici->fetch(PDO::FETCH_ASSOC);

$unvanlar = $db->query("select * from unvan", PDO::FETCH_OBJ)->fetchAll();

?>
<html>
<head>
    <?php include "head.php" ?>
    <title>Profil Düzenle</title>
    <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
    <link href="js/plugins/prism/prism.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet"
          media="screen,projection">
    <link href="js/plugins/chartist-js/chartist.min.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="js/plugins/magnific-popup/magnific-popup.css" type="text/css" rel="stylesheet"
          media="screen,projection">
    <link href="js/plugins/sweetalert/dist/sweetalert.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="js/plugins/dropify/css/dropify.min.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="css/custom/custom-style.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="css/plugins/media-hover-effects.css" type="text/css" rel="stylesheet" media="screen,projection">
</head>
<body>
<?php include "header.php"; ?>
<div id="main">
    <?php include "sidenav.php"; ?>
    <div class="container">
        <div class="row">
            <div class="col m3"><br></div>
            <div class="col m6">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Profil</span>
                        <div class="row">
                            <div class="col s12 m6 grid">
                                <figure onclick="modal()" class="effect-sadie">
                                    <img src="<?php echo $kullanicibilgileri["k_resim"] ?>"/>
                                    <figcaption>
                                        <p onclick="modal()">düzenle</p>
                                    </figcaption>
                                </figure>
                            </div>
                            <div class="col s12 m6 grid">
                                <br>
                            </div>
                        </div>
                        <form action="../network/islem.php" method="POST">
                            <p class="input-field">
                                <input <?php echo $kullanicicek["unvan_id"]!=1 ? "disabled" : null ?> value="<?php echo $kullanicibilgileri['k_adi']; ?>" name="k_adi" id="k_adi"
                                       type="text" class="validate">
                                <label for="k_adi">Kullanıcı Adı</label>
                            </p><br>
                            <?php
                            if ($kullanicicek["unvan_id"]==1){
                            ?>
                            <p>
                            <div class="input-field">
                                <select name="unvan_id">
                                    <?php
                                    foreach ($unvanlar as $unvan) {
                                        ?>
                                        <option <?php echo $unvan->unvan_id == $kullanicibilgileri['unvan_id'] ? "selected" : null ?>
                                                value="<?php echo $unvan->unvan_id ?>"><?php echo $unvan->unvan ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <label>Unvan</label>
                            </div>
                            </p><br>
                            <?php
                            }
                            ?>
                            <p class="input-field">
                                <input value="<?php echo $kullanicibilgileri['isim']; ?>" name="isim" id="isim" type="text"
                                       class="validate">
                                <label for="isim">İsim</label>
                            </p><br>
                            <p class="input-field">
                                <input value="<?php echo $kullanicibilgileri['k_mail']; ?>" name="k_mail" id="mail"
                                       type="email" class="validate">
                                <label for="mail">E-Posta</label>
                            </p><br>
                            <p class="input-field">
                                <input name="k_sifre" id="sifre" type="password">
                                <label for="sifre">Yeni Şifre</label>
                            </p><br>
<!--                            <p class="input-field">-->
<!--                                <input id="sifretekrar" type="password">-->
<!--                                <label for="sifretekrar">Şifre Tekrar</label>-->
<!--                            </p><br>-->
                            <p>
                                <input type="text" name="kullanici_id" hidden
                                       value="<?php echo $kullanicibilgileri['kullanici_id']; ?>">
                            </p>
                            <p class="input-field">
                                <button class="btn waves-effect waves-light center"
                                        type="submit" name="kullaniciduzenle">Güncelle
                                    <i class="mdi-content-send right"></i>
                                </button>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col m3"><br></div>
        </div>
        <?php
        if ($_GET['durum'] == "ok") {

            echo "<div id=\"durum\" class=\"hide\">ok<div>";

        } elseif ($_GET['durum'] == "no") {

            echo "<div id=\"durum\" class=\"hide\">no<div>";

        }
        ?>
    </div>
</div>
<!-- Modal Structure -->
<div id="modal0" class="modal">
    <form enctype="multipart/form-data" action="../network/islem.php" method="POST">
        <div class="modal-content">
            <h4>Resim Düzenleme</h4>
            <div class="row">
                <div class="col l12">
                    <input type="text" hidden value="<?php echo $kullanicibilgileri["kullanici_id"]?>" name="kullanici_id"/>
                    <input type="file" accept="image/*" name="k_resim" id="input-file-events" class="dropify-event"
                           data-default-file="<?php echo $kullanicibilgileri["k_resim"]?>"/>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button id="duzenle" name="resimduzenle" type="submit"
               class="waves-effect waves-green btn-flat modal-action blue-text">GÜNCELLE</button>
        </div>
    </form>
</div>
<!-- jQuery Library -->
<script type="text/javascript" src="js/plugins/jquery-1.11.2.min.js"></script>
<!--materialize js-->
<script type="text/javascript" src="js/materialize.js"></script>
<!--prism-->
<script type="text/javascript" src="js/plugins/prism/prism.js"></script>
<!--scrollbar-->
<script type="text/javascript" src="js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="js/plugins/sweetalert/dist/sweetalert.min.js"></script>
<!-- chartist -->
<script type="text/javascript" src="js/plugins/chartist-js/chartist.min.js"></script>
<!-- masonry -->
<script src="js/plugins/masonry.pkgd.min.js"></script>
<!-- imagesloaded -->
<script src="js/plugins/imagesloaded.pkgd.min.js"></script>
<!-- magnific-popup -->
<script type="text/javascript" src="js/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
<!-- dropify -->
<script type="text/javascript" src="js/plugins/dropify/js/dropify.min.js"></script>
<!--plugins.js - Some Specific JS codes for Plugin Settings-->
<script type="text/javascript" src="js/plugins.js"></script>
<!--custom-script.js - Add your own theme custom JS-->
<script type="text/javascript" src="js/custom-script.js"></script>


<script type="text/javascript" src="js/ajax.js"></script>

<script>
    $(document).ready(function () {
        $('.dropify-event').dropify({
            messages: {
                default: 'Bir resmi buraya sürükleyip bırakın veya tıklayın',
                replace: 'Bir dosyayı sürükleyip bırakın veya değiştirmek için tıklayın',
                remove: 'Kaldır',
                error: 'Üzgünüz, dosya çok büyük'
            }
        });
    });

    function modal() {
        $('.modal').openModal();
    }
</script>
</body>
</html>