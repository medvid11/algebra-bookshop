<?php

session_start();
if(!isset($_SESSION['username'])) {
	header('Location: login.php');
}

$id = $_GET['id'];
include 'db.php';

if(!empty($_POST)) {
	$stmt = $db->prepare('UPDATE books SET title = ?, category_id = ?, description = ?, price = ? WHERE id = ?');
	$stmt->bind_param('sisdi', $_POST['title'], $_POST['category'], $_POST['description'], $_POST['price'], $id);
	$stmt->execute();
	$stmt->close();

	$stmt = $db->prepare('DELETE FROM book_authors WHERE book_id = ?');
	$stmt->bind_param('i', $id);
	$stmt->execute();
	$stmt->close();

	$stmt = $db->prepare('INSERT INTO book_authors(book_id, author_id) VALUES(?, ?)');
	foreach($_POST['authors'] as $authorId) {
		$stmt->bind_param('ii', $id, $authorId);
		$stmt->execute();
	}
	$stmt->close();
}

$stmt = $db->prepare('SELECT id, name FROM categories');
$stmt->bind_result($idCat, $name);
$stmt->execute();
$categories = [];
while($stmt->fetch()) {
	$categories[$idCat] = $name;
}
$stmt->close();

$stmt = $db->prepare('SELECT id, first_name, last_name FROM authors ORDER BY last_name, first_name');
$stmt->bind_result($idAuthor, $firstName, $lastName);
$stmt->execute();
$authors = [];
while($stmt->fetch()) {
	$authors[$idAuthor] = $lastName . ' ' . $firstName;
}
$stmt->close();

$stmt = $db->prepare('SELECT title, category_id, description, price, author_id FROM books LEFT JOIN book_authors ON books.id = book_authors.book_id WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->bind_result($title, $categoryId, $description, $price, $authorId);
$stmt->execute();
$bookAuthors = [];
while($stmt->fetch()) {
	$bookAuthors[] = $authorId;
}
$stmt->close();

?>
<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit book | Bookshop</title>
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

		<h1>Edit book</h1>
		<form method="POST">
			<div class="form-group">
				<label for="title">Title</label>
				<input type="text" class="form-control" name="title" id="title" required value="<?php echo $title; ?>">
			</div>

			<div class="form-group">
				<label for="authors">Author(s)</label>
				<select name="authors[]" id="authors" multiple class="form-control">
					<?php foreach($authors as $id => $name) { ?>
					<option value="<?php echo $id; ?>" <?php if(in_array($id, $bookAuthors)) echo 'selected'; ?>><?php echo $name; ?></option>
					<?php } ?>
				</select>
			</div>

			<div class="form-group">
				<label for="description">Description</label>
				<textarea name="description" id="description" rows="5" class="form-control"><?php echo $description; ?></textarea>
			</div>

			<div class="form-group">
				<label for="category">Category</label>
				<select name="category" id="category" class="form-control">
					<?php foreach($categories as $id => $name) { ?>
					<option value="<?php echo $id; ?>" <?php if($id == $categoryId) { echo 'selected'; } ?>><?php echo $name; ?></option>
					<?php } ?>
				</select>
			</div>

			<div class="form-group">
				<label for="price">Price</label>
				<input type="text" class="form-control" name="price" id="price" required value="<?php echo $price; ?>">
			</div>

			<button class="btn btn-primary" type="submit">Save</button>
		</form>
	</div>
</body>
</html>