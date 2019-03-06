<?php
ob_start();
session_start();


$api_key = "c1dcb4cb-4161-4d4e-b8ba-059d49060ccde9bdfc0d-4a9d-43bc-960d-bb6bbba71d99";
if(isset($_SESSION['k_adi']))
    $_POST['api_key'] = $api_key;


if (isset($_POST['tag']) && $_POST['tag'] != '' && $_POST['api_key'] == $api_key) {
    $tag = $_POST['tag'];

    include 'baglan.php';

    if ($tag == 'soru_sil') {

        $soru_id=$_POST['soru_id'];

        $sil = $db->prepare("DELETE from sorular where soru_id=:soru_id");
        $kontrol = $sil->execute(array(
            'soru_id' => $soru_id
        ));

        if ($kontrol) {

            echo json_encode(true);

        } else {

            echo json_encode(false);
        }

    }elseif ($tag == 'kategori_sil') {

        $kategori_id=$_POST['kategori_id'];

        $sil = $db->prepare("DELETE from kategori where kategori_id=:kategori_id");
        $kontrol = $sil->execute(array(
            'kategori_id' => $kategori_id
        ));

        if ($kontrol) {

            echo json_encode(true);

        } else {

            echo json_encode(false);
        }

    }elseif ($tag == 'seviye_sil') {

        $seviye_id=$_POST['seviye_id'];

        $sil = $db->prepare("DELETE from seviye where seviye_id=:seviye_id");
        $kontrol = $sil->execute(array(
            'seviye_id' => $seviye_id
        ));

        if ($kontrol) {

            echo json_encode(true);

        } else {

            echo json_encode(false);
        }

    }elseif ($tag == 'unvan_sil') {

        $unvan_id=$_POST['unvan_id'];

        $sil = $db->prepare("DELETE from unvan where unvan_id=:unvan_id");
        $kontrol = $sil->execute(array(
            'unvan_id' => $unvan_id
        ));

        if ($kontrol) {

            echo json_encode(true);

        } else {

            echo json_encode(false);
        }

    }elseif ($tag == 'yetki_sil') {

        $yetki_id=$_POST['yetki_id'];

        $sil = $db->prepare("DELETE from yetki where yetki_id=:yetki_id");
        $kontrol = $sil->execute(array(
            'yetki_id' => $yetki_id
        ));

        if ($kontrol) {

            echo json_encode(true);

        } else {

            echo json_encode(false);
        }

    }elseif ($tag == 'rol_sil') {

        $roller_id=$_POST['rol_id'];

        $sil = $db->prepare("DELETE from roller where roller_id=:roller_id");
        $kontrol = $sil->execute(array(
            'roller_id' => $roller_id
        ));

        if ($kontrol) {

            echo json_encode(true);

        } else {

            echo json_encode(false);
        }

    }elseif ($tag == 'rol_sil') {

        $roller_id=$_POST['rol_id'];

        $sil = $db->prepare("DELETE from roller where roller_id=:roller_id");
        $kontrol = $sil->execute(array(
            'roller_id' => $roller_id
        ));

        if ($kontrol) {

            echo json_encode(true);

        } else {

            echo json_encode(false);
        }

    }elseif ($tag == 'kullanici_engelle') {

        $kullanici_id=$_POST['kullanici_id'];

        $sil = $db->prepare("UPDATE kullanici SET statu=:statu WHERE kullanici_id=:kullanici_id");
        $kontrol = $sil->execute(array(
            'kullanici_id' => $kullanici_id,
            'statu' => 0
        ));

        if ($kontrol) {

            echo json_encode(true);

        } else {

            echo json_encode(false);
        }

    }elseif ($tag == 'kullanici_etkin') {

        $kullanici_id=$_POST['kullanici_id'];

        $sil = $db->prepare("UPDATE kullanici SET statu=:statu WHERE kullanici_id=:kullanici_id");
        $kontrol = $sil->execute(array(
            'kullanici_id' => $kullanici_id,
            'statu' => 1
        ));

        if ($kontrol) {

            echo json_encode(true);

        } else {

            echo json_encode(false);
        }

    }
}
?>
