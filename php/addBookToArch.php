<?php
	session_start();
	if(isset($_SESSION['valid'])){
		$conn = new mysqli('localhost', 'root', '');
		$id = $_POST["id"];
		$data = date("Y-m-d");
		$sql0 = "use biblioteka";
		$sql1 = "UPDATE archiwum SET dataZwrotu='".$data."' WHERE id='".$id."' ";
		if($conn->query($sql0)===TRUE){
			if(!$conn->query($sql1)===TRUE)
				echo "bug";
		}else{
			echo "bug!";
		}
		$conn->close();
	}else{
		echo "Coś poszło nie tak.";
	}
?>