<?php
include 'connect.php';

$result2 = mysqli_query($con, "SELECT * FROM `Users`");
$total_pages = mysqli_num_rows($result2);
$page_limit = 5;
$total_pages = ceil($total_pages / $page_limit);
$page_number = isset($_POST['userpageid']) ? $_POST['userpageid'] : 1;
$offset = ($page_number - 1) * $page_limit;
$output = " <h1 class='text-center bg-info text-light mt-5 mb-5'>
            Users
        </h1>";

$result = mysqli_query($con, "SELECT * FROM Users ORDER BY Id DESC LIMIT $offset, $page_limit");

if (mysqli_num_rows($result) > 0) {
    $output .= "<table class='table table table-striped' id='user-table'><thead class='thead-dark'>
    <tr class='text-center'>
        <th scope='col'>#Id</th>
        <th scope='col'>Name</th>
        <th scope='col'>Email</th>
        <th scope='col'>Picture</th>
        <th scope='col'>Delete</th>
    </tr>
</thead>
<tbody>";
    while ($row = mysqli_fetch_assoc($result)) {
        $email = substr($row['Email'], 0, 7) . '...';
        $output .= "<tr class='text-center'>
                <td>{$row['Id']}</td>
                <td>{$row['Name']}</td>
                <td>{$email}</td>
                <td><img src='{$row['Image_Path']}' alt='' width='30' height='30' style='border-radius: 50%;'>
                </td>
                <td><img src='Images/delete.png' class='user-delete-btn' alt='' width='20' height='20' data-user-id='{$row['Id']}' style='cursor:pointer;'></td>
            </tr>";
    }
    $output .= "</tbody> </table>";
    $output .= "<div style='display: flex; justify-content: center; align-items: center; padding: 15px; width: 100%;' id = 'user-pagination'>";
    $start_page = max(1, $page_number - 1);
    $end_page = min($total_pages, $start_page + 2);

    if ($page_number > 1) {
        $output .= "<button class='btn btn-info left-margin' data-user-page-id='" . ($page_number - 1) . "'>Prev</button>";
    }

    for ($i = $start_page; $i <= $end_page; $i++) {
        $is_active = ($page_number == $i) ? 'myactive' : '';
        $output .= "<button class='btn btn-info {$is_active} left-margin' data-user-page-id='{$i}'>{$i}</button>";
    }

    if ($total_pages > $page_number) {
        $output .= "<button class='btn btn-info left-margin' data-user-page-id='" . ($page_number + 1) . "'>Next</button>";
    }

    $output .= "</div> ";
    echo $output;
} else {
    $output .= "<h1 class='alert alert-danger text-center'>No comment record found</h1>";
    echo $output;
}
