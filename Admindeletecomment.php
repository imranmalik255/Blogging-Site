<?php
include 'connect.php';

$id = $_POST['commentid'];

mysqli_query($con, "DELETE FROM `Comments` WHERE CommentId = $id");

echo 'Comment is deleted successfully';
