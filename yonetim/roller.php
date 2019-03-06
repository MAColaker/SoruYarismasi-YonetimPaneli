<?php
include '../network/baglan.php';
include '../fonksiyonlar.php';

$roller = $db->query("select * from roller", PDO::FETCH_OBJ)->fetchAll();
$unvanlar = $db->query("select * from unvan", PDO::FETCH_OBJ)->fetchAll();
$yetkiler = $db->query("select * from yetki", PDO::FETCH_OBJ)->fetchAll();

?>
<!DOCTYPE html>
<html>
<title>Yetkiler</title>
<?php include "head.php" ?>
<!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
<link href="js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet"
      media="screen,projection">
<link href="js/plugins/jvectormap/jquery-jvectormap.css" type="text/css" rel="stylesheet" media="screen,projection">
<link href="js/plugins/chartist-js/chartist.min.css" type="text/css" rel="stylesheet" media="screen,projection">
<link href="js/plugins/jquery.nestable/nestable.css" type="text/css" rel="stylesheet" media="screen,projection">
<!--animate css-->
<link href="js/plugins/animate-css/animate.css" type="text/css" rel="stylesheet" media="screen,projection">

<link href="js/plugins/sweetalert/dist/sweetalert.css" type="text/css" rel="stylesheet" media="screen,projection">
<body>
<?php include "header.php" ?>
<div id="main">
    <?php include "sidenav.php" ?>
    <div class="container">
        <div class="row">
            <div class="col l6">
                <div class="card" style="padding-left: 30px; padding-right: 30px; padding-bottom: 30px">
                    <div class="card-content">
                        <form action="../network/islem.php" method="POST">
                            <span class="card-title">Rol İlişkilendir</span>
                            <br>
                            <div class="input-field">
                                <select id="yetki" name="yetki_id" required="">
                                    <option value="" disabled selected>Yetki Seçin</option>
                                    <?php
                                    foreach ($yetkiler as $yetki) {
                                        ?>
                                        <option value="<?php echo $yetki->yetki_id ?>"><?php echo $yetki->yetki ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <label>Yetki</label>
                            </div>
                            <br>
                            <div class="input-field">
                                <select id="unvan" name="unvan_id" required="">
                                    <option value="" disabled selected>Unvan Seçin</option>
                                    <?php
                                    foreach ($unvanlar as $unvan) {
                                        ?>
                                        <option value="<?php echo $unvan->unvan_id ?>"><?php echo $unvan->unvan ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <label>Unvan</label>
                            </div>
                            <br>
                            <div class="input-field">
                                <button class="btn waves-effect waves-light right"
                                        type="submit" name="roller">İlişkilendir
                                    <i class="mdi-content-send right"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col l6" id="category">
                <div class="card" style="padding-left: 30px; padding-right: 30px; padding-bottom: 30px">
                    <div class="card-content">
                        <span class="card-title">Yetkiler</span>
                    </div>
                    <div class="dd" id="nestable3">
                        <ol class="dd-list">
                            <?php

                            foreach ($unvanlar as $unvan) {
                                echo '<li class="dd-item">' .
                                    '<div class="dd-handle"><i class="mdi-navigation-arrow-forward left"></i>' . $unvan->unvan . '</div>' .
                                    '</li>'; ?>

                                <ol class="dd-list">
                                    <?php
                                    foreach ($yetkiler as $yetki) {
                                        foreach ($roller as $rol) {
                                            if ($rol->unvan_id == $unvan->unvan_id and $rol->yetki_id == $yetki->yetki_id)
                                                echo '<li class="dd-item">' .
                                                    '<div class="dd-handle"><i class="mdi-navigation-arrow-forward left"></i>' . $yetki->yetki . '<i onclick="sil(' . $rol->roller_id . ')" class="mdi-action-delete right"></i></div>' .
                                                    '</li>';
                                        }
                                    }


                                    ?>
                                </ol>
                                <?php
                            }
                            ?>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if ($_GET['durum'] == "ok") {

            echo "<div id=\"durum\" class=\"hide\">ok<div>";

        } elseif ($_GET['durum'] == "no") {

            echo "<div id=\"durum\" class=\"hide\">no<div>";

        }elseif ($_GET['durum'] == "hata") {

            echo "<div id=\"durum\" class=\"hide\">hata<div>";

        }
        ?>
    </div>
</div>

<!-- jQuery Library -->
<script type="text/javascript" src="js/plugins/jquery-1.11.2.min.js"></script>
<!--materialize js-->
<script type="text/javascript" src="js/materialize.js"></script>
<!--scrollbar-->
<script type="text/javascript" src="js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<!-- chartist -->
<script type="text/javascript" src="js/plugins/chartist-js/chartist.min.js"></script>

<!-- chartjs -->
<script type="text/javascript" src="js/plugins/chartjs/chart.min.js"></script>
<script type="text/javascript" src="js/plugins/chartjs/chart-script.js"></script>
<!-- sparkline -->
<script type="text/javascript" src="js/plugins/sparkline/jquery.sparkline.min.js"></script>
<script type="text/javascript" src="js/plugins/sparkline/sparkline-script.js"></script>
<!--jvectormap-->
<script type="text/javascript" src="js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script type="text/javascript" src="js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script type="text/javascript" src="js/plugins/jvectormap/vectormap-script.js"></script>
<!--nestable -->
<script type="text/javascript" src="js/plugins/jquery.nestable/jquery.nestable.js"></script>
<script type="text/javascript" src="js/plugins/sweetalert/dist/sweetalert.min.js"></script>
<!--plugins.js - Some Specific JS codes for Plugin Settings-->
<script type="text/javascript" src="js/plugins.js"></script>
<!--custom-script.js - Add your own theme custom JS-->
<script type="text/javascript" src="js/custom-script.js"></script>
<script type="text/javascript" src="js/ajax.js"></script>

<script>
    $(document).ready(function () {

        if ($("#durum").text().trim() == "ok") {
            swal({
                title: "Başarılı",
                type: "success",
                text: "İlişkilendirildi.",
                confirmButtonText: "Tamam",
            });
        } else if ($("#durum").text().trim() == "no") {
            swal({
                title: "HATA!",
                text: "İlişkilendirilme yapılamadı.",
                type: "error",
                showCancelButton: true,
                showConfirmButton: false,
                cancelButtonText: "Tamam",
            });
        }else if ($("#durum").text().trim() == "hata") {
            Materialize.toast('İlişkilendirme Zaten Var', 3000)
        }
    });

    function rol_sil_cevap(val) {

        if (val) {
            swal({
                    title: "Silindi",
                    text: "Başarıyla silindi.",
                    type: "success"
                },
                function () {
                    window.location.href = "../yonetim/roller.php";
                });
        } else {
            swal("Başarısız!", "Silme işlemi başarısız!", "error");
        }
    }

    function rol_sil(rol_id) {

        const param = {
            tag: "rol_sil",
            rol_id: rol_id
        };

        ajax(param, rol_sil_cevap);
    }

    function sweetalert(id) {
        swal({
                title: "Emin misiniz?",
                text: "Silemek istediğinizden emin misiniz?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "SİL",
                cancelButtonText: "İPTAL",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            },
            function () {
                rol_sil(id);
            });
    }

    function sil(id) {
        sweetalert(id);
    }
</script>
</body>
</html>