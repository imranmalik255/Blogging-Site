<?php
include 'connect.php';

$result2 = mysqli_query($con, "SELECT * FROM `Blogs`");
$total_pages = mysqli_num_rows($result2);
$page_limit = 5;
$total_pages = ceil($total_pages / $page_limit);
$page_number = isset($_POST['blogpageid']) ? $_POST['blogpageid'] : 1;
$offset = ($page_number - 1) * $page_limit;
$result = mysqli_query($con, "SELECT * FROM `Blogs` ORDER BY BlogId DESC LIMIT $offset, $page_limit");
$output = " <h1 class='text-center bg-dark text-light mt-5 mb-5'>
            Blogs
        </h1>";
if (mysqli_num_rows($result) > 0) {
    $output .= "<table class='table table table-striped' id='blog-table'><thead class='thead-dark'>
                <tr class='text-center'>
                    <th scope='col'>#Id</th>
                    <th scope='col'>Title</th>
                    <th scope='col'>Description</th>
                    <th scope='col'>Picture</th>
                    <th scope='col'>Edit</th>
                    <th scope='col'>Delete</th>
                </tr>
            </thead>
            <tbody>";
    while ($row = mysqli_fetch_assoc($result)) {
        // Ensure proper escaping for the output
        $description = htmlentities(substr($row['BlogDescription'], 0, 10)) . ' ...';
        $output .= " <tr class='text-center'>
                    <td>{$row['BlogId']}</td>
                    <td>{$row['BlogTitle']}</td>
                    <td>{$description}</td>
                    <td><img src='{$row['BlogImagePath']}' alt='Blog Image' width='30' height='30'>
                    </td>
                    <td><a href='Admineditblog.php?id={$row['BlogId']}'><img src='Images/edit.png' alt='Edit' width='20' height='20' style = 'cursor:pointer;'></a></td>
                    <td><img src='Images/delete.png' class='blog-delete-btn' alt='Delete' width='20' height='20' data-blog-id='{$row['BlogId']}' style='cursor: pointer;'></td>
                </tr>";
    }
    $output .= "</tbody> </table>";
    $output .= "<div style='display: flex; justify-content: center; align-items: center; padding: 15px; width: 100%;' id = 'blog-pagination'>";
    $start_page = max(1, $page_number - 1);
    $end_page = min($total_pages, $start_page + 2);

    if ($page_number > 1) {
        $output .= "<button class='btn btn-dark left-margin' data-blog-page-id='" . ($page_number - 1) . "'>Prev</button>";
    }

    for ($i = $start_page; $i <= $end_page; $i++) {
        $is_active = ($page_number == $i) ? 'myactive' : '';
        $output .= "<button class='btn btn-dark {$is_active} left-margin' data-blog-page-id='{$i}'>{$i}</button>";
    }

    if ($total_pages > $page_number) {
        $output .= "<button class='btn btn-dark left-margin' data-blog-page-id='" . ($page_number + 1) . "'>Next</button>";
    }

    $output .= "</div>";
    echo $output;
} else {
    $output .= "<h1 class='alert alert-danger text-center'>No comment record found</h1>";
    echo $output;
}
