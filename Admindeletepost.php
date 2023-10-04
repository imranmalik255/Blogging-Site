<?php
include 'connect.php';

$id = $_POST['postid'];
mysqli_query($con, "DELETE FROM `Posts` WHERE PostId = {$id}");
echo "Post deleted successfully.";
