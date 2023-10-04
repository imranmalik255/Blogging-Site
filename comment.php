<?php
session_start();
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["commentText"]) && isset($_POST["postId"])) {
    // Sanitize the comment input and post ID
    $commentText = mysqli_real_escape_string($con, $_POST["commentText"]);
    $postId = mysqli_real_escape_string($con, $_POST["postId"]);
    $email = $_SESSION['email'];

    // Get the user's ID based on their email
    $queryUserId = "SELECT Id FROM Users WHERE Email = '$email'";
    $resultUserId = mysqli_query($con, $queryUserId);
    if ($resultUserId && mysqli_num_rows($resultUserId) > 0) {
        $rowUserId = mysqli_fetch_assoc($resultUserId);
        $userId = $rowUserId["Id"];

        // Insert the comment into the database with the FPostId
        $queryInsertComment = "INSERT INTO Comments (CommentText, CommentedBy, FPostId) VALUES ('$commentText', '$userId', '$postId')";
        mysqli_query($con, $queryInsertComment) or die("Insert query failed");
    }
}
