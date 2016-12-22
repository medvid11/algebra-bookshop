<?php

include 'db.php';

$authors = [];
$stmt = $db->prepare("SELECT id, first_name, last_name FROM authors");
$stmt->execute();
$stmt->bind_result($id, $firstName, $lastName);
while($stmt->fetch()) {
	$authors[] = [
		'id' => $id,
		'firstName' => $firstName,
		'lastName' => $lastName
	];
}
$stmt->close();

?>

<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Authors | Bookshop</title>
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

		<a href="add_author.php" class="btn btn-primary">Add new author</a>

		<table class="table">
			<thead>
				<tr>
					<th>First name</th>
					<th>Last name</th>
					<th>-</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach($authors as $author) { ?>
				<tr>
					<td><?php echo $author['firstName']; ?></td>
					<td><?php echo $author['lastName']; ?></td>
					<td><a href="edit_author.php?id=<?php echo $author['id']; ?>" class="btn btn-default">Edit</a>
					<form action="delete_author.php" method="POST" style="display: inline-block">
						<input type="hidden" name="id" value="<?php echo $author['id']; ?>">
						<button type="submit" class="btn btn-danger">Delete</button>
					</form></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</body>
</html>