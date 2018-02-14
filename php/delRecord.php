<?php
	session_start();
	if( isset($_SESSION['valid']) ){
		$conn = new mysqli('localhost', 'root', '');
		$sql1 = "use biblioteka";	
		$sql2 = 'DELETE FROM wypozyczone WHERE id="'.$_POST["id"].'"';
		if($conn->query($sql1) === TRUE)
		{
			$res = $conn->query($sql2);
		}
	}
?>