<?php
include '../network/baglan.php';
$kategori = $db->prepare("select * from kategori where kategori_id!=0");
$kategori->execute();

$seviye = $db->prepare("select * from seviye");
$seviye->execute();

?>
<!DOCTYPE html>
<html>
<head>
    <?php include "head.php" ?>
    <title>Soru Ekle</title>
    <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
    <link href="js/plugins/prism/prism.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet"
          media="screen,projection">
    <link href="js/plugins/chartist-js/chartist.min.css" type="text/css" rel="stylesheet" media="screen,projection">
    <!--animate css-->
    <link href="js/plugins/animate-css/animate.css" type="text/css" rel="stylesheet" media="screen,projection">

    <link href="js/plugins/sweetalert/dist/sweetalert.css" type="text/css" rel="stylesheet" media="screen,projection">
</head>
<body>
<?php include "header.php" ?>
<div id="main">
    <?php include "sidenav.php" ?>
    <div class="container">

        <div class="row">
            <div class="col s12 m12 l12">
                <div class="card-panel">
                    <form class="container" action="../network/islem.php" method="POST">
                        <h4 class="header2">SORU EKLE</h4>
                        <div class="row">
                            <input class="hide" type="number" name="kullanici_id" value="<?php echo $kullanicicek['kullanici_id'] ?>">
                                <div class="row">
                                    <div class="input-field col s12">
                                        <i class="mdi-action-help prefix"></i>
                                        <textarea id="soru" class="materialize-textarea" required="" name="soru"></textarea>
                                        <label for="soru">Soru *</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s12 m6 l6 input-field">
                                        <i class="mdi-action-done prefix"></i>
                                        <input id="cevap" type="text" required="" name="dogru_cevap">
                                        <label for="cevap">Doğru Cevap *</label>
                                    </div>
                                    <div class="col s12 m6 l6 input-field right">
                                        <i class="mdi-image-filter-1 prefix"></i></i>
                                        <input id="cevap1" type="text" required="" name="cevap_1">
                                        <label for="cevap1">Seçenek 1 *</label>
                                    </div>
                                    <div class="col s12 m6 l6 input-field right">
                                        <i class="mdi-image-filter-2 prefix"></i>
                                        <input id="cevap2" type="text" required="" name="cevap_2">
                                        <label for="cevap2">Seçenek 2 *</label>
                                    </div>
                                    <div class="col s12 m6 l6 input-field right">
                                        <i class="mdi-image-filter-3 prefix"></i>
                                        <input id="cevap3" type="text" required="" name="cevap_3">
                                        <label for="cevap3">Seçenek 3 *</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s12 m6 l6 input-field">
                                        <i class="mdi-image-exposure-plus-2 prefix"></i>
                                        <input id="ek1" type="text" name="ek_1">
                                        <label for="ek1">Ek Cevap</label>
                                    </div>
                                    <div class="col s12 m6 l6 input-field right">
                                        <i class="mdi-image-exposure-plus-2 prefix"></i>
                                        <input id="ek2" type="text" name="ek_2" value="">
                                        <label for="ek2">Ek Cavap</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s12 m6 l6 input-field">
                                        <div class="input-field col s12">
                                            <div id="_seviye">
                                                <select id="seviye" name="seviye" required="">
                                                    <option value="" disabled selected>Seviyeyi Seçin</option>
                                                    <?php
                                                    while ($row=$seviye->fetch(PDO::FETCH_ASSOC)) {
                                                        ?>
                                                        <option value="<?php echo $row['seviye_id']?>"><?php echo $row['seviye']?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                                <label>Soru Seviyesi *</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col s12 m6 l6 input-field">
                                        <div class="input-field col s12">
                                            <div id="_kategori">
                                                <select id="kategori" name="kategori" required="">
                                                    <option value="" disabled selected>Kategoriyi Seçin</option>
                                                    <?php
                                                    while ($row=$kategori->fetch(PDO::FETCH_ASSOC)) {
                                                        ?>
                                                        <option value="<?php echo $row['kategori_id']?>"><?php echo $row['kategori']?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                                <label>Soru Kategorisi *</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <button class="btn cyan waves-effect waves-light right" id="kaydet"
                                                type="submit" name="soruekle">Kaydet
                                            <i class="mdi-content-send right"></i>
                                        </button>
                                    </div>
                                </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

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




<!-- jQuery Library -->
<script type="text/javascript" src="js/plugins/jquery-1.11.2.min.js"></script>
<!--materialize js-->
<script type="text/javascript" src="js/materialize.js"></script>
<!--prism-->
<script type="text/javascript" src="js/plugins/prism/prism.js"></script>
<!--scrollbar-->
<script type="text/javascript" src="js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<!--sweetalert -->
<script type="text/javascript" src="js/plugins/sweetalert/dist/sweetalert.min.js"></script>
<!-- chartist -->
<script type="text/javascript" src="js/plugins/chartist-js/chartist.min.js"></script>


<!--plugins.js - Some Specific JS codes for Plugin Settings-->
<script type="text/javascript" src="js/plugins.js"></script>
<!--custom-script.js - Add your own theme custom JS-->
<script type="text/javascript" src="js/custom-script.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#kaydet").click(function (event) {
            if ($("#kategori option:selected").val() == "") {
                $('#_kategori').addClass(" animated flash").one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                    $(this).removeClass();
                });
            }
            if ($("#seviye option:selected").val() == "") {
                $('#_seviye').addClass(" animated flash").one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                    $(this).removeClass();
                });
            }
        });

        if ($("#durum").text().trim() == "ok") {
            swal({
                title: "Başarılı",
                type: "success",
                text: "Soru başarılı bir şekilde eklendi.",
                confirmButtonText: "Tamam",
            });
        } else if ($("#durum").text().trim() == "no") {
            swal({
                title: "HATA!",
                text: "Soru eklenmeye çalışırken hata meydana geldi.",
                type: "error",
                showCancelButton: true,
                showConfirmButton: false,
                cancelButtonText: "Tamam",
            });
        }
    });
</script>
</body>
</html>