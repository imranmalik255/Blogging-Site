<?php
include 'connect.php';
$id = $_POST['blogid'];

mysqli_query($con, "DELETE FROM `Blogs` WHERE BlogId = $id");

echo 'Blog is deleted successfully';
