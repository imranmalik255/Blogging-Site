<?php
include 'connect.php';
$userid = $_POST['userid'];
mysqli_query($con, "DELETE FROM `Users` WHERE Id = {$userid}");
echo 'deleted';
