<?php 
ob_start();
session_start();
include 'baglan.php';


if (!empty($_FILES)) {
	
	/*$temp=$_FILES['file']['tmp_name'];
	$dir_separator = DIRECTORY_SEPARATOR;
	$folder ="uploads";
	$destination_path=dirname(__FILE__).$dir_separator.$folder.$dir_separator;
	$target_path=$destination_path.$_FILES['file']['name'];
	move_uploaded_file($temp, $target_path);

	*/

	$uploads_dir = '../../dimg/galeri';
	@$tmp_name = $_FILES['file']["tmp_name"];
	@$name = $_FILES['file']["name"];
	$benzersizsayi1=rand(20000,32000);
	$benzersizsayi2=rand(20000,32000);
	$benzersizsayi3=rand(20000,32000);
	$benzersizsayi4=rand(20000,32000);
	$benzersizad=$benzersizsayi1.$benzersizsayi2.$benzersizsayi3.$benzersizsayi4;
	$refimgyol=substr($uploads_dir, 6)."/".$benzersizad.$name;
	@move_uploaded_file($tmp_name, "$uploads_dir/$benzersizad$name");

	$kaydet=$db->prepare("INSERT INTO galeri SET
		galeri_resimyol=:resimyol");
	$insert=$kaydet->execute(array(
		'resimyol' => $refimgyol
		));

}


?>