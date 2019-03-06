<?php
ob_start();
session_start();
include 'baglan.php';

$yetkiListesi = array();

if (!isset($_POST['giris']))
    include 'kontrol.php';

if (isset($_POST['giris'])) {

    $k_adi = $_POST['k_adi'];
    $k_sifre = md5($_POST['k_sifre']);

    if ($k_adi && $k_sifre) {

        $kullanicisor = $db->prepare("SELECT * from kullanici where k_adi=:ad and k_sifre=:sifre and statu=:statu");
        $kullanicisor->execute(array(
            'ad' => $k_adi,
            'sifre' => $k_sifre,
            'statu' => 1
        ));

        $say = $kullanicisor->rowCount();

        if ($say > 0) {

            $_SESSION['k_adi'] = $k_adi;

            header('Location:../yonetim/index.php');

        } else {

            header('Location:../yonetim/login.php?durum=no');

        }
    }

}

$kullanicicek = $kullanicisor->fetch(PDO::FETCH_ASSOC);

$yetkisorgu = $db->prepare("SELECT yetki.yetki as yetki FROM yetki,roller,unvan WHERE roller.yetki_id=yetki.yetki_id AND unvan.unvan_id=roller.unvan_id AND unvan.unvan_id=(SELECT kullanici.unvan_id FROM kullanici WHERE kullanici.kullanici_id=:kullanici_id)");
$yetkisorgu->execute(array(
    "kullanici_id" => $kullanicicek["kullanici_id"]
));

foreach ($yetkisorgu as $satir)
    $yetkiListesi[] = $satir["yetki"];


if (isset($_POST['soruekle'])) {

    if (in_array("Soru Ekleme", $yetkiListesi) == null) {
        Header("Location:../yonetim/index.php?durum=yetkisiz");
        return;
    }

    $kaydet = $db->prepare("INSERT INTO sorular SET
		soru=:soru,
        kullanici_id=:kullanici_id,
        kategori_id=:kategori_id,
        seviye_id=:seviye_id,               
		dogru_cevap=:dogru_cevap,
		cevap_1=:cevap_1,
		cevap_2=:cevap_2,
		cevap_3=:cevap_3,
		ek_1=:ek_1,
		ek_2=:ek_2,
		statu=:statu");
    $insert = $kaydet->execute(array(
        'soru' => $_POST['soru'],
        'kullanici_id' => $_POST['kullanici_id'],
        'kategori_id' => $_POST['kategori'],
        'seviye_id' => $_POST['seviye'],
        'dogru_cevap' => $_POST['dogru_cevap'],
        'cevap_1' => $_POST['cevap_1'],
        'cevap_2' => $_POST['cevap_2'],
        'cevap_3' => $_POST['cevap_3'],
        'ek_1' => $_POST['ek_1'],
        'ek_2' => $_POST['ek_2'],
        'statu' => "1"
    ));

    if ($insert) {

        Header("Location:../yonetim/soru.php?durum=ok");

    } else {

        Header("Location:../yonetim/soru.php?durum=no");
    }

} elseif (isset($_POST['soruduzenle'])) {

    if (in_array("Soru Düzenleme", $yetkiListesi) == null) {
        Header("Location:../yonetim/index.php?durum=yetkisiz");
        return;
    }

    $kaydet = $db->prepare("UPDATE sorular SET
		soru=:soru,
        kategori_id=:kategori_id,
        seviye_id=:seviye_id,               
		dogru_cevap=:dogru_cevap,
		cevap_1=:cevap_1,
		cevap_2=:cevap_2,
		cevap_3=:cevap_3,
		ek_1=:ek_1,
		ek_2=:ek_2,
		statu=:statu
        WHERE soru_id={$_POST['soru_id']}");
    $insert = $kaydet->execute(array(
        'soru' => $_POST['soru'],
        'kategori_id' => $_POST['kategori'],
        'seviye_id' => $_POST['seviye'],
        'dogru_cevap' => $_POST['dogru_cevap'],
        'cevap_1' => $_POST['cevap_1'],
        'cevap_2' => $_POST['cevap_2'],
        'cevap_3' => $_POST['cevap_3'],
        'ek_1' => $_POST['ek_1'],
        'ek_2' => $_POST['ek_2'],
        'statu' => $_POST['statu'] ? 1 : 0
    ));

    $soru_id = $_POST['soru_id'];

    if ($insert) {

        Header("Location:../yonetim/soruduzenle.php?soru=$soru_id&durum=ok");

    } else {

        Header("Location:../yonetim/soruduzenle.php?soru=$soru_id&durum=no");
    }

} elseif (isset($_POST['soruyayimla'])) {

    if (in_array("Soru Düzenleme", $yetkiListesi) != 1) {
        //Header("Location:../yonetim/index.php?durum=yetkisiz");
        return;
    }

    $kaydet = $db->prepare("UPDATE sorular SET		
		statu=:statu
        WHERE soru_id={$_POST['soru']}");
    $insert = $kaydet->execute(array(
        'statu' => 1
    ));

    $soru_id = $_POST['soru'];

    if ($insert) {

        Header("Location:../yonetim/taslak.php");

    } else {

        Header("Location:../yonetim/soruduzenle.php?soru=$soru_id&durum=no");
    }

} elseif (isset($_POST['kategoriekle'])) {

    if (in_array("Kategori Ekleme", $yetkiListesi) == null) {
        Header("Location:../yonetim/index.php?durum=yetkisiz");
        return;
    }

    $kaydet = $db->prepare("INSERT INTO kategori SET
		kategori=:kategori,        
		ust_id=:ust_id");
    $insert = $kaydet->execute(array(
        'kategori' => $_POST['kategori'],
        'ust_id' => $_POST['ust_id']
    ));

    if ($insert) {

        Header("Location:../yonetim/kategoriler.php?durum=ok");

    } else {

        Header("Location:../yonetim/kategoriler.php?durum=no");
    }

} elseif (isset($_POST['kategoriduzenle'])) {

    if (in_array("Kategori Düzenleme", $yetkiListesi) == null) {
        Header("Location:../yonetim/index.php?durum=yetkisiz");
        return;
    }

    $kategori_id = $_POST['kategori_id'];
    $kaydet = $db->prepare("UPDATE kategori SET
		kategori=:kategori,        
		ust_id=:ust_id where kategori_id=:kategori_id");
    $insert = $kaydet->execute(array(
        'kategori' => $_POST['kategori'],
        'kategori_id' => $kategori_id,
        'ust_id' => $_POST['ust_id']
    ));

    if ($insert) {

        Header("Location:../yonetim/kategoriduzenle.php?kategori=$kategori_id&durum=ok");

    } else {

        Header("Location:../yonetim/kategoriduzenle.php?kategori=$kategori_id&durum=no");
    }

} elseif (isset($_POST['seviye_ekle'])) {

    if (in_array("Seviye Ekleme", $yetkiListesi) == null) {
        Header("Location:../yonetim/index.php?durum=yetkisiz");
        return;
    }

    $kaydet = $db->prepare("INSERT INTO seviye SET seviye=:seviye");
    $insert = $kaydet->execute(array(
        'seviye' => $_POST['seviye']
    ));

    if ($insert) {

        Header("Location:../yonetim/seviyeler.php?durum=ok");

    } else {

        Header("Location:../yonetim/seviyeler.php?durum=no");
    }

} elseif (isset($_POST['seviyeduzenle'])) {

    if (in_array("Seviye Düzenleme", $yetkiListesi) == null) {
        Header("Location:../yonetim/index.php?durum=yetkisiz");
        return;
    }

    $seviye_id = $_POST['seviye_id'];
    $kaydet = $db->prepare("UPDATE seviye SET
		seviye=:seviye where seviye_id=:seviye_id");
    $insert = $kaydet->execute(array(
        'seviye' => $_POST['seviye'],
        'seviye_id' => $seviye_id
    ));

    if ($insert) {

        Header("Location:../yonetim/seviyeduzenle.php?seviye=$seviye_id&durum=ok");

    } else {

        Header("Location:../yonetim/seviyeduzenle.php?seviye=$seviye_id&durum=no");
    }

} elseif (isset($_POST['unvan_ekle'])) {

    if (in_array("Unvan Ekleme", $yetkiListesi) == null) {
        Header("Location:../yonetim/index.php?durum=yetkisiz");
        return;
    }

    $kaydet = $db->prepare("INSERT INTO unvan SET unvan=:unvan");
    $insert = $kaydet->execute(array(
        'unvan' => $_POST['unvan']
    ));

    if ($insert) {

        Header("Location:../yonetim/unvanlar.php?durum=ok");

    } else {

        Header("Location:../yonetim/unvanlar.php?durum=no");
    }

} elseif (isset($_POST['unvanduzenle'])) {

    if (in_array("Unvan Düzenleme", $yetkiListesi) == null) {
        Header("Location:../yonetim/index.php?durum=yetkisiz");
        return;
    }

    $unvan_id = $_POST['unvan_id'];
    $kaydet = $db->prepare("UPDATE unvan SET
		unvan=:unvan where unvan_id=:unvan_id");
    $insert = $kaydet->execute(array(
        'unvan' => $_POST['unvan'],
        'unvan_id' => $unvan_id
    ));

    if ($insert) {

        Header("Location:../yonetim/unvanduzenle.php?unvan=$unvan_id&durum=ok");

    } else {

        Header("Location:../yonetim/unvanduzenle.php?unvan=$unvan_id&durum=no");
    }

} elseif (isset($_POST['yetkiekle'])) {

    if (in_array("Yetki Ekleme", $yetkiListesi) == null) {
        Header("Location:../yonetim/index.php?durum=yetkisiz");
        return;
    }

    $kaydet = $db->prepare("INSERT INTO yetki SET
		yetki=:yetki");
    $insert = $kaydet->execute(array(
        'yetki' => $_POST['yetki']
    ));

    if ($insert) {

        Header("Location:../yonetim/yetkiler.php?durum=ok");

    } else {

        Header("Location:../yonetim/yetkiler.php?durum=no");
    }

} elseif (isset($_POST['yetkiduzenle'])) {

    if (in_array("Yetki Düzenleme", $yetkiListesi) == null) {
        Header("Location:../yonetim/index.php?durum=yetkisiz");
        return;
    }

    $yetki_id = $_POST['yetki_id'];
    $kaydet = $db->prepare("UPDATE yetki SET
		yetki=:yetki where yetki_id=:yetki_id");
    $insert = $kaydet->execute(array(
        'yetki' => $_POST['yetki'],
        'yetki_id' => $yetki_id
    ));

    if ($insert) {

        Header("Location:../yonetim/yetkiduzenle.php?yetki=$yetki_id&durum=ok");

    } else {

        Header("Location:../yonetim/yetkiduzenle.php?yetki=$yetki_id&durum=no");
    }

} elseif (isset($_POST['roller'])) {

    if (in_array("Rol Ekleme", $yetkiListesi) == null) {
        Header("Location:../yonetim/index.php?durum=yetkisiz");
        return;
    }

    $yetki_id = $_POST['yetki_id'];
    $unvan_id = $_POST['unvan_id'];
    $roller = $db->prepare("select * from roller where unvan_id='$unvan_id' and yetki_id='$yetki_id'");
    $roller->execute();

    if ($roller->fetchColumn() != 0) {
        Header("Location:../yonetim/roller.php?durum=hata");
        return 0;
    }

    $kaydet = $db->prepare("INSERT INTO roller SET
		unvan_id=:unvan_id,
		yetki_id=:yetki_id ");
    $insert = $kaydet->execute(array(
        'yetki_id' => $_POST['yetki_id'],
        'unvan_id' => $_POST['unvan_id']
    ));

    if ($insert) {

        Header("Location:../yonetim/roller.php?durum=ok");

    } else {

        Header("Location:../yonetim/roller.php?durum=no");
    }

} elseif (isset($_POST['resimduzenle'])) {

    $kullanici_id = $_POST['kullanici_id'];

    if ($kullanicicek["kullanici_id"] != $kullanici_id)
        if (in_array("Kullanıcı Düzenleme", $yetkiListesi) == null) {
            Header("Location:../yonetim/index.php?durum=yetkisiz");
            return;
        }

    $kullanici = $db->prepare("select k_adi from kullanici where kullanici_id=:kullanici_id");
    $kullanici->execute(array(
        "kullanici_id" => $kullanici_id
    ));
    $kullanicibilgileri = $kullanici->fetch(PDO::FETCH_ASSOC);

    $klasoradi = "../resimler/profil/" . $kullanicibilgileri["k_adi"];
    if (!file_exists($klasoradi))
        mkdir($klasoradi);

    $dizin = '../resimler/profil/' . $kullanicibilgileri["k_adi"] . '/';
    $yuklenecek_dosya = $dizin . basename($_FILES['k_resim']['name']);

    $kontrol = getimagesize($_FILES["k_resim"]["tmp_name"]);

    if ($kontrol=="")
        $yuklenecek_dosya = "../resimler/yeshil.jpg";

    move_uploaded_file($_FILES['k_resim']['tmp_name'], $yuklenecek_dosya);

    $ayarkaydet = $db->prepare("UPDATE kullanici SET
            k_resim=:k_resim
			WHERE kullanici_id=:kullanici_id");
    $update = $ayarkaydet->execute(array(
        'k_resim' => $yuklenecek_dosya,
        'kullanici_id' => $kullanici_id
    ));


    if ($update) {
        unlink($kullanicibilgileri["k_resim"]);
        Header("Location:../yonetim/kullaniciduzenle.php?kullanici=$kullanici_id&resim=ok");

    } else {

        Header("Location:../yonetim/kullaniciduzenle.php?kullanici=$kullanici_id&resim=no");
    }

}elseif (isset($_POST['kullaniciduzenle'])) {

    $kullanici_id = $_POST['kullanici_id'];

    if ($kullanicicek["kullanici_id"] != $kullanici_id)
        if (in_array("Kullanıcı Düzenleme", $yetkiListesi) == null) {
            Header("Location:../yonetim/index.php?durum=yetkisiz");
            return;
        }

    $kullanici = $db->prepare("select * from kullanici where kullanici_id=:kullanici_id");
    $kullanici->execute(array(
        "kullanici_id" => $kullanici_id
    ));
    $kullanicibilgileri = $kullanici->fetch(PDO::FETCH_ASSOC);

    $sorgu = $db->prepare("UPDATE kullanici SET
            isim=:isim,
            k_adi=:k_adi,            
            k_mail=:k_mail,
            k_sifre=:k_sifre,
            unvan_id=:unvan_id
			WHERE kullanici_id=:kullanici_id");
    $update = $sorgu->execute(array(
        'isim' => $_POST["isim"],
        'k_adi' => $k_adi = $_POST["k_adi"]== null ? $kullanicibilgileri["k_adi"] : $_POST["k_adi"],
        'k_mail' => $_POST["k_mail"],
        'k_sifre' => $k_sifre = $_POST["k_sifre"]=="" ? $kullanicibilgileri["k_sifre"] : md5($_POST["k_sifre"]),
        'unvan_id' => $unvan_id = $_POST["unvan_id"]== null ? $kullanicibilgileri["unvan_id"] : $_POST["unvan_id"],
        'kullanici_id' => $kullanici_id
    ));

    if ($update) {

        Header("Location:../yonetim/kullaniciduzenle.php?kullanici=$kullanici_id&durum=ok");

    } else {

        Header("Location:../yonetim/kullaniciduzenle.php?kullanici=$kullanici_id&durum=no");
    }
}


?>



