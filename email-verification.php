<?php
session_start();
include 'connect.php';
if (!isset($_SESSION['Name'])) {
    echo "Can't access this page directly";
    die();
}
$email = $_SESSION['Email'];

if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['send'])) {
    $digit1 = $_POST['input1'];
    $digit2 = $_POST['input2'];
    $digit3 = $_POST['input3'];
    $digit4 = $_POST['input4'];
    $digit5 = $_POST['input5'];
    $digit6 = $_POST['input6'];
    $user_otp = $digit1 . $digit2 . $digit3 . $digit4 . $digit5 . $digit6;
    if (strval($_SESSION['OTP']) === $user_otp) {
        // image into folder
        $image_path  = $_SESSION['Image_path'];

        // database entry

        $name = $_SESSION['Name'];
        $email = $_SESSION['Email'];
        $password = $_SESSION['Password'];


        $query2 = "INSERT INTO `Users` (Image_Path, Name, Email, Password, Role) 
        VALUES('$image_path', '$name', '$email', '$password', 'null')";
        $_SESSION['AccountCreated'] = true;
        // "<div class='alert alert-success'> Account created successfully! </div>";
        mysqli_query($con, $query2);
        header('Location: SignIn.php');
    } else {
        echo "<div class='alert alert-danger'> Password didn't match, try again! </div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mail Confirmation</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet">

</head>
<style>
    body {
        background: linear-gradient(to right, #BFF682, #0E8BF1);
    }

    .custom {
        height: 100vh;
        width: 100%;
    }

    .custom-col {
        width: 100%;
    }

    @media (max-width: 800px) {
        .custom .custom-col {
            height: 65% !important;
            width: 100%;
            margin-left: 22px;
            margin-top: 30px;
        }
    }

    @media (min-width: 801px) and (max-width: 1000px) {
        .custom .custom-col {
            height: 70%;
            width: 55%;
        }
    }

    @media (min-width: 1001px) and (max-width: 1375px) {
        .custom .custom-col {
            height: 70%;
            width: 45%;
        }
    }

    @media (min-width: 1376px) {
        .custom .custom-col {
            height: 70%;
            width: 40%;
        }
    }

    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input:focus {
        outline: none;
    }

    .custom-style {
        width: 50px;
        height: 50px;
        font-size: 30px;
        padding-left: 14px;
        margin-right: 2px;
    }
</style>

<body>
    <div class="container-fluid custom">
        <div class="row custom" style="display: flex; justify-content: center; align-items: center;">
            <!-- Add the new class "custom-col" here -->
            <div class="col-12 rounded shadow bg-light custom-break custom-col" style="height: 70%;">
                <div style="height: 25%; display: flex; align-items: center; justify-content: center;">
                    <img src="Images/checked.png" alt="" width="70" height="70">
                </div>
                <div style="display: flex; flex-direction: column; height: 100%;">
                    <h1 class="text-center fs-1" style="font-style: bold;">
                        Email Verification
                    </h1>
                    <h4 class="text-center mt-5">
                        Please enter 6 digit code which was <br> sent to your email address <br>
                        you can use your account after confirmation! <br>
                        <span>&#x1F60A;</span>
                    </h4>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <div style="display: flex; justify-content: center;">
                            <input type="number" name="input1" id="input1" class="custom-style" oninput="limitToOneDigit(event)">
                            <input type="number" name="input2" id="input2" class="custom-style" oninput="limitToOneDigit(event)">
                            <input type="number" name="input3" id="input3" class="custom-style" oninput="limitToOneDigit(event)">
                            <input type="number" name="input4" id="input4" class="custom-style" oninput="limitToOneDigit(event)">
                            <input type="number" name="input5" id="input5" class="custom-style" oninput="limitToOneDigit(event)">
                            <input type="number" name="input6" id="input6" class="custom-style" oninput="limitToOneDigit(event)">
                        </div>
                        <div class="text-center">
                            <input type="submit" name="send" class="btn btn-danger form-control" style="width: 40%; margin-top: 20px;">
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script>
        function limitToOneDigit(event) {
            const input = event.target;
            const value = input.value;
            const sanitizedValue = value.replace(/[^0-9]/g, ''); // Remove non-numeric characters

            if (sanitizedValue.length > 1) {
                input.value = sanitizedValue.slice(0, 1); // Keep only the first digit
            }
        }
    </script>
</body>

</html>

<?php



?>