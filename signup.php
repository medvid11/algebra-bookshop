<?php

session_start();
if(isset($_SESSION['username'])) {
	header('Location: index.php');
}

if(!empty($_POST)) {
	include 'db.php';

	$username= $_POST['username'];
	$email= $_POST['email'];

	$sqlCheck = "SELECT * FROM users WHERE username='$username' OR email='$email'";

	$result = $db->query($sqlCheck);
	    if($result->num_rows == 0) {
		$result->free();}
		else { 
		echo '<div class="alert alert-success"><strong>Username 
		'.$_POST['username'].' or email'.$_POST['email'].' already in use!</br> 
		You will be redirected to login page in 3 seconds.</strong></div>'; header('refresh:
		3; url=login.php'); die();}	
	

	$stmt = $db->prepare("INSERT INTO users (username, password, email) VALUES(?, ?, ?)");
	$stmt->bind_param('sss', $_POST['username'], md5($_POST['password']), $_POST['email'] );
	$stmt->execute();
	
	$stmt->close();
	

	
}

?>
<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sign up | Bookshop</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>

<body>
	<div class="container">
		
		<?php if(isset($stmt)){
				echo '<div class="alert alert-success"><strong>User 
					 '.$_POST['username'].' succesfully created! </br> 
					 You will be redirected to login page in 3 seconds.</strong></div>';
				
				header('refresh: 3; url=login.php');
				die();

			} 

		?>
		<h1>Add new user</h1>
		<form method="POST">
			
			<div class="form_group">
				<label for="username">Username</label>
				<input type="text" name="username" id="username" class="form-control">
			</div>

			<div class="form_group">
				<label for="password">Password</label>
				<input type="password" name="password" id="password" class="form-control">
			</div>

			<div class="form_group">
				<label for="email">Email</label>
				<input type="email" name="email" id="email" class="form-control">
			</div>

			<button class="btn btn-primary" type="submit" style="margin-top: 10px">Save</button>
		</form>
		
	</div>
</body>
</html>