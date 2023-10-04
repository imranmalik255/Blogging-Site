<?php
$con = mysqli_connect('localhost', 'root', '', 'BloggingSite_DB');

if (!$con) {
    die('<h1>Database is not connected</h1>');
}
