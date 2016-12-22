<?php

if(!empty($_POST)) {
	include 'db.php';

	$stmt = $db->prepare("INSERT INTO authors(first_name, last_name) VALUES(?, ?)");
	$stmt->bind_param('ss', $_POST['first_name'], $_POST['last_name']);
	$stmt->execute();
	$stmt->close();
}

?>
<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Add new author | Bookshop</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>

<body>
	<div class="container">
		<?php include 'header.php'; ?>

		<h1>Add new author</h1>
		<form method="POST">
			<div class="form_group">
				<label for="first_name">First name</label>
				<input type="text" name="first_name" id="first_name" class="form-control">
			</div>

			<div class="form_group">
				<label for="last_name">Last name</label>
				<input type="text" name="last_name" id="last_name" class="form-control">
			</div>

			<button class="btn btn-primary" type="submit" style="margin-top: 10px">Save</button>
		</form>
	</div>
</body>
</html>