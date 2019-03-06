<?php 
ob_start();
session_start();

if (isset($_SESSION['k_adi'])) {
	
	header("Location:yonetim/index.php");

} else {

	header("Location:yonetim/login.php");

}

?>