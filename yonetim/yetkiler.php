<?php
include '../network/baglan.php';
include '../fonksiyonlar.php';

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
                            <span class="card-title">Yetki Ekle</span>
                            <div class="input-field">
                                <input id="yetki" type="text" class="validate" name="yetki">
                                <label for="yetki">Yetki İsmi</label>
                            </div>
                            <div class="input-field">
                                <button class="btn waves-effect waves-light right"
                                        type="submit" name="yetkiekle">Ekle
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
                            foreach ($yetkiler as $sutun) {
                                echo '<li class="dd-item">' .
                                    '<div class="dd-handle"><i class="mdi-navigation-arrow-forward left"></i>' . $sutun->yetki . '<i onclick="sil(' . $sutun->yetki_id . ')" class="mdi-action-delete right"></i><i onclick="duzenle(' . $sutun->yetki_id . ')" class="mdi-editor-mode-edit right" ></i></div>' .
                                    '</li>';
                            }
                            ?>
                        </ol>
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
                text: "Yetki başarılı bir şekilde eklendi.",
                confirmButtonText: "Tamam",
            });
        } else if ($("#durum").text().trim() == "no") {
            swal({
                title: "HATA!",
                text: "Yetki eklenmeye çalışırken hata meydana geldi.",
                type: "error",
                showCancelButton: true,
                showConfirmButton: false,
                cancelButtonText: "Tamam",
            });
        }
    });

    function yetki_sil_cevap(val) {

        if (val) {
            swal({
                    title: "Silindi",
                    text: "Başarıyla silindi.",
                    type: "success"
                },
                function () {
                    window.location.href = "../yonetim/yetkiler.php";
                });
        } else {
            swal("Başarısız!", "Silme işlemi başarısız!", "error");
        }
    }

    function yetki_sil(yetki_id) {

        const param = {
            tag: "yetki_sil",
            yetki_id: yetki_id
        };

        ajax(param, yetki_sil_cevap);
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
                yetki_sil(id);
            });
    }

    function sil(id) {
        sweetalert(id);
    }

    function duzenle(id) {
        window.location.href = "../yonetim/yetkiduzenle.php?yetki=" + id;
    }
</script>
</body>
</html>