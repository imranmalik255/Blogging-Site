<?php
include 'connect.php';
session_start();
$result2 = mysqli_query($con, "SELECT * FROM `Posts`");
$total_pages = mysqli_num_rows($result2);
$page_limit = 9;
$total_pages = ceil($total_pages / $page_limit);
$page_number = isset($_POST['homepageid']) ? $_POST['homepageid'] : 1;
$offset = ($page_number - 1) * $page_limit;

$query =
    "SELECT Posts.*, 
                  SUM(CASE WHEN Reaction.Status = 'Like' THEN 1 ELSE 0 END) AS LikeCount,
                  SUM(CASE WHEN Reaction.Status = 'Dislike' THEN 1 ELSE 0 END) AS DislikeCount
           FROM `Posts` LEFT JOIN `Reaction` ON Posts.PostId = Reaction.Post_Id 
           GROUP BY Posts.PostId 
           ORDER BY Posts.PostId DESC 
           LIMIT $offset, $page_limit";
$result = mysqli_query($con, $query);
$user = $_SESSION['userid'];
$output = '<h3 class="text-center mb-5 bg-danger p-3 text-white">Popular Posts</h3>';
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $postId = $row['PostId'];
        $likeCount = $row['LikeCount'];
        $dislikeCount = $row['DislikeCount'];


        $user_reaction_query = "SELECT Status FROM `Reaction` WHERE Post_Id = {$postId} AND UserId = {$user}";
        $user_reaction_result = mysqli_query($con, $user_reaction_query);
        // Fetch all comments for this post using mysqli_fetch_all
        $query1 = "SELECT Comments.CommentText, Users.Name, Users.Image_Path
                    FROM Comments 
                    LEFT JOIN Users ON Comments.CommentedBy = Users.Id
                    WHERE Comments.FPostId = '{$postId}'
                    ORDER BY CommentId DESC";
        $result1 = mysqli_query($con, $query1);
        $comments = mysqli_fetch_all($result1, MYSQLI_ASSOC);

        // Count the number of comments for this post
        $commentCount = count($comments);

        // Output the post and its comments
        $output .= "<div class='col-lg-4 col-md-4 col-12 text-center mb-4 px-md-5'>
            
        <div class = 'box' style='position: relative; border-top-left-radius: 6px; border-top-right-radius: 6px;'>
                <img src='{$row['PostImagePath']}' alt='' class='image-fluid w-100 custom-height rounded' width='250' height='350'>";

        if (mysqli_num_rows($user_reaction_result) > 0) {
            $user_reaction = mysqli_fetch_assoc($user_reaction_result)['Status'];
            if ($user_reaction === 'Like') {
                $output .= " <div style='position: absolute; width: 100%; height: 50px; background-color: rgb(0, 0, 0); bottom: 0; opacity: 70%; display: flex; flex-direction: column; justify-content: center;'>
            <div class='row' style='display: flex; justify-content: center; align-items: center; height: 100%;'>
                <div class='col-4'>
                    <img src='Images/loveheart2.png' alt='' class='pointer like image-fluid' width='30' height='30' data-name='Like' data-like-post-id='{$row['PostId']}'>
                    <span class='text-white'>{$likeCount}</span>
                </div>
                <div class='col-4'>
                    <img src='Images/broken-heart.png' alt='' class='pointer dislike image-fluid image-colour' width='30' height='30' data-name='Dislike' data-dislike-post-id='{$row['PostId']}'>
                    <span class='text-white'>{$dislikeCount}</span>
                </div>
                <div class='col-4'>
                    <img src='Images/comment.png' alt='' class='pointer image-fluid image-colour comment-button' width='30' height='30' data-comment-id='{$postId}'>
                    <span class='text-white'>{$commentCount}</span>
                </div>
            </div> </div>
            </div>";
            } elseif ($user_reaction === 'Dislike') {
                $output .= "<div style='position: absolute; width: 100%; height: 50px; background-color: rgb(0, 0, 0); bottom: 0; opacity: 70%; display: flex; flex-direction: column; justify-content: center;'>
            <div class='row' style='display: flex; justify-content: center; align-items: center; height: 100%;'>
                <div class='col-4'>
                    <img src='Images/heart.png' alt='' class='pointer like image-fluid image-colour' width='30' height='30' data-name='Like' data-like-post-id='{$row['PostId']}'>
                    <span class='text-white'>{$likeCount}</span>
                </div>
                <div class='col-4'>
                    <img src='Images/disliked.png' alt='' class='pointer image-colour dislike image-fluid' width='30' height='30' data-name='Dislike' data-dislike-post-id='{$row['PostId']}'>
                    <span class='text-white'>{$dislikeCount}</span>
                </div>
                <div class='col-4'>
                    <img src='Images/comment.png' alt='' class='pointer image-fluid image-colour comment-button' width='30' height='30' data-comment-id='{$postId}'>
                    <span class='text-white'>{$commentCount}</span>
                </div>
            </div> </div>
            </div>";
            } else {
                // No specific reaction (empty or not specified status)
                $output .= "<div style='position: absolute; width: 100%; height: 50px; background-color: rgb(0, 0, 0); bottom: 0; opacity: 70%; display: flex; flex-direction: column; justify-content: center;'>
            <div class='row' style='display: flex; justify-content: center; align-items: center; height: 100%;'>
                <div class='col-4'>
                    <img src='Images/heart.png' alt='' class='pointer like image-fluid image-colour' width='30' height='30' data-name='Like' data-like-post-id='{$row['PostId']}'>
                    <span class='text-white'>{$likeCount}</span>
                </div>
                <div class='col-4'>
                    <img src='Images/broken-heart.png' alt='' class='pointer dislike image-fluid image-colour' width='30' height='30' data-name='Dislike' data-dislike-post-id='{$row['PostId']}'>
                    <span class='text-white'>{$dislikeCount}</span>
                </div>
                <div class='col-4'>
                    <img src='Images/comment.png' alt='' class='pointer image-fluid image-colour comment-button' width='30' height='30' data-comment-id='{$postId}'>
                    <span class='text-white'>{$commentCount}</span>
                </div>
            </div> </div>
            </div>";
            }
        } else {
            $output .= "<div style='position: absolute; width: 100%; height: 50px; background-color: rgb(0, 0, 0); bottom: 0; opacity: 70%; display: flex; flex-direction: column; justify-content: center;'>
            <div class='row' style='display: flex; justify-content: center; align-items: center; height: 100%;'>
                <div class='col-4'>
                    <img src='Images/heart.png' alt='' class='pointer like image-fluid image-colour' width='30' height='30' data-name='Like' data-like-post-id='{$row['PostId']}'>
                    <span class='text-white'>{$likeCount}</span>
                </div>
                <div class='col-4'>
                    <img src='Images/broken-heart.png' alt='' class='pointer dislike image-fluid image-colour' width='30' height='30' data-name='Dislike' data-dislike-post-id='{$row['PostId']}'>
                    <span class='text-white'>{$dislikeCount}</span>
                </div>
                <div class='col-4'>
                    <img src='Images/comment.png' alt='' class='pointer image-fluid image-colour comment-button' width='30' height='30' data-comment-id='{$postId}'>
                    <span class='text-white'>{$commentCount}</span>
                </div>
            </div> </div>
            </div>";
        }


        // Output the comment section with form
        $output .= "<div class='comment-section' id='comment-section-{$postId}' style='height: 120px; width: 100%; border: 1px solid black; border-top: none; border-bottom-left-radius: 6px; border-bottom-right-radius: 6px; overflow-y: auto; overflow-x: hidden; display:none;'>";
        $output .= "<div class='row'>
            <div class='col-12 mt-3' style='background-color: white; width: 100%; position: relative;'>
                <form class='myform' data-comment-id='{$postId}'>
                    <input name='CommentText' type='text' class='pb-2 w-100 comment-input' placeholder='Add your comment' style='border: none; padding-left: 4px; padding-right: 40px;' required>
                    <div style='position: absolute; top: -17px; right: 10px;'>
                        <button type='submit' style='border: none; background: none;' name='commentSubmit'>
                            <img src='Images/submit.png' alt='' width='50' height='50' class='image-fluid'>
                        </button>
                    </div>
                </form>
            </div>
        </div>";

        foreach ($comments as $comment) {
            $output .= "<div class='row bg-light text-dark mt-1 mb-1'>
        <div class='col-2' style=' border-radius: 50%;'>
            <img src='{$comment['Image_Path']}' alt='' class='mt-3 image-fluid' style='margin-left: 15px;border-radius: 50%;' width='40' height='40'>
        </div>
        <div class='col-10'>
            <div class='row'>
                <div class='col-12 d-flex' style='display: flex; align-items: center; position: sticky; margin-top: 20px;'>
                    <img src='Images/check.png' alt='' width='15' height='15' class='image-fluid' style='margin-right:5px;'>
                    <b>
                        {$comment['Name']}
                    </b>
                </div>
            </div>
            <div class='row'>
                <div class='col-12' style='display: flex; justify-content-start;'>
                    <p class='text-dark'>
                        {$comment['CommentText']}
                    </p>
                </div>
            </div>
        </div>
    </div>";
        }


        // Add the comment form to the comment section div

        $output .= "</div>
        </div>";
    }
    $output .= "<div style='display: flex; justify-content: center; align-items: center; padding: 15px; width: 100%;' id = 'home-pagination'>";
    $start_page = max(1, $page_number - 1);
    $end_page = min($total_pages, $start_page + 2);

    if ($page_number > 1) {
        $output .= "<button class='btn btn-info left-margin' data-home-page-id='" . ($page_number - 1) . "'>Prev</button>";
    }

    for ($i = $start_page; $i <= $end_page; $i++) {
        $is_active = ($page_number == $i) ? 'myactive' : '';
        $output .= "<button class='btn btn-info {$is_active} left-margin' data-home-page-id='{$i}'>{$i}</button>";
    }

    if ($total_pages > $page_number) {
        $output .= "<button class='btn btn-info left-margin' data-home-page-id='" . ($page_number + 1) . "'>Next</button>";
    }

    $output .= "</div>";
    echo $output;
} else {
    $output .= "<h1 class='alert alert-danger text-center'>No comment record found</h1>";
    echo $output;
}
