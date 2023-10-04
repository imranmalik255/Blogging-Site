<?php
include 'connect.php';
include 'Adminsessions.php';
if (isset($_POST['submit']) && isset($_FILES['image'])) {
    $blog_id = $_POST['blog_id'];
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
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
    date_default_timezone_set('Asia/Karachi');

    $time = date('h:i A');
    $date = date('d/m/y');
    $query2 = "UPDATE `Blogs` SET BlogTitle = '$title', BlogDescription = '$description', BlogImagePath = '$image_path', BlogTime = '$time', BlogDate = '$date' 
    WHERE BlogId = $blog_id";
    mysqli_query($con, $query2);
    header('Location: Adminhome.php');
    echo "<div class='alert alert-success'> Blog added successfully! </div>";
}
?>
<?php
$query1 = "SELECT * FROM `Users` WHERE Email = '{$_SESSION["adminemail"]}'";
$result1 = mysqli_query($con, $query1);
if (mysqli_num_rows($result1) > 0) {
    $data = mysqli_fetch_assoc($result1);
    $adminimage = $data['Image_Path'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Blog</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet">

</head>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .navbar-nav {
        margin: auto;
        display: flex;
        justify-content: space-around;
        width: 60%;
    }

    @media (max-width: 600px) {
        .navbar-nav {
            margin: 0;
            display: inline-block;
            width: auto;
            margin-left: 10px;
        }

        .text-size {
            font-size: 10vw;
        }

        .icon-padding {
            padding: 0 80px;
        }

        .input-margin-top {
            margin-top: 10px;
        }

        .custom-mobile-size {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        .custom-size-mobile-container {
            width: 90% !important;
        }
    }

    @media (min-width: 701px) and (max-width: 1000px) {
        .custom-size-mobile-container {
            width: 50% !important;
        }
    }

    @media (min-width: 1001px) and (max-width: 1300px) {
        .custom-size-mobile-container {
            width: 60% !important;
        }
    }

    @media (max-width: 1300px) {
        .custom-size-mobile-container {
            width: 70% !important;
        }
    }

    @media (max-width: 400px) {
        .custom-size-mobile-container {
            width: 100% !important;
        }
    }

    #navbar-border {
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
    }

    .profile-margin {
        margin-left: 6px;
        margin-right: 60px;
    }

    .image-colour {
        filter: invert(100%);
    }

    .content-center {
        display: flex;
        justify-content: center;
        width: 100%;
        height: 100%;
    }

    .text-colour {
        color: white !important;
    }

    .icon-padding {
        padding: 0 80px;
    }

    .left-margin {
        margin-left: 5px;
    }

    .custom-outline:focus {
        outline-color: red;
        border-radius: none;
    }

    .custom-outline::placeholder {
        color: rgb(244, 98, 98);
    }

    .custom-hr {
        background-color: red;
        height: 5px;
        width: 100%;
    }

    .blog-content.collapsed {
        overflow: hidden;
        max-height: 3em;
        /* Adjust the height to control the initial display */
    }

    .blog-content.expanded {
        max-height: none;
    }

    .custom-laptop-size {
        display: flex;
        width: 100%;
        justify-content: center;
        align-items: center;
    }

    .custom-bg-light {
        background-color: #eee4e4;
    }

    .custom-size-laptop-container {
        width: 40%;
    }
</style>

<body>

    <!-- Example Code -->
    <div style="margin-bottom: 10px;">
        <nav class="navbar navbar-expand-lg bg-light" id="navbar-border">

            <a class="navbar-brand profile-margin" href="#">Admin Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="Adminhome.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Adminaddpost.php">Add Post</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="Admineditblog.php">EditBlog</a>
                    </li>
                </ul>

                <div class="dropdown profile-margin">
                    <a href="#" class="d-flex align-items-center secondary text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">

                        <img src="<?php echo $adminimage; ?>" alt="" width="50" height="50" class="image-fluid" style="border-radius: 50%;">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                        <li><a class="dropdown-item" href="#">Sign out</a></li>
                    </ul>
                </div>
            </div>

        </nav>
    </div>


    <!-- Carousel code  -->

    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">

        <ol class="carousel-indicators">
            <li data-bs-target="#carouselExampleControls" data-bs-slide-to="0" class="active"></li>
            <li data-bs-target="#carouselExampleControls" data-bs-slide-to="1"></li>
            <li data-bs-target="#carouselExampleControls" data-bs-slide-to="2"></li>
        </ol>

        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="Images/image2.png" alt="" class="d-block w-100 image-size">
                <div class="carousel-caption">
                    <h3>Welcome to our site</h3>
                    <p>LA is always so much fun!</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="Images/image2.png" alt="" class="d-block w-100">
                <div class="carousel-caption">
                    <h3>Welcome to our site</h3>
                    <p>LA is always so much fun!</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="Images/image2.png" alt="" class="d-block w-100">
                <div class="carousel-caption">
                    <h3>Welcome to our site</h3>
                    <p>LA is always so much fun!</p>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </a>
    </div>



    <section id="contact">
        <div class="container custom-size-laptop-container custom-size-mobile-container">
            <h3 class="text-center mt-5 mb-5 bg-danger p-2 text-white">Edit Blog</h3>
            <?php
            $blogid = $_GET['id'];
            $result2 = mysqli_query($con, "SELECT * FROM `Blogs` WHERE BlogId = {$blogid}");
            if (mysqli_num_rows($result2) > 0) {
                $row2 = mysqli_fetch_assoc($result2);
            ?>
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-12 text-center">
                            <img src="<?php echo $row2['BlogImagePath']; ?>" alt="" width="100" height="100" style="border-radius: 50%;" id="userImage">

                        </div>
                    </div>
                    <input type="text" hidden value="<?php echo $blogid; ?>" name='blog_id'>
                    <div class="row">
                        <label for="" class="text-danger fs-3 mt-3 mb-3">Title*</label>
                        <div class="col-12"><input type="text" value="<?php echo $row2['BlogTitle']; ?>" class="w-100 p-2 fs-4 border border-danger custom-outline text-danger" placeholder="Enter the title" name="title">
                        </div>
                    </div>
                    <div class="row">
                        <label for="" class="text-danger fs-3 mt-3 mb-3">Description*</label>
                        <div class="col-12"><input type="text" value="<?php echo $row2['BlogDescription']; ?>" class="w-100 p-2 fs-4 border border-danger custom-outline text-danger" placeholder="Enter the description" name="description">
                        </div>
                    </div>
                    <div class="row">
                        <label for="" class="text-danger fs-3 mt-3 mb-3">Select the Picture*</label>
                        <div class="col-12"><input id="imageInput" value="<?php echo $row2['BlogImagePath']; ?>" type="file" class="w-100 p-2 fs-4 border border-danger custom-outline text-danger" name="image">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12"><input type="submit" class="w-100 p-2 fs-4 border border-none text-white" style="background-color: black; color: white; margin-top: 10px; margin-bottom: 10px;" name="submit" value="Edit Blog">
                        </div>
                    </div>
                </form>
            <?php
            }
            ?>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <!-- End Example Code -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Smooth scroll to the contact section when the button is clicked
            $("#contactButton").click(function() {
                $("html, body").animate({
                        scrollTop: $("#contact").offset().top,
                    },
                    500 // The duration of the scroll animation in milliseconds
                );
            });
        });
    </script>
    <!-- Javascript -->

    <script>
        const imageInput = document.getElementById('imageInput');
        const userImage = document.getElementById('userImage');

        imageInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function() {
                    userImage.src = reader.result;
                };
                reader.readAsDataURL(file);
            }
        });

        function toggleText(button) {
            var blogContent = button.previousElementSibling;
            if (blogContent.classList.contains("collapsed")) {
                // If the content is collapsed, expand it and change button text
                blogContent.classList.remove("collapsed");
                blogContent.classList.add("expanded");
                button.innerText = "Read Less";
            } else {
                // If the content is expanded, collapse it and change button text
                blogContent.classList.remove("expanded");
                blogContent.classList.add("collapsed");
                button.innerText = "Read More";
            }
        }

        // Execute the function to check the length of the content on page load
        window.onload = function() {
            var blogContents = document.querySelectorAll(".blog-content");
            var readMoreBtns = document.querySelectorAll(".btn1");

            for (var i = 0; i < readMoreBtns.length; i++) {
                var readMoreBtn = readMoreBtns[i];

                // Attach the click event to each "Read More" button
                readMoreBtn.addEventListener("click", function() {
                    toggleText(this);
                });

                var blogContent = blogContents[i];
                // Split the content into words and check its length
                var words = blogContent.innerText.trim().split(/\s+/);
                if (words.length > 20) {
                    // If the content has more than 20 words, initially collapse it and display the "Read More" button
                    blogContent.classList.add("collapsed");
                    readMoreBtn.innerText = "Read More";
                } else {
                    // If the content has 20 or fewer words, don't display the "Read More" button
                    readMoreBtn.style.display = "none";
                }
            }
        };
    </script>




</body>

</html>