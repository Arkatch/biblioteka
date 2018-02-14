<?php
include 'const.php';
session_start();
	function addToDB($refDataWy, $refDataOd, $refImie, $refKlas, $refIdksiazki){
		$conn = new mysqli('localhost', 'root', '');
		$temp = '';
		$sql1 = "use biblioteka";
		$sql2 = "insert into  wypozyczone values('', '".$refIdksiazki."', '".$refImie."', '".$refKlas."', '".$refDataWy."', '".$refDataOd."')";
		$sql3 = "UPDATE ksiazki SET statystyka=statystyka+1 WHERE id=".$refIdksiazki."";
		
		
		$sql5 = "select tytul from ksiazki where id=".$refIdksiazki." ";
		if($conn->query($sql1) === TRUE){
			$conn->query($sql2);
			$conn->query($sql3);
			
			$results = $conn->query($sql5);
			$tytul;
			while($row = $results->fetch_assoc()) 
			{
				$tytul = $row['tytul'];
			}
			$sql4 = " insert into  archiwum values('', '".$refIdksiazki."', '".$tytul."' , '".$refImie."', '".$refKlas."', '".$refDataWy."', '-') ";
			$conn->query($sql4);
		}
		$conn->close();		
	}
	function canBorrow($id){
		if(!$id){
			return -1;
		}
		$conn = new mysqli('localhost', 'root', '');
		$ile = 0;
		$max = 0;
		$sql1 = "use biblioteka";
		$sql2 = "SELECT idKsiazki, COUNT(idKsiazki) AS wypozycz FROM wypozyczone WHERE idKsiazki=".$id."";
		$sql3 = "SELECT ilosc FROM ksiazki WHERE id=".$id."";
		if($conn->query($sql1) === TRUE){
			$results = $conn->query($sql2);
			while($row = $results->fetch_assoc()) 
			{
			$ile = $row['wypozycz'];
			}
		}
		if($conn->query($sql1) === TRUE){
			$results = $conn->query($sql3);
			while($row = $results->fetch_assoc()) 
			{
			$max = $row['ilosc'];
			}
		}
		
		$conn->close();	
		return $max-$ile;
	}

	if(isset($_SESSION['valid']) ){
		$dataWy = '';
		$dataOd = '';
		$imie = '';
		$klas = '';
		$idksiazki = false;
		isset($_POST['dataWypoz']) ? $dataWy = $_POST['dataWypoz'] : false;
		isset($dataWy) ? $dataOd = date('Y-m-d', strtotime($dataWy.'+'.DNI.' days')) : false;
		isset($_POST['imienazwisko']) ? $imie = $_POST['imienazwisko'] : false;
		isset($_POST['klasa']) ? $klas = $_POST['klasa'] : false;
		
		if(isset($_POST['idKsiazki']) and $_POST['idKsiazki']>0)
			$idksiazki = $_POST['idKsiazki'];
		if(canBorrow($idksiazki)<=0){
			echo '<script>alert("Brak książek do wypożyczenia!")</script>';
			header('Refresh: 0; URL = /php/adminPanel.php');
			return;
		}
		
		if($dataWy and $dataOd and $imie and $klas and $idksiazki){
			addToDB($dataWy, $dataOd, $imie, $klas, $idksiazki);
			echo '<script>alert("Książka została wypożyczona.")</script>';
			header('Refresh: 0; URL = /php/adminPanel.php');
		}else{
			echo 'Coś poszło nie tak.';
		}
		
			
	}else{
		echo 'Coś poszło nie tak.';
	}
	
	
?>