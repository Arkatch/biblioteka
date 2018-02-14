<?php
	function domTree($x, $availability){

		return'
			<div class="book">
				<div class="bookImg"><img src="'.$x['zdjecie'].'" alt="brak zdjęcia"></div>
				<div class="bookSpec">
					<div class="bookTitle">'.$x['tytul'].' </div>
					<span class="autor">Autor: '.$x['autor'].'<span>
					<hr>
					<div class="bookDescription">'.$x['opis'].'</div>
				</div>
				<span class="marg2"></span>
				'.$availability.'
				<span class="marg1"></span>
			</div>
			<hr class="hrRes">
			<br>';
	}
	$conn = new mysqli('localhost', 'root', '');
	$temp = '';
	$temp2 = '';
	
	//dwuwymiarowa tablica pierwszy wymiar zwraca tablie która na pozycji [0] ma id, a na pozycji [1] ile książek zostało wpożyczonych 
	$wypozyczoneKs = array();
	$sql1 = "use biblioteka";
	$sql2 = "select * from ksiazki";

	$sql_2 = "SELECT idKsiazki, COUNT(idKsiazki) AS wypozycz FROM wypozyczone GROUP BY idKsiazki";
	if($conn->query($sql1) === TRUE){
		
		$results = $conn->query($sql_2);
		if ($results->num_rows > 0) {
			$i=0;
			while($row = $results->fetch_assoc()) {
				$wypozyczoneKs[$i]=array($row['idKsiazki'], $row['wypozycz']);
				$i++;
			}
		}
		
		
		$results = $conn->query($sql2);
		if ($results->num_rows > 0) {
			while($row = $results->fetch_assoc()) {
				$ar = dostepne($row, $wypozyczoneKs);
				$ar[0] ? $temp.=domTree($row, $ar[1]) : $temp2.=domTree($row, $ar[1]);
				
			}
		}
	}
	$conn->close();
	echo $temp;
	echo $temp2;
	
	function dostepne($x, $tab){
		$nowaIlosc = $x['ilosc'];
		$arrayReturn = array();
		$j = count($tab);
		for($i=0;$i<$j;$i++){
			if($x['id'] == $tab[$i][0]){
				$nowaIlosc = $x['ilosc'] - $tab[$i][1];
			}
		}
		
		$availability = '<div class="availability">Dostępne, pozostało '.$nowaIlosc.' sztuk</div>';
		if($nowaIlosc<=0){
			$najblizszaData = "";
			$sql_1 = "use biblioteka";
			$sql_3 = 'SELECT dataZwrotu FROM wypozyczone WHERE idKsiazki='.$x["id"].' AND dataZwrotu >= CURDATE()  ORDER BY dataZwrotu limit 1';
			
			$con = new mysqli('localhost', 'root', '');
			
			$res;
			if($con->query($sql_1) === TRUE){
				$res = $con->query($sql_3);
				if ($res->num_rows > 0) {
					while($row = $res->fetch_assoc()) {
						$najblizszaData = $row["dataZwrotu"];
					}
				}
			
				$day = round((strtotime($najblizszaData) - strtotime(date("Y-m-d")))/86400);
				if($day>1){
					$day = ' ('.$day.' dni)';
				}else{
					$day = ' ('.$day.' dzień)';
				}
			
				$availability = '<div class="noavailability" id="availabilityRed">Niedostępne,<br>sprawdź dostępność w dniu:<br> '.$najblizszaData.$day.'</div>';
			}
			$con->close();
			$arrayReturn[0] = false;
			$arrayReturn[1] = $availability;
			return $arrayReturn;
			
		}else{
			$arrayReturn[0] = true;
			$arrayReturn[1] = $availability;
			return $arrayReturn;
		}
	}
?>

