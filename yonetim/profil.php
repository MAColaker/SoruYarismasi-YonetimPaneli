<?php

include '../network/baglan.php';

$id = $_GET["oyuncu"];

if (!$id) {
    header('Location:../yonetim/index.php');
    exit;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Kullanıcı Profili</title>
    <?php include "head.php" ?>
    <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
    <link href="js/plugins/prism/prism.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet"
          media="screen,projection">
    <link href="js/plugins/chartist-js/chartist.min.css" type="text/css" rel="stylesheet" media="screen,projection">
</head>
<body>
<?php include "header.php" ?>
<div id="main">
    <?php include "sidenav.php" ?>
    <div class="container">
        <div id="profile-page-header" class="card">
            <div class="card-image waves-effect waves-block waves-light">
                <img class="activator" src="images/user-profile-bg.jpg" alt="user background">
            </div>
            <figure class="card-profile-image">
                <img src="images/avatar.jpg" alt="profile image" class="circle z-depth-2 responsive-img activator">
            </figure>
            <div class="card-content">
                <div class="row" style="margin-top: 20px;">
                    <div class="col s3 offset-s2">
                        <h4 class="card-title grey-text text-darken-4">Roger Waters</h4>
                        <p class="medium-small grey-text">Project Manager</p>
                    </div>
                    <div class="col s2 center-align">
                        <h4 class="card-title grey-text text-darken-4">10+</h4>
                        <p class="medium-small grey-text">Work Experience</p>
                    </div>
                    <div class="col s2 center-align">
                        <h4 class="card-title grey-text text-darken-4">6</h4>
                        <p class="medium-small grey-text">Completed Projects</p>
                    </div>
                    <div class="col s2 center-align">
                        <h4 class="card-title grey-text text-darken-4">$ 1,253,000</h4>
                        <p class="medium-small grey-text">Busness Profit</p>
                    </div>
                    <div class="col s1 right-align" style="    margin-top: -30px;">
                        <a class="btn-floating btn-large activator waves-effect waves-light darken-2 right">
                            <i class="mdi-navigation-more-vert"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-reveal">
                <p>
                    <span class="card-title grey-text text-darken-4">Roger Waters <i
                                class="mdi-navigation-close right"></i></span>
                    <span><i class="mdi-action-perm-identity cyan-text text-darken-2"></i> Project Manager</span>
                </p>

                <p>I am a very simple card. I am good at containing small bits of information. I am convenient because I
                    require little markup to use effectively.</p>

                <p><i class="mdi-action-perm-phone-msg cyan-text text-darken-2"></i> +1 (612) 222 8989</p>
                <p><i class="mdi-communication-email cyan-text text-darken-2"></i> mail@domain.com</p>
                <p><i class="mdi-social-cake cyan-text text-darken-2"></i> 18th June 1990</p>
                <p><i class="mdi-device-airplanemode-on cyan-text text-darken-2"></i> BAR - AUS</p>
            </div>
        </div>
        <ul id="tabs-swipe-demo" class="tabs light-blue">
            <li class="tab col s3"><a class="active white-text" href="#test-swipe-1">Cevapladığın Sorular</a></li>
            <li class="tab col s3"><a class="white-text" href="#test-swipe-2">Eklediğin Sorular</a></li>
        </ul>
        <div id="test-swipe-1" class="col s12">Test 1</div>
        <div id="test-swipe-2" class="col s12">Test 2</div>
    </div>
</div>

<!-- jQuery Library -->
<script type="text/javascript" src="js/plugins/jquery-1.11.2.min.js"></script>
<!--materialize js-->
<script type="text/javascript" src="js/materialize.js"></script>
<script>
    $(document).ready(function () {

    });
</script>
</body>
</html>