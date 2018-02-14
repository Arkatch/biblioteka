<!DOCTYPE html>
<html>
	<head>
		<link rel="Stylesheet" type="text/css" href="/css/statystyka.css"/>
		<meta charset="utf-8">
		<meta name="author" content="Adrian Kucharski">
		<title>Panel administratora</title>
		<script type="text/javascript" src="/javascript/panel.js"></script>
		<link rel="Stylesheet" type="text/css" href="/css/panel.css"/>
		
	</head>
	<body>
			<?php
				session_start();
				if(isset($_SESSION['valid']) ){
					echo '
						<div id="jsPanel">
							<input class="but" id="addBook" type="button" value="Dodaj książkę" />
							<input class="but" id="wypBook" type="button" value="Wypożycz książkę" />
							<input class="but" id="editBook" type="button" value="Edytuj książkę" />
							<input class="but" id="raport" type="button" value="Lista wpożyczonych" />
							<input class="but" id="statyst" type="button" value="Statystyki" />
							<input class="but" id="list" type="button" value="Lista książek" />
							<input class="but" id="archiwum" type="button" value="Archiwum" />
							
							<form name="logOutF" method="post" action="/php/logout.php">
							<input class="but" id="logOut" type="submit" value="Wyloguj"/>
							</form>
						</div>
						<hr>';
				}else{
					echo '<center><h3>Błąd 404 Brak strony.</h3></center>';
					header('Refresh: 1; URL = login.php');
				}
			?>
		<div id="main">
			<div id="javascriptContext">
			</div>
		</div>
	</body>
</html>