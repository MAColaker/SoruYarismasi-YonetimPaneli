<?php
include '../network/baglan.php';

$sorgu = $db->prepare("select COUNT(soru_id) as adet from sorular WHERE sorular.statu = :statu");
$sorgu->execute(array(
    "statu" => 0
));
$toplam_soru = $sorgu->fetch(PDO::FETCH_ASSOC)["adet"];

?>

<aside id="left-sidebar-nav">
    <ul id="slide-out" class="side-nav fixed leftside-navigation">
        <li class="user-details cyan darken-2">
            <div class="row">
                <div class="col col s4 m4 l4">
                    <?php
                    if (strlen($kullanicicek['k_resim']) > 0) { ?>

                        <img class="circle responsive-img valign profile-image"
                             src="<?php echo $kullanicicek['k_resim']; ?>">

                    <?php } else { ?>


                        <img src="images/avatar.jpg" alt="" class="circle responsive-img valign profile-image">


                    <?php } ?>
                </div>
                <div class="col col s8 m8 l8">
                    <ul id="profile-dropdown" class="dropdown-content">
                        <li><a href="profil.php"><i class="mdi-action-face-unlock"></i> Profil</a>
                        </li>
                        <li><a href="kullaniciduzenle.php?kullanici=<?php echo $kullanicicek["kullanici_id"]?>"><i class="mdi-action-settings"></i> Hesap</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="logout.php"><i class="mdi-hardware-keyboard-tab"></i> Çıkış</a>
                        </li>
                    </ul>
                    <a class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" href="#"
                       data-activates="profile-dropdown"><?php echo $kullanicicek['k_adi']; ?><i
                                class="mdi-navigation-arrow-drop-down right"></i></a>
                    <p class="user-roal"><?php echo $kullanicicek['unvan'] ?></p>
                </div>
            </div>
        </li>
        <li class="bold"><a href="index.php" class="waves-effect waves-cyan"><i class="mdi-action-home"></i> Ana
                Sayfa</a>
        </li>
        <?php
        if (in_array("Kategori Görüntüleme", $yetkiListesi)) {
            ?>
            <li class="bold"><a href="kategoriler.php" class="waves-effect waves-cyan"><i
                            class="mdi-navigation-apps"></i>
                    Kategoriler</a>
            </li>
            <?php
        }
        if (in_array("Seviye Görüntüleme", $yetkiListesi)) {
            ?>
            <li class="bold"><a href="seviyeler.php" class="waves-effect waves-cyan"><i class="mdi-action-stars"></i>
                    Seviyeler</a>
            </li>
            <?php
        }
        if (in_array("Soru Görüntüleme", $yetkiListesi)) {
            ?>
            <li class="li-hover">
                <div class="divider"></div>
            </li>
            <li class="li-hover"><p class="ultra-small margin more-text">SORU</p></li>
            <li class="bold"><a href="soru.php" class="waves-effect waves-cyan"><i class="mdi-content-add-circle"></i>
                    Soru
                    Ekle</a>
            </li>
            <li class="bold"><a href="sorular.php" class="waves-effect waves-cyan"><i class="mdi-action-list"></i>
                    Sorular</a>
            </li>
            <li class="bold"><a href="taslak.php" class="waves-effect waves-cyan"><i
                            class="mdi-hardware-keyboard-control"></i> Onay
                    Bekleyenler<?php echo $toplam_soru ? '<span class="new badge">' . $toplam_soru . '</span>' : null ?>
                </a>
            </li>
            <?php
        }
        if (in_array("Oyuncu Görüntüleme", $yetkiListesi)) {
            ?>
            <li class="li-hover">
                <div class="divider"></div>
            </li>
            <li class="li-hover"><p class="ultra-small margin more-text">KULLANICI İŞLEMLERİ</p></li>
            <li class="bold"><a href="sorular.php" class="waves-effect waves-cyan"><i class="mdi-av-games"></i>
                    Oyuncular</a>
            </li>
            <?php
        }
        if (in_array("Kullanıcı Görüntüleme", $yetkiListesi)) {
            ?>
            <li class="bold"><a href="kullanicilar.php" class="waves-effect waves-cyan"><i
                            class="mdi-social-people"></i>
                    Kullanıcılar</a>
            </li>
            <?php
        }
        if (in_array("Unvan Görüntüleme", $yetkiListesi)) {
            ?>
            <li class="bold"><a href="unvanlar.php" class="waves-effect waves-cyan"><i
                            class="mdi-action-assignment-ind"></i>
                    Kullanıcı Unvanları</a>
            </li>
            <?php
        }
        if (in_array("Rol Görüntüleme", $yetkiListesi)) {
            ?>
            <li class="bold"><a href="roller.php" class="waves-effect waves-cyan"><i class="mdi-image-transform"></i>
                    Roller</a>
            </li>
            <?php
        }
        if (in_array("Yetki Görüntüleme", $yetkiListesi)) {
            ?>
            <li class="bold"><a href="yetkiler.php" class="waves-effect waves-cyan"><i
                            class="mdi-hardware-security"></i>
                    Yetkiler</a>
            </li>
            <?php
        }
        ?>
</aside>