<?php

$id = $_POST['id'];

include 'db.php';
$stmt = $db->prepare('DELETE FROM authors WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->close();

header('Location: authors.php');