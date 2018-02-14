<?php
session_start();

	function buildSite($tit, $link, $liczba){
		return '<div class="block">
					<div class="imgB"><img src="'.$link.'" alt="brak zdjęcia"></div>
					<div class="title">'.$tit.'</div>
					<div class="borrow">'.$liczba.'</div>
				</div>';
	}
	if(isset($_SESSION['valid'])){
		$conn = new mysqli('localhost', 'root', '');
		$temp = '<div id="menu" class="block">
						<div class="imgB">Zdjęcie</div>
						<div class="title">Tytuł</div>
						<div class="borrow">Liczba wypożyczeń</div>
					</div>';
		$sql1 = "use biblioteka";
		$sql2 = "SELECT tytul, zdjecie, statystyka FROM ksiazki ORDER BY statystyka DESC";

		if($conn->query($sql1) === TRUE){
			$results = $conn->query($sql2);
			while($row = $results->fetch_assoc()) {
				$temp.=buildSite($row['tytul'], $row['zdjecie'], $row['statystyka']);
			}
		}
		$conn->close();
		echo $temp;
	}
?>
