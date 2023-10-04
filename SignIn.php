<?php
include 'connect.php';
session_start();
if (isset($_POST['signin'])) {
    $email = $_POST['email'];
    $password = $_POST["password"];
    $query = "SELECT * FROM `Users` WHERE LOWER(`Email`)=LOWER('$email') AND `Password`=md5('$password')";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        session_start();
        if ($row['Role'] === "admin") {
            $_SESSION['adminemail'] = $email;
            header("Location: Adminhome.php");
            exit;
        } else {
            $_SESSION['email'] = $email;
            $_SESSION['userid'] = $row['Id'];
            header("Location: Userhome.php");
            exit;
        }
    } else {
        $error_message = "Incorrect Email or Password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<style>
    .background {
        background-color: #ED5B7D;
    }

    body {
        background: linear-gradient(to right, #BFF682, #0E8BF1);
    }

    @media (max-width: 575.98px) {
        input[type="email"]:focus {
            background-color: transparent;
            box-shadow: none;
            outline: none;
        }
    }

    .input-design {
        height: 75px;
        background: none;
    }

    input::placeholder {
        color: white;
        background: none;
    }

    input:active {
        background-color: none;
    }

    .margin-bottom {
        margin-bottom: 40px;
    }

    .center {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
    }

    .font-size {
        font-size: larger;
    }

    input[type="text"]:focus {
        background-color: transparent;
        outline: none;
    }

    input[type="email"]:focus {
        background-color: transparent;
        outline: none;
    }

    input[type="password"]:focus {
        background-color: transparent;
        outline: none;
    }

    .image {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        position: relative;
    }

    .width {
        width: 100%;
        display: flex;
        justify-content: center;
    }

    #imageIcon {
        position: absolute;
        top: 30px;
        left: 5px;
    }

    input:focus {
        outline: none;
    }

    input[type="email"],
    input[type="password"] {
        width: 100%;
        margin-left: 0;
        margin-right: 0;
        height: 75px;
        background: none;
    }

    /* Add this custom CSS to adjust button width and remove margins */
    input[type="submit"] {
        width: 100%;
        margin-left: 0;
        margin-right: 0;
        height: 75px;
        background: none;
    }
</style>

<body>
    <div class="container">
        <div class="row justify-content-center align-items-center registration-form center">
            <div class="col-sm-10 col-md-8 col-lg-6 col-xxl-5">
                <?php
                if (isset($_SESSION['AccountCreated']) && $_SESSION['AccountCreated']) {
                    echo '<div class="alert alert-success">Account created successfully!</div>';
                    $_SESSION['AccountCreated'] = false;
                    // include 'SignOut.php';
                }
                ?>
                <div class="container background rounded">
                    <div class="text-center pt-5 pb-3">
                        <h1 class="text-dark">Sign In</h1>
                    </div>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="mt-2" enctype="multipart/form-data" method="post">
                        <div class="py-3 mx-md-4 mx-1">
                            <input type="email" class="form-control border-dark input-design font-size" placeholder="Enter your email" name="email" required>
                        </div>
                        <div class="py-3 mx-md-4 mx-1">
                            <input type="password" class="form-control border-dark input-design font-size" placeholder="Enter your password" name="password" required>
                        </div>
                        <div class="py-3 mx-md-4 mx-1">
                            <input type="submit" class="btn btn-primary form-control input-design bg-primary font-size" value="SIGN IN" name="signin">
                        </div>
                    </form>
                    <div class="py-3 mx-md-4 mx-1">
                        <a href="SignUp.php">
                            <input type="submit" class="btn btn-dark form-control input-design bg-dark margin-bottom font-size" value="SIGN UP">
                        </a>
                    </div>
                    <?php
                    if (isset($error_message)) {
                        echo "<div class='alert alert-danger'>$error_message</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>