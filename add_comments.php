<?php
// Start the PHP session (if not started already)
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['postId']) && isset($_POST['commentText'])) {
        $postId = $_POST['postId'];
        $commentText = $_POST['commentText'];

        // Check if the user is authenticated
        if (isset($_SESSION['email'])) {
            // Set the static user ID to 1
            $userId = $_SESSION['userid'];

            // Insert the new comment into the Comments table with the provided post ID, comment text, and the static user ID
            $insertQuery = "INSERT INTO `Comments` (`FPostId`, `CommentText`, `CommentedBy`) 
                            VALUES ('$postId', '$commentText', '$userId')";

            if (mysqli_query($con, $insertQuery)) {
                // Comment added successfully, fetch the new comment data to return as response
                $query = "SELECT Comments.CommentText, Users.Name, Users.Image_Path
                          FROM Comments 
                          LEFT JOIN Users ON Comments.CommentedBy = Users.Id
                          WHERE Comments.CommentId = LAST_INSERT_ID()";

                $result = mysqli_query($con, $query);
                $comment = mysqli_fetch_assoc($result);

                // Create the HTML for the new comment
                $html = "<div class='row bg-light text-dark mt-1 mb-1'>
                            <div class='col-3' style='display: flex; justify-content: center;'>
                                <img src='{$comment['Image_Path']}' alt='' class='image-fluid mt-3' style='border-radius: 50%;' width='40' height='40'>
                            </div>
                            <div class='col-9'>
                                <div class='row'>
                                    <div class='col-12 d-flex' style='display: flex; align-items: center; position: sticky; margin-top: 20px;'>
                                        <img src='Images/check.png' alt='' width='15' height='15' class='image-fluid' style='margin-right: 4px;'>
                                        <b>
                                            {$comment['Name']}
                                        </b>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-12'>
                                        <p class='text-dark'>
                                            {$comment['CommentText']}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>";

                // Return the success flag and the HTML of the new comment
                $response = array('status' => 'success', 'html' => $html);
                echo json_encode($response);
            } else {
                // Comment adding failed, you can return an error message if needed.
                $response = array('status' => 'error', 'message' => 'Failed to add comment');
                echo json_encode($response);
            }
        } else {
            // User is not authenticated, handle this situation (e.g., redirect to the login page or show an error message).
            $response = array('status' => 'error', 'message' => 'User not authenticated');
            echo json_encode($response);
        }
    } else {
        // Invalid request parameters
        $response = array('status' => 'error', 'message' => 'Invalid request parameters');
        echo json_encode($response);
    }
} else {
    // Invalid request method
    $response = array('status' => 'error', 'message' => 'Invalid request method');
    echo json_encode($response);
}
