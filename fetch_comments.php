<?php
session_start();
include 'connect.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $commentText = mysqli_real_escape_string($con, $_POST["CommentText"]);
    $postId = mysqli_real_escape_string($con, $_POST["id"]);
    $email = $_SESSION['email'];
    echo $postId;
    $queryUserId = "SELECT Id FROM Users WHERE Email = '$email'";
    $resultUserId = mysqli_query($con, $queryUserId);
    if ($resultUserId && mysqli_num_rows($resultUserId) > 0) {
        $rowUserId = mysqli_fetch_assoc($resultUserId);
        $userId = $rowUserId["Id"];
        // $queryInsertComment = "INSERT INTO Comments (CommentText, CommentedBy, FPostId) VALUES ('$commentText', '$userId', '$postId')";
        // mysqli_query($con, $queryInsertComment) or die("Insert query failed");
    }
}
