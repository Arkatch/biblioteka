<?php
   session_start();
   
	if( isset($_SESSION['valid']) ){
   unset($_SESSION["username"]);
   unset($_SESSION["password"]);
   unset($_SESSION["valid"]);
   unset($_SESSION["login"]);
   
   echo 'Zostałeś poprawnie wylogowany!';
   header('Refresh: 2; URL = login.php');
	}
?>