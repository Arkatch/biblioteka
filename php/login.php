<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="author" content="Adrian Kucharski">
		<link rel="Stylesheet" type="text/css" href="../css/login.css" />
		<title>Login</title>
	</head>
	<body>
         <?php
			session_start();
            $msg = '';
            $conn = new mysqli('localhost', 'root', '');
			$login = '';
			$passwd = '';
			$sql1 = "use biblioteka";
			$sql2 = " select login, haslo from passwd where id='1' ";
			if($conn->query($sql1) === TRUE){
			$results = $conn->query($sql2);
				while($row = $results->fetch_assoc()) {
					$login=$row["login"];
					$passwd=$row["haslo"];
				}
			}
            if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])) {
               if (sha1($_POST['username']) == $login && 
					sha1($_POST['password']) == $passwd) {
					$_SESSION['valid'] = true;
					$_SESSION['login'] = 'Administrator';
					header('Refresh: 0; URL = ../php/adminPanel.php');
               }else {
                  $msg = 'Zła nazwa użytkownika lub hasło!';
               }
            }
         ?>
		<div id="main" class="center">
			<form class = "form-signin" role = "form" 
            action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); 
            ?>" method = "post">
            <h4 class = "center"><?php echo $msg; ?></h4>
			
			<div class="center">
				<input type = "text" class = "form-control"  name = "username" placeholder = "Nazwa użytkownika" required autofocus>
			</div>
				<br>
			<div class="center">	
            <input type = "password" class = "form-control" name = "password" placeholder = "Hasło" required>
			</div>	
				<br>
            <div class="center">
				<button class = "but" type = "submit" name = "login">Zaloguj</button>
			</div>
			</form>	
		</div>
	</body>
</html>