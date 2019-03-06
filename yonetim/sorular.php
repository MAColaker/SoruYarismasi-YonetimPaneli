<?php

include '../network/baglan.php';
include '../fonksiyonlar.php';
date_default_timezone_set('Europe/Istanbul');

$sayfada = 10; // sayfada gösterilecek içerik miktarını belirtiyoruz.


$sorgu = $db->prepare("select COUNT(soru_id) as adet from sorular WHERE sorular.statu = :statu");
$sorgu->execute(array(
    "statu" => 1
));
$toplam_icerik = $sorgu->fetch(PDO::FETCH_ASSOC)["adet"];


$toplam_sayfa = ceil($toplam_icerik / $sayfada);


// eğer sayfa girilmemişse 1 varsayalım.
$sayfa = isset($_GET['sayfa']) ? (int)$_GET['sayfa'] : 1;

// eğer 1'den küçük bir sayfa sayısı girildiyse 1 yapalım.
if ($sayfa < 1) $sayfa = 1;

// toplam sayfa sayımızdan fazla yazılırsa en son sayfayı varsayalım.
if ($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa;

$limit = ($sayfa - 1) * $sayfada;

$sorular = $db->prepare("select *, 
if(sorular.kullanici_id,sorular.kullanici_id,sorular.oyuncu_id) as user_id,
if(sorular.kullanici_id,kullanici.k_resim,oyuncu.imageUrl) as image,
if(sorular.kullanici_id,kullanici.isim,oyuncu.name) as isim,
if(sorular.kullanici_id,'yonetici','oyuncu') as unvan
from sorular INNER JOIN kategori ON sorular.kategori_id = kategori.kategori_id INNER JOIN seviye ON sorular.seviye_id = seviye.seviye_id LEFT JOIN oyuncu ON  sorular.oyuncu_id = oyuncu.oyuncu_id LEFT JOIN kullanici ON sorular.kullanici_id = kullanici.kullanici_id WHERE sorular.statu = :statu ORDER BY sorular.tarih DESC limit $limit,$sayfada");
$sorular->execute(array(
    'statu' => 1
));

$sorucek = array();


?>
<html>
<head>
    <?php include "head.php" ?>
    <title>Sorular</title>
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

        table tr {
            cursor: pointer;
        }

    </style>
</head>
<body>
<?php include "header.php"; ?>
<div id="main">
    <?php include "sidenav.php"; ?>
    <div class="container">
        <div class="row">
            <div class="card" id="sorular0">
                <div class="card-content">
                    <span class="card-title">SORULAR</span>
                </div>
                <table class="highlight">
                    <thead>
                    <tr>
                        <th data-field="id">ID</th>
                        <th data-field="soru" width="50%">Soru</th>
                        <th data-field="name">Tarih</th>
                        <th data-field="price">Ekleyen</th>
                        <th data-field="price">Kategori</th>
                        <th data-field="price">Sayı</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    $index = 0;
                    while ($row = $sorular->fetch(PDO::FETCH_ASSOC)) {
                        $sorucek[] = $row; ?>

                        <tr onclick='modal(<?php echo json_encode($sorucek[$index]); ?>,"<?php echo convertDate($sorucek[$index]['tarih']) ?>");'>
                            <td><?php echo $sorucek[$index]['soru_id'] ?></td>
                            <td><?php echo $sorucek[$index]['soru'] ?></td>
                            <td><?php echo $sorucek[$index]['tarih'] ?></td>
                            <td><?php echo $sorucek[$index]['isim'] ?></td>
                            <td><?php echo $sorucek[$index]['kategori'] ?></td>
                            <td>
                                <button class="btn-floating green"><b><?php echo $sorucek[$index]['dogru_sayisi'] ?></b>
                                </button>
                                <button class="btn-floating red"><b><?php echo $sorucek[$index]['yanlis_sayisi'] ?></b>
                                </button>
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
                                        href="sorular.php?sayfa=<?php echo $sayfa - 1; ?>#"><i
                                            class="mdi-navigation-chevron-left"></i></a></li>

                            <?php
                        }
                        ?>

                        <?php

                        for ($s = $min; $s <= $max; $s++) {

                            ?><?php
                            if ($s == $sayfa) { ?>
                                <li class="active">
                                    <a href="sorular.php?sayfa=<?php echo $s; ?>#"><?php echo $s; ?></a>
                                </li>
                            <?php } else { ?>
                                <li class="waves-effect">
                                    <a href="sorular.php?sayfa=<?php echo $s; ?>#"><?php echo $s; ?></a>
                                </li> <?php }
                        }

                        ?>

                        <?php
                        if ($sayfa != $max) {
                            ?>

                            <li class="waves-effect"><a
                                        href="sorular.php?sayfa=<?php echo $sayfa + 1; ?>#"><i
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
    </div>
</div>
<!-- Modal Structure -->
<div id="modal0" class="modal">
    <div class="modal-content">
        <div class="row">
            <div class="col l6 left">
                <div class="chip">
                    <img src="images/avatar.jpg" alt="Contact Person">
                    <span id="isim"></span>
                </div>
                <div class="chip">
                    <span id="seviye"></span>
                </div>
            </div>
            <div class="col l6 right-align" style="float: right">
                <span id="tarih"></span>
            </div>
        </div>
        <div class="row">
            <div id="soru" class="col l12 center">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid beatae distinctio eum excepturi id
                incidunt ipsum laboriosam molestias odio placeat qui, quia recusandae reiciendis rerum sit soluta unde
                veritatis voluptatibus.
            </div>
        </div>
        <div class="row">
            <div class="input-field col l6">
                <i class="mdi-action-done prefix" style="color: green"></i>
                <input id="icon_prefix" style="color: black" type="text" disabled class="validate dogru" value="Deneme">
            </div>
            <div class="input-field col l6">
                <i class="mdi-content-clear prefix" style="color: red"></i>
                <input id="icon_prefix" style="color: black" type="text" disabled class="validate c1" value="Deneme">
            </div>
            <div class="input-field col l6">
                <i class="mdi-content-clear prefix" style="color: red"></i>
                <input id="icon_prefix" style="color: black" type="text" disabled class="validate c2" value="Deneme">
            </div>
            <div class="input-field col l6">
                <i class="mdi-content-clear prefix" style="color: red"></i>
                <input id="icon_prefix" style="color: black" type="text" disabled class="validate c3" value="Deneme">
            </div>
            <div class="input-field col l6 ek1">
                <i class="mdi-content-clear prefix" style="color: red"></i>
                <input id="icon_prefix" style="color: black" type="text" disabled class="validate ek1" value="Deneme">
            </div>
            <div class="input-field col l6 ek2">
                <i class="mdi-content-clear prefix" style="color: red"></i>
                <input id="icon_prefix" style="color: black" type="text" disabled class="validate ek2" value="Deneme">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" id="sil" class="waves-effect waves-red btn-flat modal-action modal-close red-text">SİL</a>
        <a href="#!" id="duzenle"
           class="waves-effect waves-green btn-flat modal-action modal-close blue-text">DÜZENLE</a>
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
    $(window).scroll(function () {
        sessionStorage.scrollTop = $(this).scrollTop();
    });

    $(document).ready(function () {
        if (sessionStorage.scrollTop !== "undefined") {
            $(window).scrollTop(sessionStorage.scrollTop);
        }

        $('.modal').modal();

    });


    function soru_sil_cevap(val) {

        if (val) {
            swal({   title: "Silindi",
                    text: "Başarıyla silindi.",
                    type: "success"
                },
                function(){
                    window.location.href = "../yonetim/sorular.php";
                });
        } else {
            swal("Başarısız!", "Silme işlemi başarısız!", "error");
        }
    }

    function soru_sil(soru_id) {

        const param = {
            tag: "soru_sil",
            soru_id: soru_id
        };

        ajax(param, soru_sil_cevap);
    }

    function modal(data, tarih) {


        $('#isim').text(data.isim);
        $('#seviye').text(data.seviye);
        $('#tarih').text(tarih);
        $('#soru').text(data.soru);
        $('.dogru').val(data.dogru_cevap);
        $('.c1').val(data.cevap_1);
        $('.c2').val(data.cevap_2);
        $('.c3').val(data.cevap_3);
        $('#sil').click(function () {
            sweetalert(data.soru_id);
        });
        if (data.ek_1) {
            $('.ek1').val(data.ek_1);
        } else {
            $('.ek1').css("display", "none")
        }

        if (data.ek_2) {
            $('.ek2').val(data.ek_2);
        } else {
            $('.ek2').css("display", "none")
        }

        $("#duzenle").attr("href", "../yonetim/soruduzenle.php?soru=" + data.soru_id);

        $('.modal').openModal();
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
                soru_sil(id);
            });
    }
</script>
</body>
</html>