<?php

include "baglan.php";

$kullanicisor=$db->prepare("select kullanici_id from kullanici where k_adi=:ad");
$kullanicisor->execute(array(
    'ad' => $_SESSION['k_adi']
));

$say=$kullanicisor->rowCount();

if ($say==0) {

    header("Location: ../yonetim/login.php?durum=izinsiz");
    exit;
}

//SELECT yetki.yetki FROM yetki,roller,unvan WHERE roller.yetki_id=yetki.yetki_id AND unvan.unvan_id=roller.unvan_id AND unvan.unvan_id=(SELECT kullanici.unvan_id FROM kullanici WHERE kullanici.kullanici_id=1)

?>
