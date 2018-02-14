<?php
	function addBookToDBFunc($sciezka, $nazwa, $autor, $ilosc, $opis){
		$conn = new mysqli('localhost', 'root', '');
		$temp = '';
		$sql1 = "use biblioteka";
		$sql2 = "insert into ksiazki values('', '".$nazwa."', '".$autor."', '".$opis."', '".$ilosc."', '".$sciezka."', 0)";
		
		if($conn->query($sql1) === TRUE){
			$results = $conn->query($sql2);
		}
		$conn->close();
	}
?>