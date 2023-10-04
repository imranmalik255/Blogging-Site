<?php
include 'connect.php';
session_start();
$postId = $_POST['postId'];
$status = $_POST['status'];
$userId = $_SESSION['userid'];

// Corrected the query with proper variable interpolation using double quotes
$query1 = "SELECT * FROM `Reaction` WHERE Post_Id = {$postId} AND UserId = {$userId}";
$result1 = mysqli_query($con, $query1);

if (mysqli_num_rows($result1) > 0) {
    $row = mysqli_fetch_assoc($result1);
    if ($row['Status'] === $status) {
        // Corrected the DELETE query with proper variable interpolation using double quotes
        mysqli_query($con, "UPDATE `Reaction` SET Status = '' WHERE Post_Id = {$postId} AND UserId = {$userId}");
    } else {
        // Corrected the UPDATE query with proper variable interpolation using double quotes
        mysqli_query($con, "UPDATE `Reaction` SET Status = '{$status}' WHERE Post_Id = {$postId} AND UserId = {$userId}");
    }
} else {
    // Corrected the INSERT query with proper variable interpolation using double quotes
    mysqli_query($con, "INSERT INTO `Reaction`(Post_Id, UserId, Status) VALUES('{$postId}', '{$userId}', '{$status}')");
}
