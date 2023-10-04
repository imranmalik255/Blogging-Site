<?php
include 'connect.php';

$query = "SELECT * FROM `Account`";
$result = mysqli_query($con, $query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo $row['Name'];
    }
}
