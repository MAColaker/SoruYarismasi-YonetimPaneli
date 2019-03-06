<?php
ob_start();
session_start();
include '../network/baglan.php';
date_default_timezone_set('Europe/Istanbul');

$kullanicisor=$db->prepare("select kullanici.*,unvan.unvan from kullanici INNER JOIN unvan on kullanici.unvan_id = unvan.unvan_id where k_adi=:ad");
$kullanicisor->execute(array(
  'ad' => $_SESSION['k_adi']
  ));

$say=$kullanicisor->rowCount();

if ($say==0) {

 header("Location:login.php?durum=izinsiz");
 exit;
}

$kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC);

$yetkisorgu = $db->prepare("SELECT yetki.yetki as yetki FROM yetki,roller,unvan WHERE roller.yetki_id=yetki.yetki_id AND unvan.unvan_id=roller.unvan_id AND unvan.unvan_id=(SELECT kullanici.unvan_id FROM kullanici WHERE kullanici.kullanici_id=:kullanici_id)");
$yetkisorgu->execute(array(
    "kullanici_id" => $kullanicicek["kullanici_id"]
));

$yetkiListesi = array();

foreach ($yetkisorgu as $satir)
    $yetkiListesi[]=$satir["yetki"];
?>
<header id="header" class="page-topbar">
        <!-- start header nav-->
        <div class="navbar-fixed">
            <nav class="navbar-color">
                <div class="nav-wrapper">
                    <ul class="left">                      
                      <li><h1 class="logo-wrapper"><a href="index.php" class="brand-logo darken-1"> <span>İslami Yarışma</span></a></h1></li>
                    </ul>
                    <div class="header-search-wrapper hide-on-med-and-down">
                        <i class="mdi-action-search"></i>
                        <input type="text" name="Search" class="header-search-input z-depth-2" placeholder="Aranacak İçerik"/>
                    </div>                   
                    
                </div>
            </nav>
        </div>
        <!-- end header nav-->
  </header>