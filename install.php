<?php
		//Login i hasło do bazy
		$login = "login";
		$passwd = "haslo";
		
		
		$conn = new mysqli('localhost', 'root', '');
		$sql1 = "create database `biblioteka` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci";
		$sql0 = 'use biblioteka';
		$sql2 = 'CREATE TABLE ksiazki(id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, tytul varchar(100), autor VARCHAR(50) NOT NULL, opis TEXT NOT NULL, ilosc INT NOT NULL, zdjecie text NOT NULL, statystyka INT NOT NULL)';
		$sql3 = 'CREATE TABLE wypozyczone(id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, idKsiazki INT NOT NULL, imienazwisko VARCHAR(40) NOT NULL, klasa VARCHAR(40) NOT NULL, dataWpozyczenia DATE NOT NULL, dataZwrotu DATE NOT NULL)';
		$sql4 = 'CREATE TABLE passwd(id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, login VARCHAR(40), haslo VARCHAR(40))';
		$sql5 = 'INSERT INTO passwd values("", sha1("'.$login.'"), sha1("'.$passwd.'"))';
		$sql6 = 'CREATE TABLE archiwum(id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, idKsiazki INT NOT NULL, tytulKsiazki VARCHAR(100) NOT NULL, imienazwisko VARCHAR(40) NOT NULL, klasa VARCHAR(40) NOT NULL, dataWpozyczenia DATE NOT NULL, dataZwrotu DATE NOT NULL)';
		if($conn->query($sql1) === TRUE)
		{
			if($conn->query($sql0)===TRUE){
				if($conn->query($sql2)===TRUE){
					if($conn->query($sql3)===TRUE){
						if($conn->query($sql4)===TRUE){
							if($conn->query($sql5)===TRUE){
								if($conn->query($sql6)===TRUE){
									echo 'Zakończono';
								}
							}
						}
					}
				}
			}else{
				echo "error";
			}
		}else{
			echo "error";
		}
?>