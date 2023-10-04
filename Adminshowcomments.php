<?php
include 'connect.php';

$result1 = mysqli_query($con, "SELECT * FROM `Comments`");
$page_number = isset($_POST['pageid']) ? $_POST['pageid'] : 1;
$total_page = mysqli_num_rows($result1);
$page_limit = 5;
$total_page = ceil($total_page / $page_limit);
$offset = ($page_number - 1) * $page_limit;

$result = mysqli_query($con, "SELECT * FROM `Comments` LEFT JOIN `Users` on Comments.CommentedBy = Users.Id ORDER BY CommentId DESC LIMIT {$offset}, {$page_limit}");

$output = "<h1 class='text-center bg-success text-light mt-5 mb-5'>
            Comments
        </h1>";

if (mysqli_num_rows($result) > 0) {
    $output .= "<table class='table table table-striped'>
               <thead class='thead-dark'>
                <tr class='text-center'>
                    <th scope='col'>#Id</th>
                    <th scope='col'>Comment</th>
                    <th scope='col'>CommentedBy</th>
                    <th scope='col'>Delete</th>
                </tr>
            </thead>
            <tbody>";
    while ($row = mysqli_fetch_assoc($result)) {
        $output .= "<tr class='text-center'>
                    <td>{$row['CommentId']}</td>
                    <td>{$row['CommentText']}</td>
                    <td>{$row['Name']}</td>
                    <td><img class='comment-delete-btn' src='Images/delete.png' alt='' width='20' height='20' style='cursor: pointer;' data-comment-id='{$row['CommentId']}'></td>
                </tr>";
    }
    $output .= "</tbody>
    </table> <div style='display: flex; justify-content: center; align-items: center; padding: 15px; width: 100%;' id = 'comment-pagination'>";

    // Calculate start and end page numbers for the pagination
    $start_page = max(1, $page_number - 1);
    $end_page = min($total_page, $start_page + 2);

    if ($page_number > 1) {
        $output .= "<button class='btn btn-success left-margin' data-page-id='" . ($page_number - 1) . "'>Prev</button>";
    }

    for ($i = $start_page; $i <= $end_page; $i++) {
        $is_active = ($page_number == $i) ? 'myactive' : '';
        $output .= "<button class='btn btn-success {$is_active} left-margin' data-page-id='{$i}'>{$i}</button>";
    }

    if ($total_page > $page_number) {
        $output .= "<button class='btn btn-success left-margin' data-page-id='" . ($page_number + 1) . "'>Next</button>";
    }

    $output .= "</div>";
    echo $output;
} else {
    $output .= "<h1 class='alert alert-danger text-center'>No comment record found</h1>";
    echo $output;
}
