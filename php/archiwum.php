<?php
session_start();
function archBuild($id, $title, $imie, $klasa, $dataW, $dataZ){
	if(strtotime($dataZ)==strtotime("0000-00-00")){
		return '<div class="cont"><div class="lp">'.$id.'</div><div class="bookName">'.$title.'</div> <div class="wypozyczono">'.$dataW.'</div> <div class="zwrot">Nie oddano</div> <div class="ktoWyp">'.$imie.'</div> <div class="klasa">'.$klasa.'</div></div>';
	}else{
		return '<div class="cont"><div class="lp">'.$id.'</div><div class="bookName">'.$title.'</div> <div class="wypozyczono">'.$dataW.'</div> <div class="zwrot">'.$dataZ.'</div> <div class="ktoWyp">'.$imie.'</div> <div class="klasa">'.$klasa.'</div></div>';
	}
}
if( isset($_SESSION['valid']) ){
	$conn = new mysqli('localhost', 'root', '');
	$temp = '<div id="frirstDiv" class="cont"><div class="lp">lp.</div><div class="bookName">Tytuł</div> <div class="wypozyczono">Data wypożyczenia</div> <div class="zwrot">Data zwrotu</div> <div class="ktoWyp">Wypożyczający</div> <div class="klasa">Klasa</div> </div>';
	$title = "";
	$sql1 = "use biblioteka";	
	$sql2 = "select * from archiwum order by id desc";
	if($conn->query($sql1) === TRUE){
		$res = $conn->query($sql2);
			while($row = $res->fetch_assoc()) 
			{
				$temp.= archBuild($row['id'], $row['tytulKsiazki'], $row['imienazwisko'], $row['klasa'], $row['dataWpozyczenia'], $row['dataZwrotu']);
			}
	}
	$conn->close();
	echo $temp;
}
?>