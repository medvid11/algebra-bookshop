<?php

session_start();
if(!isset($_SESSION['username'])) {
	header('Location: login.php');
}

$id = $_POST['id'];

include 'db.php';
$stmt = $db->prepare('DELETE FROM books WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->close();

header('Location: books.php');