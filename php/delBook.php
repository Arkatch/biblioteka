<?php
	session_start();
	if(isset($_SESSION['valid'])){
		$conn = new mysqli('localhost', 'root', '');
		$id = $_POST["id"];
		echo $id;
		$sql1 = "use biblioteka";
		$sql2 = "delete from ksiazki where id=".$id." ";
		if($conn->query($sql1) === TRUE){
			if($conn->query($sql2) === TRUE){
				
			}
		}
		$conn->close();
	}
?>