<?php

session_start();
if(!isset($_SESSION['username'])) {
	header('Location: login.php');
}

include 'db.php';

$stmt = $db->prepare('SELECT id, name FROM categories');
$stmt->bind_result($id, $name);
$stmt->execute();
$categories = [];
while($stmt->fetch()) {
	$categories[$id] = $name;
}
$stmt->close();

$stmt = $db->prepare('SELECT id, first_name, last_name FROM authors ORDER BY last_name, first_name');
$stmt->bind_result($id, $firstName, $lastName);
$stmt->execute();
$authors = [];
while($stmt->fetch()) {
	$authors[$id] = $lastName . ' ' . $firstName;
}
$stmt->close();

if(!empty($_POST)) {
	$stmt = $db->prepare("INSERT INTO books(title, category_id, description, price) VALUES(?, ?, ?, ?)");
	$stmt->bind_param('sisd', $_POST['title'], $_POST['category'], $_POST['description'], $_POST['price']);
	$stmt->execute();
	$bookId = $stmt->insert_id;
	$stmt->close();

	$stmt = $db->prepare('INSERT INTO book_authors(book_id, author_id) VALUES(?, ?)');
	foreach($_POST['authors'] as $authorId) {
		$stmt->bind_param('ii', $bookId, $authorId);
		$stmt->execute();
	}
	$stmt->close();

	move_uploaded_file($_FILES['cover']['tmp_name'], 'uploads/' . $bookId . '.jpg');
}

?>
<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Add new book | Bookshop</title>
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

		<h1>Add new book</h1>
		<form method="POST" enctype="multipart/form-data">
			<div class="form-group">
				<label for="title">Title</label>
				<input type="text" class="form-control" name="title" id="title" required>
			</div>

			<div class="form-group">
				<label for="authors">Author(s)</label>
				<select name="authors[]" id="authors" multiple class="form-control">
					<?php foreach($authors as $id => $name) { ?>
					<option value="<?php echo $id; ?>"><?php echo $name; ?></option>
					<?php } ?>
				</select>
			</div>

			<div class="form-group">
				<label for="description">Description</label>
				<textarea name="description" id="description" rows="5" class="form-control"></textarea>
			</div>

			<div class="form-group">
				<label for="category">Category</label>
				<select name="category" id="category" class="form-control">
					<?php foreach($categories as $id => $name) { ?>
					<option value="<?php echo $id; ?>"><?php echo $name; ?></option>
					<?php } ?>
				</select>
			</div>

			<div class="form-group">
				<label for="price">Price</label>
				<input type="text" class="form-control" name="price" id="price" required>
			</div>

			<div class="form-group">
				<label for="cover">Cover</label>
				<input type="file" name="cover" id="cover">
			</div>

			<button class="btn btn-primary" type="submit">Save</button>
		</form>
	</div>
</body>
</html>