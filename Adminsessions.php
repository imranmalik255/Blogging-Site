<?php
session_start();
if (!isset($_SESSION['adminemail'])) {
    header("Location: SignIn.php");
}
