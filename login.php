<?php

session_start();
if(isset($_SESSION['username'])) {
	header('Location: index.php');
	die();
}

if(isset($_POST['username'])) {
	include 'db.php';

	$query = $db->prepare('SELECT username FROM users WHERE username = ? AND `password` = ?');
	$query->bind_result($username);
	$query->bind_param('ss', $_POST['username'], md5($_POST['password']));
	$query->execute();
	$query->store_result();
	if($query->num_rows == 1) {
		$_SESSION['username'] = $_POST['username'];
		header('Location: index.php');
		die();
	} else {
		$error = 'Login failed. Username or password incorrect!';
	}
	$query->close();
}

?>
<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login | Bookshop</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>

<body>
	<div class="container" style="width: 30%">
		<h1>Login</h1>
		<?php if(isset($error)) { ?>
		<div class="alert alert-danger"><?php echo $error; ?></div>
		<?php } ?>
		<form method="POST">
			<div class="form-group">
				<input type="text" name="username" class="form-control" placeholder="Username" autofocus>
			</div>

			<div class="form-group">
				<input type="password" name="password" class="form-control" placeholder="Password">
			</div>

			<button type="submit" class="btn btn-primary">Login</button>

			<a href="signup.php" class="btn btn-primary">Create a new user</a>
		</form>
	</div>
</body>
</html>