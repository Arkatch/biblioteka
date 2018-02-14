<?php
session_start();
	include 'const.php';
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
			$rand = md5_file($target_file);
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
	function updateValueDB($nazwaKsiRef, $autorKsiRef, $iloscKsiRef, $opisKsiRef, $idKsiRef, $linkFileRef){
		$conn = new mysqli('localhost', 'root', '');
		$sql1 = "use biblioteka";
		$sql2 = "UPDATE ksiazki SET tytul='".$nazwaKsiRef."', autor='".$autorKsiRef."', opis='".$opisKsiRef."', ilosc='".$iloscKsiRef."', zdjecie='".$linkFileRef."' WHERE id='".$idKsiRef."' ";
		if($conn->query($sql1) === TRUE){
			$results = $conn->query($sql2);
		}
		$conn->close();
	}
	if(isset($_SESSION['valid']) ){
		$linkFile = "";
		
		
		$nazwaKsi = "";
		$autorKsi = "";
		$iloscKsi = "";
		$opisKsi = "";
		$idKsi = "";
		isset($_POST["bookIdF"]) ? $idKsi = $_POST["bookIdF"] : false;
		isset($_POST["bookName"]) ? $nazwaKsi =$_POST["bookName"] : false;
		isset($_POST["autorBook"]) ? $autorKsi = $_POST["autorBook"] : false;
		isset($_POST["amountBook"]) ? $iloscKsi = $_POST["amountBook"] : false;
		isset($_POST["descBook"]) ? $opisKsi = $_POST["descBook"] : false;

		if($nazwaKsi and $autorKsi and $iloscKsi and $opisKsi and $idKsi){
			$linkFile = uploadImg();
			$linkFile ? $linkFile=PHOTOPATH.$linkFile : $linkFile = $_POST['oldImgF'];
			echo '<script>alert("Książka została zaktualizowana.")</script>';
			header('Refresh: 0; URL = adminPanel.php');
		}
		if($linkFile){
			updateValueDB($nazwaKsi, $autorKsi, $iloscKsi, $opisKsi, $idKsi, $linkFile);
		}else{
			echo '<script>alert("Coś poszło nie tak.");</script>';
			header('Refresh: 0; URL = login.php');
		}
	}
?>