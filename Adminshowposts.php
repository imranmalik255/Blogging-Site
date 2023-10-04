<?php
include 'connect.php';
$result2 = mysqli_query($con, "SELECT * FROM `Posts`");
$total_pages = mysqli_num_rows($result2);
$page_limit = 5;
$total_pages = ceil($total_pages / $page_limit);
$page_number = isset($_POST['postpageid']) ? $_POST['postpageid'] : 1;
$offset = ($page_number - 1) * $page_limit;


$output = "<h1 class='text-center bg-primary text-light mt-5 mb-5'>
            Posts
        </h1>";
$result = mysqli_query($con, "SELECT * FROM `Posts` ORDER BY PostId DESC LIMIT $offset, $page_limit");
if (mysqli_num_rows($result) > 0) {
    $output .= "<table class='table table table-striped' id='post-table'><thead class='thead-dark'>
    <tr class='text-center'>
        <th scope='col'>#Id</th>
        <th scope='col'>Picture</th>
        <th scope='col'>Edit</th>
        <th scope='col'>Delete</th>
    </tr>
</thead>
<tbody>
";
    while ($row = mysqli_fetch_assoc($result)) {
        $output .= "<tr class='text-center'>
                <td>{$row['PostId']}</td>
                <td><img src='{$row['PostImagePath']}' alt='' width='30' height='30'>
                </td>
                <td>
                   <a href='Admineditpost.php?id={$row['PostId']}' class='edit-link'>
                        <img src='Images/edit.png' alt='' width='20' height='20'>
                   </a>
                </td>
                <td><img src='Images/delete.png' id = 'delete-post-btn' alt='' width='20' height='20' data-post-id='{$row['PostId']}' style='cursor: pointer;'></td>
            </tr>";
    }
    $output .= "</tbody> </table>";
    $output .= "<div style='display: flex; justify-content: center; align-items: center; padding: 15px; width: 100%;' id = 'post-pagination'>";

    $start_page = max(1, $page_number - 1);
    $end_page = min($total_pages, $start_page + 2);

    if ($page_number > 1) {
        $output .= "<button class='btn btn-primary left-margin' data-post-page-id='" . ($page_number - 1) . "'>Prev</button>";
    }

    for ($i = $start_page; $i <= $end_page; $i++) {
        $is_active = ($page_number == $i) ? 'myactive' : '';
        $output .= "<button class='btn btn-primary {$is_active} left-margin' data-post-page-id='{$i}'>{$i}</button>";
    }

    if ($total_pages > $page_number) {
        $output .= "<button class='btn btn-primary left-margin' data-post-page-id='" . ($page_number + 1) . "'>Next</button>";
    }

    $output .= "</div>";
    echo $output;
} else {
    $output .= "<h1 class='alert alert-danger text-center'>No comment record found</h1>";
    echo $output;
}
