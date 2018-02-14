<?php	
session_start();
	if( isset($_SESSION['valid']) ){
		$conn = new mysqli('localhost', 'root', '');
		$temp = '';
		$sql1 = "use biblioteka";
		$sql2 = "select id, tytul from ksiazki";
		if($conn->query($sql1) === TRUE){
			$results = $conn->query($sql2);
			while($row = $results->fetch_assoc()) {
				$temp.="<option value='".$row["id"]."'>".$row["id"].". ".$row["tytul"]."</option>";
			}
		}
		echo $temp;
		$conn->close();
	}
?>