<?php
include 'connect.php';
// include 'Sessions.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
?>
<?php

if (isset($_POST['signup']) and isset($_FILES['image'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $query2 = "SELECT * FROM `Users` WHERE LOWER(Email) = LOWER('{$email}')";
    $result2 = mysqli_query($con, $query2);
    if (mysqli_num_rows($result2) > 0) {

        echo "<div class='alert alert-danger'>Email already exists!</div>";
        die();
    }
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $password = md5(mysqli_real_escape_string($con, $_POST['password']));
    $image = $_FILES['image'];
    $image_name = $image['name'];
    $image_size = $image['size'];
    $image_temp_name = $image['tmp_name'];
    $image_path = 'ImageDB/' . $image_name;
    $img_extension = explode(".", $image_name);
    $img_extension = end($img_extension);
    $allowedFormats = array('jpg', 'jpeg', 'png');
    if (!in_array($img_extension, $allowedFormats)) {
        die('Error: Only JPG, JPEG and PNG images are allowed.');
    }
    $is_uploaded = move_uploaded_file($image_temp_name, $image_path);
    if (!$is_uploaded) {
        die("Image is not uploaded");
    }
    $_SESSION['Image_path'] = $image_path;
    $_SESSION['Name'] = $name;
    $_SESSION['Email'] = $email;
    $_SESSION['Password'] = $password;
    $_SESSION['Image'] = $image;
    $OTP = mt_rand(100000, 999999);
    $_SESSION['OTP'] = $OTP;

    require 'vendor/autoload.php';

    ob_start(); // Start output buffering

    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = 2;
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'mohammedimranrafique@gmail.com';
        $mail->Password   = 'toboxtdbrpteeqxb';
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;

        $mail->setFrom('mohammedimranrafique@gmail.com', 'Imran Malik');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Email verification';
        $mail->Body = "
        <!DOCTYPE html>
        <html>
        <head>
            <title>OTP Email</title>
            <style>
                /* CSS Styles */
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f5f5f5;
                    margin: 0;
                    padding: 0;
                }
                
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    background-color: #ffffff;
                    padding: 20px;
                }
                
                .otp-box {
                    text-align: center;
                    padding: 30px;
                    background-color: #f0f0f0;
                    font-size: 24px;
                    font-weight: bold;
                    color: #333333;
                }
                
                .message {
                    margin-top: 20px;
                    font-size: 16px;
                    color: #666666;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='otp-box'>
                    Your verification OTP is:<br>
                    <span class='otp' style='background: #ff0066; color: white; padding: 10px;'>{$OTP}</span>
                </div>
                <div class='message'>
                    Assalam o Alaikum! Due to the lack of the budget, <br> I am using custom email to verify yourself! <br> Regards: <h1 style='color: red; border: 1px solid black; text-align: center;'>Imran Malik</h1>
                </div>
            </div>
        </body>
        </html>";
        $mail->AltBody = 'Body in plain text for non-HTML mail clients';
        $mail->send();
        echo 'mail is sent successfully';
        header('Location: email-verification.php');
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

    ob_end_clean(); // Clean the output buffer
}
// include 'email-verification.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
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

    .input-design {
        height: 65px;
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
        outline: none !important;
    }
</style>

<body>

    <div class="container">
        <div class="row justify-content-center align-items-center registration-form center">
            <div class="col-sm-10 col-md-8 col-lg-6 col-xxl-5">


                <div class="container background rounded">
                    <div class="text-center pt-5 pb-3">
                        <h1 class="text-dark">Sign Up</h1>
                    </div>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="mt-2" enctype="multipart/form-data" method="post">
                        <label for="imageInput" class="ml-auto width image">
                            <div class="image">
                                <img id="userImage" src="Images/user.png" alt="" width="100" height="100" class="image">
                                <img src="Images/plus.png" alt="" width="25" height="25" id="imageIcon">
                            </div>
                        </label>
                        <div class="py-3 mx-md-4 mx-1">
                            <input type="file" id="imageInput" accept="image/*" style="display: none" name="image" required>
                            <div id="imageError" class="text-danger" style="display: none;">Please select an image</div>
                        </div>

                        <div class="py-3 mx-md-4 mx-1">
                            <input type="text" class="form-control border-dark input-design font-size" placeholder="Enter your name" name="name" required>
                        </div>
                        <div class="py-3 mx-md-4 mx-1">
                            <input type="email" class="form-control border-dark input-design font-size" placeholder="Enter your email" name="email" required>
                        </div>
                        <div class="py-3 mx-md-4 mx-1">
                            <input type="password" class="form-control border-dark input-design font-size" placeholder="Enter your password" name="password" required>
                        </div>
                        <div class="py-3 mx-md-4 mx-1">
                            <input type="submit" class="btn btn-primary form-control input-design bg-primary font-size" value="SIGN UP" name="signup">
                        </div>
                    </form>
                    <div class="py-3 mx-md-4 mx-1">
                        <a href="SignIn.php"> <input type="submit" class="btn btn-dark form-control input-design bg-dark margin-bottom font-size" value="SIGN IN">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        const imageInput = document.getElementById('imageInput');
        const userImage = document.getElementById('userImage');
        const imageIcon = document.getElementById('imageIcon');
        const imageError = document.getElementById('imageError');

        imageInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function() {
                    userImage.src = reader.result;
                    imageIcon.style.display = "none";
                    imageError.style.display = 'none'; // Hide the error message when an image is selected
                };
                reader.readAsDataURL(file);
            }
        });

        document.querySelector('form').addEventListener('submit', function(event) {
            if (!imageInput.files.length) {
                imageError.style.display = 'block';
                event.preventDefault(); // Prevent form submission
            }
        });
    </script>
</body>

</html>