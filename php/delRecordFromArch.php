<?php
	session_start();
	if( isset($_SESSION['valid']) ){
		$conn = new mysqli('localhost', 'root', '');
		$sql1 = "use biblioteka";	
		$sql2 = 'DELETE FROM wypozyczone WHERE id="'.$_POST["id"].'"';
		$sql3 = 'DELETE FROM archiwum WHERE id="'.$_POST["id"].'"';
		if($conn->query($sql1) === TRUE)
		{
			$conn->query($sql2);
			$conn->query($sql3);
		}
	}
?>