<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "head.php" ?>
    <link href="css/custom/custom-style.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="css/layouts/page-center.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="js/plugins/chartist-js/chartist.min.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="js/plugins/sweetalert/dist/sweetalert.css" type="text/css" rel="stylesheet" media="screen,projection">

</head>
<body class="cyan">

<div id="login-page" class="row">
    <div class="col s12 z-depth-4 card-panel">
        <form class="login-form" action="../network/islem.php" method="POST">
            <div class="row">
                <div class="input-field col s12 center">
                    <img src="../images/login-logo.png" alt="Muhammed Ali"
                         class="circle responsive-img valign profile-image-login">
                    <p class="center login-form-text">İslami Bilgi Yarışması</p>
                </div>
            </div>
            <div class="row margin">
                <div class="input-field col s12">
                    <i class="mdi-social-person-outline prefix"></i>
                    <input id="username" name="k_adi" type="text" required="">
                    <label for="username" class="center-align">Kullanıcı Adı</label>
                </div>
            </div>
            <div class="row margin">
                <div class="input-field col s12">
                    <i class="mdi-action-lock-outline prefix"></i>
                    <input id="password" name="k_sifre" type="password" required="">
                    <label for="password">Şifre</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12 m12 l12  login-text">
                    <input type="checkbox" id="remember-me"/>
                    <label for="remember-me">Beni Hatırla</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <button name="giris" class="btn waves-effect waves-light col s12">Giriş</button>
                </div>
            </div>
            <div class="row">
                <?php

                if ($_GET['durum'] == "no") {

                    echo "<div id=\"durum\" class=\"hide\">no<div>";

                } elseif ($_GET['durum'] == "exit") {

                    echo "<div id=\"durum\" class=\"hide\">exit<div>";

                } else if ($_GET['durum'] == "izinsiz") {

                    echo "<div id=\"durum\" class=\"hide\">izinsiz<div>";

                }

                ?>
            </div>
        </form>
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
<!--sweetalert -->
<script type="text/javascript" src="js/plugins/sweetalert/dist/sweetalert.min.js"></script>
<!--plugins.js - Some Specific JS codes for Plugin Settings-->
<script type="text/javascript" src="js/plugins.js"></script>
<!--custom-script.js - Add your own theme custom JS-->
<script type="text/javascript" src="js/custom-script.js"></script>
<script type="text/javascript">
    $(document).ready(function () {

        if ($("#durum").text().trim() == "no") {
            swal({
                title: "Hatalı Giriş",
                type: "warning",
                text: "Kullanıcı adı veya şifreyi yanlış girdiniz.",
                confirmButtonText: "Tamam",
            });
        } else if ($("#durum").text().trim() == "exit") {
            swal({
                title: "Başarıyla Çıkış Yaptınız.",
                text: "Güle Güle",
                type: "success",
                confirmButtonText: "Tamam",
            });
        }else if ($("#durum").text().trim() == "izinsiz") {
            swal({
                title: "İzinsiz İşlem!",
                text: "Bu işlemi yapmaya yetkiniz bulunmuyor.",
                type: "error",
                confirmButtonText: "Tamam",
            });
        }


    });
</script>
</body>
</html>
