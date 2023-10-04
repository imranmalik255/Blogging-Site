<?php
include 'connect.php';

$result2 = mysqli_query($con, "SELECT * FROM `Posts`");
$total_pages = mysqli_num_rows($result2);
$page_limit = 5;
$total_pages = ceil($total_pages / $page_limit);
$page_number = isset($_POST['blogpageid']) ? $_POST['blogpageid'] : 1;
$offset = ($page_number - 1) * $page_limit;

$output = " <h3 class='fs-1 text-md-center mt-5 mb-5 bg-danger p-2 text-white'>Personal Blog</h3>
        <div class='container'>";
$query1 = "SELECT * FROM `Blogs` ORDER BY BlogId DESC LIMIT $offset, $page_limit";
$result1 = mysqli_query($con, $query1);
if (mysqli_num_rows($result1) > 0) {
    while ($row1 = mysqli_fetch_assoc($result1)) {
        $output .= "<div class='row custom-bg-light shadow py-3 rounded mb-3 mx-1'>
                        <div class='col-md-6 col-12'>
                            <img src='{$row1['BlogImagePath']}' alt='' width='100%' height='200' class='image-fluid rounded'>
                        </div>
                        <div class='col-md-6 col-12'>
                            <h1 class='p-3 rounded text-dark mt-2' style='width: auto; background-color: pink;'>
                                {$row1['BlogTitle']}
                            </h1>
                            <span><img src='Images/quote.png' alt=' height='60' width='60'></span>
                            <div class='blog-content'>
                                <p>
                                    &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                                    {$row1['BlogDescription']}
                                </p>
                            </div>
                            <button class='btn btn-primary mb-2 btn1' onclick='toggleText(this)'>Read
                                Less</button>
                        </div>
                        <div style='display: flex; justify-content: space-evenly; align-items: center;'>
                            <div class='custom-mobile-size custom-laptop-size'>
                                <div>
                                    <img src='Images/writing.png' alt=' width='15' height='15'>
                                </div>
                                <div style='width: 5px; height: 5px; background-color: black; border-radius: 50%; margin-left: 5px; margin-top: 5px;'>
                                </div>
                                <div style='display: flex; align-items: center; font-size: smaller; margin-left: 3px; margin-top: 5px;'>
                                    Imran
                                </div>
                            </div>
                            <div class='custom-mobile-size custom-laptop-size'>
                                <div>
                                    <img src='Images/time-left.png' alt=' width='15' height='15'>
                                </div>
                                <div style='width: 5px; height: 5px; background-color: black; border-radius: 50%; margin-left: 5px; margin-top: 5px;'>
                                </div>
                                <div style='display: flex; align-items: center; font-size: smaller; margin-left: 3px; margin-top: 5px;'>
                                    {$row1['BlogTime']}
                                </div>
                            </div>
                            <div class='custom-mobile-size custom-laptop-size'>
                                <div>
                                    <img src='Images/calendar.png' alt='' width='15' height='15'>
                                </div>
                                <div style='width: 5px; height: 5px; background-color: black; border-radius: 50%; margin-left: 5px; margin-top: 5px;'>
                                </div>
                                <div style='display: flex; align-items: center; font-size: smaller; margin-left: 3px; margin-top: 5px;'>
                                    {$row1['BlogDate']}
                                </div>
                            </div>
                        </div>
                    </div>";
    }

    $output .= "<div style='display: flex; justify-content: center; align-items: center; padding: 15px; width: 100%;' id = 'blog-pagination'>";
    $start_page = max(1, $page_number - 1);
    $end_page = min($total_pages, $start_page + 2);

    if ($page_number > 1) {
        $output .= "<button class='btn btn-info left-margin' data-blog-page-id='" . ($page_number - 1) . "'>Prev</button>";
    }

    for ($i = $start_page; $i <= $end_page; $i++) {
        $is_active = ($page_number == $i) ? 'myactive' : '';
        $output .= "<button class='btn btn-info {$is_active} left-margin' data-blog-page-id='{$i}'>{$i}</button>";
    }

    if ($total_pages > $page_number) {
        $output .= "<button class='btn btn-info left-margin' data-blog-page-id='" . ($page_number + 1) . "'>Next</button>";
    }

    $output .= "</div>";
    echo $output;
} else {
    $output .= "<h1 class='alert alert-danger text-center'>No comment record found</h1>";
    echo $output;
}
