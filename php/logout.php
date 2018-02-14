<?php
   session_start();
   
	if( isset($_SESSION['valid']) ){
   unset($_SESSION["username"]);
   unset($_SESSION["password"]);
   unset($_SESSION["valid"]);
   unset($_SESSION["login"]);
   
   echo '<script>alert(Zostałeś poprawnie wylogowany!);</script>';
   header('Refresh: 0; URL = ../php/login.php');
	}
?>