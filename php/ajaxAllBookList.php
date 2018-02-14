<?php
	session_start();
	function ileDostepnych($id){
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
	if(isset($_SESSION['valid'])){
		$conn = new mysqli('localhost', 'root', '');
		$temp = '';
		$sql1 = "use biblioteka";
		$sql2 = "select id, tytul, autor, ilosc, statystyka from ksiazki";
		if($conn->query($sql1) === TRUE){
			$results = $conn->query($sql2);
			while($row = $results->fetch_assoc()) {
				$tempCount = ileDostepnych($row["id"]);
				$temp.=$row["tytul"]."|".$row["autor"]."|".$row["ilosc"]."|".$tempCount."|".$row["statystyka"]."|".$row["id"]."---";
			}
		}
		echo $temp;
		$conn->close();
	}
?>