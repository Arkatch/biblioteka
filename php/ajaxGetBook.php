<?php
	session_start();
	if(isset($_SESSION['valid'])){
		$conn = new mysqli('localhost', 'root', '');
		$temp = '';
		$id = $_POST['id'];
		$sql1 = "use biblioteka";
		$sql2 = " select tytul, autor, opis, ilosc, zdjecie  from ksiazki where id='".$id."' ";
		if($conn->query($sql1) === TRUE){
			$results = $conn->query($sql2);
			while($row = $results->fetch_assoc()) {
				$temp=$row["tytul"]."|".$row["autor"]."|".$row["opis"]."|".$row["ilosc"]."|".$row["zdjecie"]."|".$id;
			}
		}
		echo $temp;
		$conn->close();
	}
?>