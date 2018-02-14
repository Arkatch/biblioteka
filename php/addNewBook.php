<?php
include 'addBookToDB.php';
session_start();
	function uploadImg(){
		$target_dir = "images/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = true;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		// sprawdź czy plik to zdjęcie
		if(isset($_POST["submit"])) {
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if($check !== false) {
				echo "File is an image - " . $check["mime"] . ".";
				$uploadOk = true;
			} else {
				return false;
			}
		}
		
		//Jeżeli nazwa pliku istnieje to wylosuj nową nazwę 
		if (file_exists($target_file)) {
			$rand = rand(1, 1000000000);
			$target_file = $target_dir . $rand .basename($_FILES["fileToUpload"]["name"]);
		}
		// Czy się wrzuciło
		if ($uploadOk == false) {
			return false;
		// jak tak to przenieś 
		} else {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				return basename( $_FILES["fileToUpload"]["name"]);
			} else {
				return false;
			}
		}
	}
	if(isset($_SESSION['valid']) ){
		$nazwaKsi = "";
		$autorKsi = "";
		$iloscKsi = "";
		$opisKsi = "";
		$x = '';
		isset($_POST["bookName"]) ? $nazwaKsi =$_POST["bookName"] : false;
		isset($_POST["autorBook"]) ? $autorKsi = $_POST["autorBook"] : false;
		isset($_POST["amountBook"]) ? $iloscKsi = $_POST["amountBook"] : false;
		isset($_POST["descBook"]) ? $opisKsi = $_POST["descBook"] : false;
		if($nazwaKsi and $autorKsi and $iloscKsi and $opisKsi){
			$x = uploadImg();
		}
		if($x){
			$filePath = "/php/images/".$x; //ścieżka do zdjęcia
			if($filePath and $nazwaKsi and $autorKsi and $iloscKsi and $opisKsi){
				addBookToDBFunc($filePath, $nazwaKsi, $autorKsi, $iloscKsi, $opisKsi);
				echo '<script>alert("Książka została dodana.")</script>';
			header('Refresh: 0; URL = /php/adminPanel.php');
			}else{
				echo "Coś poszło nie tak.";
			}
		}else{
			echo "Coś poszło nie tak.";
		}
	}else{
		echo 'Coś poszło nie tak.';
	}
?>