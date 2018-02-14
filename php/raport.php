<?php
session_start();
function raportBuild($idRec, $id, $imie, $klasa, $wypoz, $zwrot){
	$day = round((strtotime($zwrot) - strtotime(date("Y-m-d")))/86400);
	$conn = new mysqli('localhost', 'root', '');
	$sql1 = "use biblioteka";	
	$sql2 = "select tytul from ksiazki where id=".$id."";
	$tytul = "";
	$red = "";
	if($conn->query($sql1) === TRUE)
	{
		$res = $conn->query($sql2);
		while($row = $res->fetch_assoc()) 
		{
			$tytul = $row['tytul'];
		}
	}
	if($day<=0){
		$red = '<div class="dniDoZwrotuR">'.$day.'</div>';
	}else{
		$red = '<div class="dniDoZwrotu">'.$day.'</div>';
	}
	return '<div class="cont"><div class="bookName">'.$tytul.'</div> <div class="wypozyczono">'.$wypoz.'</div> <div class="zwrot">'.$zwrot.'</div>'.$red.'<div class="ktoWyp">'.$imie.'</div> <div class="klasa">'.$klasa.'</div> <div class="usun"><input class="but" onclick="ajaxDelRecord(this.id)" type="button" id="'.$idRec.'" value="Oddano" > </div> <div class="usunAll"><input class="but" onclick="ajaxDelRecordFromArch(this.id)" type="button" id="'.$idRec.'" value="Usuń" > </div> </div>';
}
if( isset($_SESSION['valid']) ){
	$conn = new mysqli('localhost', 'root', '');
	$temp = '<div id="frirstDiv" class="cont"><div class="bookName">Tytuł</div> <div class="wypozyczono">Data wypożyczenia</div> <div class="zwrot">Przewidywana data zwrotu</div> <div class="dniDoZwrotu">Dni do zwrotu</div> <div class="ktoWyp">Wypożyczający</div> <div class="klasa">Klasa</div> <div class="usun">Zwrot</div> <div class="usunAll">Usuń</div> </div>';
	$sql1 = "use biblioteka";	
	$sql2 = "select * from wypozyczone order by id desc";
	if($conn->query($sql1) === TRUE){
		$res = $conn->query($sql2);
		if ($res->num_rows > 0) 
		{
			while($row = $res->fetch_assoc()) 
			{
				$temp.= raportBuild($row['id'], $row['idKsiazki'], $row['imienazwisko'], $row['klasa'], $row['dataWpozyczenia'], $row['dataZwrotu']);
			}
		}
	}
	$conn->close();
	echo $temp;
}else{
	echo '<script>alert("Coś poszło nie tak.");</script>';
	header('Refresh: 0; URL = login.php');
}
?>