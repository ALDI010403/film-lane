<!DOCTYPE html>
<html>
<head>
	<title>Belajar Form Login </title>
	<style type="text/css">
		body {
			background-color: #ffc0cb;
			font-family: "Segoe UI";
		}
		#wrapper {
			background-color: #fff;
			width: 400px;
			height: 330px;
			margin-top: 120px;
			margin-left: auto;
			margin-right: auto;
			padding: 20px;
			border-radius: 4px;
		}
		input[type=text], input[type=password] {
			border: 1px solid #ddd;
			padding: 10px;
			width: 95%;
			border-radius: 2px;
			outline: none;
			margin-top: 10px;
			margin-bottom: 20px;
		}
		label, h1 {
			text-transform: uppercase;
			font-weight: bold;
		}
		h1 {
			text-align: center;
			font-size: 40px;
			color: #7a58ff;
		}
		button {
			border-radius: 2px;
			padding: 10px;
			width: 120px;
			background-color: #7a58ff;
			border: none;
			color: #fff;
			font-weight: bold;
		}
		.error {
			background-color: #f72a68;
			width: 400px;
			height: auto;
			margin-top: 20px;
			margin-left: auto;
			margin-right: auto;
			padding: 20px;
			border-radius: 4px;
			color: #fff;

		}
	</style>
	
	
</head>
<body>
	<div id="wrapper">
		<form action="login.php" method="POST">
			<h1>Login</h1>
			<label>Username</label>
			<input type="text" name="username" placeholder="masukkan username" required="" autofocus="">
			<label>Password </label>
			<input type="password" name="password" placeholder="masukkan password" required="" >
			<button type="submit">KIRIM</button>
		</form>
	</div>
	
		<?php if(isset($_GET['pesan'])) { ?>
			<div class="error">
				<label>Oopps... <?php echo $_GET['pesan']; ?></label>
			</div>
		<?php } ?>
	

		
</body>
</html>