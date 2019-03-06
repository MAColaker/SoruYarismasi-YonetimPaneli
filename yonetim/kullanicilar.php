<?php

include '../network/baglan.php';
include '../fonksiyonlar.php';
date_default_timezone_set('Europe/Istanbul');

$sayfada = 10; // sayfada gösterilecek içerik miktarını belirtiyoruz.


$sorgu = $db->prepare("select COUNT(kullanici_id) as adet from kullanici");
$sorgu->execute();
$toplam_icerik = $sorgu->fetch(PDO::FETCH_ASSOC)["adet"];


$toplam_sayfa = ceil($toplam_icerik / $sayfada);


// eğer sayfa girilmemişse 1 varsayalım.
$sayfa = isset($_GET['sayfa']) ? (int)$_GET['sayfa'] : 1;

// eğer 1'den küçük bir sayfa sayısı girildiyse 1 yapalım.
if ($sayfa < 1) $sayfa = 1;

// toplam sayfa sayımızdan fazla yazılırsa en son sayfayı varsayalım.
if ($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa;

$limit = ($sayfa - 1) * $sayfada;

$kullanicilar = $db->prepare("select *, unvan.unvan as unvan from kullanici,unvan where kullanici.unvan_id=unvan.unvan_id ORDER BY kullanici.k_tarih ASC limit $limit,$sayfada");
$kullanicilar->execute();

$kullanicilaricek = array();


?>
<html>
<head>
    <?php include "head.php" ?>
    <title>Kullanıcılar</title>
    <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
    <link href="js/plugins/prism/prism.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet"
          media="screen,projection">
    <link href="js/plugins/chartist-js/chartist.min.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="js/plugins/sweetalert/dist/sweetalert.css" type="text/css" rel="stylesheet" media="screen,projection">
    <style>
        table th, td {
            padding-left: 24px;
        }

        table {
            border-collapse: collapse;
            empty-cells: show;
        }

        td {
            position: relative;
        }

        tr.strikeout td:before {
            content: " ";
            position: absolute;
            top: 50%;
            left: 0;
            border-bottom: 1px solid #111;
            width: 100%;
        }

        tr.strikeout td:after {
            content: "\00B7";
            font-size: 1px;
        }

    </style>
</head>
<body>
<?php include "header.php"; ?>
<div id="main">
    <?php include "sidenav.php"; ?>
    <div class="container">
        <div class="row">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">KULLANICILAR</span>
                </div>
                <table class="highlight">
                    <thead>
                    <tr>
                        <th data-field="id">ID</th>
                        <th data-field="isim">İsim</th>
                        <th data-field="username">Kullanıcı Adı</th>
                        <th data-field="eposta">E-posta</th>
                        <th data-field="unvan">Ünvan</th>
                        <th data-field="tarih">Tarih</th>
                        <th></th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    $index = 0;
                    while ($row = $kullanicilar->fetch(PDO::FETCH_ASSOC)) {
                        $kullanicilaricek[] = $row; ?>

                        <tr class="<?php echo $kullanicilaricek[$index]['statu'] ? null : 'strikeout' ?>">
                            <td><?php echo $kullanicilaricek[$index]['kullanici_id'] ?></td>
                            <td><?php echo $kullanicilaricek[$index]['isim'] ?></td>
                            <td><?php echo $kullanicilaricek[$index]['k_adi'] ?></td>
                            <td><?php echo $kullanicilaricek[$index]['k_mail'] ?></td>
                            <td><?php echo $kullanicilaricek[$index]['unvan'] ?></td>
                            <td><?php echo $kullanicilaricek[$index]['k_tarih'] ?></td>
                            <td>
                                <a href="" class="btn-floating blue"><i class="mdi-action-search"></i></a>
                                <a href="kullaniciduzenle.php?kullanici=<?php echo $kullanicilaricek[$index]['kullanici_id'] ?>" class="btn-floating indigo"><i class="mdi-image-edit"></i></a>
                                <?php
                                if ($kullanicilaricek[$index]["statu"]) {
                                    ?>
                                    <a onclick="engelle(<?php echo $kullanicilaricek[$index]['kullanici_id'] ?>)" class="btn-floating grey"><i class="mdi-content-block"></i></a>
                                    <?php
                                } else {
                                    ?>
                                    <a onclick="etkin(<?php echo $kullanicilaricek[$index]['kullanici_id'] ?>)" class="btn-floating green"><i class="mdi-action-done"></i></a>
                                    <?php
                                }
                                ?>
                            </td>
                        </tr>

                        <?php
                        $index++;
                    }
                    ?>
                    </tbody>
                </table>
                <div class="divider"></div>
                <div style="padding-bottom: 1px" class="center-align">
                    <ul class="pagination">

                        <?php

                        $tolerans = 3;
                        $min = $sayfa - $tolerans;
                        $max = $sayfa + $tolerans;

                        if ($min < 1)
                            $min = 1;

                        if ($max > $toplam_sayfa)
                            $max = $toplam_sayfa;


                        ?>

                        <?php
                        if ($sayfa != $min) {
                            ?>

                            <li class="waves-effect"><a
                                        href="kullanicilar.php?sayfa=<?php echo $sayfa - 1; ?>#"><i
                                            class="mdi-navigation-chevron-left"></i></a></li>

                            <?php
                        }
                        ?>

                        <?php

                        for ($s = $min; $s <= $max; $s++) {

                            ?><?php
                            if ($s == $sayfa) { ?>
                                <li class="active">
                                    <a href="kullanicilar.php?sayfa=<?php echo $s; ?>#"><?php echo $s; ?></a>
                                </li>
                            <?php } else { ?>
                                <li class="waves-effect">
                                    <a href="kullanicilar.php?sayfa=<?php echo $s; ?>#"><?php echo $s; ?></a>
                                </li> <?php }
                        }

                        ?>

                        <?php
                        if ($sayfa != $max) {
                            ?>

                            <li class="waves-effect"><a
                                        href="kullanicilar.php?sayfa=<?php echo $sayfa + 1; ?>#"><i
                                            class="mdi-navigation-chevron-right"></i></a></li>
                            <?php
                        } else {
                            ?>
                            <li></li>
                            <?php
                        }
                        ?>

                        <!--<li class="disabled"><a href="#!"><i class="mdi-navigation-chevron-left"></i></a></li>
                        <li class="active"><a href="#!">1</a></li>
                        <li class="waves-effect"><a href="#!">2</a></li>
                        <li class="waves-effect"><a href="#!">3</a></li>
                        <li class="waves-effect"><a href="#!">4</a></li>
                        <li class="waves-effect"><a href="#!">5</a></li>
                        <li class="waves-effect"><a href="#!"><i class="mdi-navigation-chevron-right"></i></a></li>-->
                    </ul>
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
<script type="text/javascript" src="js/plugins/sweetalert/dist/sweetalert.min.js"></script>
<!-- chartist -->
<script type="text/javascript" src="js/plugins/chartist-js/chartist.min.js"></script>
<!--plugins.js - Some Specific JS codes for Plugin Settings-->
<script type="text/javascript" src="js/plugins.js"></script>
<!--custom-script.js - Add your own theme custom JS-->
<script type="text/javascript" src="js/custom-script.js"></script>


<script type="text/javascript" src="js/ajax.js"></script>

<script>

    function kullanici_engelle_cevap(val) {

        if (val) {
            swal({
                    title: "Engellendi",
                    text: "Başarıyla engellendi.",
                    type: "success"
                },
                function () {
                    window.location.href = "../yonetim/kullanicilar.php";
                });
        } else {
            swal("Başarısız!", "Engelleme işlemi başarısız!", "error");
        }
    }

    function kullanici_engelle(kullanici_id) {

        const param = {
            tag: "kullanici_engelle",
            kullanici_id: kullanici_id
        };

        ajax(param, kullanici_engelle_cevap);
    }

    function sweetalert(id) {
        swal({
                title: "Emin misiniz?",
                text: "Engellemek istediğinizden emin misiniz?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "ENGELLE",
                cancelButtonText: "İPTAL",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            },
            function () {
                kullanici_engelle(id);
            });
    }

    function engelle(id) {
        sweetalert(id);
    }

    function kullanici_etkin_cevap(val) {

        if (val) {
            swal({
                    title: "Etkin",
                    text: "Başarıyla etkinleştirildi.",
                    type: "success"
                },
                function () {
                    window.location.href = "../yonetim/kullanicilar.php";
                });
        } else {
            swal("Başarısız!", "Etkinleştirme işlemi başarısız!", "error");
        }
    }

    function kullanici_etkin(kullanici_id) {

        const param = {
            tag: "kullanici_etkin",
            kullanici_id: kullanici_id
        };

        ajax(param, kullanici_etkin_cevap);
    }

    function sweetalert2(id) {
        swal({
                title: "Emin misiniz?",
                text: "Etkinleştirmek istediğinizden emin misiniz?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "ETKİNLEŞTİR",
                cancelButtonText: "İPTAL",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            },
            function () {
                kullanici_etkin(id);
            });
    }

    function etkin(id) {
        sweetalert2(id);
    }
</script>
</body>
</html>