<?php
include 'connect.php';
include 'Sessions.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blog</title>

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

        .custom-width {
            width: 50%;
            padding-left: 3px;
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
            /* padding: 1px; */
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

    .myactive {
        background-color: #ff0099;
        color: white;
        border: none;
    }

    input:focus {
        outline: none;
    }

    textarea:focus {
        outline: none;
    }

    .myactive:hover {
        background-color: #ff0066;
        color: white;
        border: none;
    }

    #custom-toggler-icon {
        filter: invert(1);
    }

    .no-spin {
        appearance: none;
        -moz-appearance: textfield;
    }

    .no-spin::-webkit-inner-spin-button,
    .no-spin::-webkit-outer-spin-button {
        appearance: none;
        margin: 0;
    }
</style>

<body>

    <!-- Example Code -->
    <div style="margin-bottom: 10px;">
        <nav class="navbar navbar-expand-lg navbar-light bg-dark" id="navbar-border">

            <a class="navbar-brand profile-margin text-white" href="#">Imran Malik</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon" id='custom-toggler-icon'></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link text-white" aria-current="page" href="Userhome.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="Userabout.php">About</a>
                    </li>
                    <li class="nav-item custom-width">
                        <a class="nav-link text-white" aria-current="page" href="Userblog.php" style='border-bottom: 3px solid white;'>Blog</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Account
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="SignIn.php">Log In</a></li>
                            <li><a class="dropdown-item" href="SignUp.php">Sign Up</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="SignOut.php">Sign Out</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a id="contactButton" class="nav-link text-white" aria-current="page" href="#">Contact</a>
                    </li>
                </ul>

                <div class="dropdown profile-margin">
                    <a href="#" class="d-flex align-items-center secondary text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">

                        <?php
                        $query1 = "SELECT * FROM `Users`";
                        $result1 = mysqli_query($con, $query1) or die("query failed");
                        if (mysqli_num_rows($result1) > 0) {
                            while ($row1 = mysqli_fetch_assoc($result1)) {
                                session_start();
                                $email = $_SESSION['email'];
                                if ($row1['Email'] == $email) {
                        ?>

                                    <img src="<?php echo $row1['Image_Path']; ?>" alt="" width="50" height="50" class="image-fluid profile-image" id="profile" style="border-radius: 50%;">
                    </a>
        <?php
                                    break;
                                }
                            }
                        }
        ?>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
            <li><a class="dropdown-item" href="SignOut.php">Sign out</a></li>
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

    <!-- Blog code  -->

    <section id='blog-container'>


        <!-- blog start  -->



    </section>

    <section id="contact" class="bg-light">
        <div class="container">
            <h3 class="text-center mt-5 mb-5 bg-danger p-2 text-white">Contact us</h3>
            <form action="">
                <div class="row">
                    <label for="" class="text-danger fs-3 mt-3 mb-3">Name*</label>
                    <div class="col-md-6 col-12"><input type="text" class="w-100 p-2 fs-4 border border-danger custom-outline text-danger" placeholder="first name">
                    </div>
                    <div class="col-md-6 col-12 input-margin-top"><input type="text" class="w-100 p-2 fs-4 border border-danger custom-outline text-danger" placeholder="last name">
                    </div>
                </div>
                <div class="row">
                    <label for="" class="text-danger fs-3 mt-3 mb-3">Email*</label>
                    <div class="col-12"><input type="text" class="w-100 p-2 fs-4 border border-danger custom-outline text-danger" placeholder="email">
                    </div>
                </div>
                <div class="row">
                    <label for="" class="text-danger fs-3 mt-3 mb-3">Phone*</label>
                    <div class="col-12"><input type="number" class="w-100 p-2 fs-4 border border-danger custom-outline text-danger no-spin" placeholder="phone">
                    </div>
                </div>
                <div class="row">
                    <label for="" class="text-danger fs-3 mt-3 mb-3">Message Subject*</label>
                    <div class="col-12"><input type="text" class="w-100 p-2 fs-4 border border-danger custom-outline text-danger" placeholder="Subject">
                    </div>
                </div>
                <div class="row">
                    <label for="" class="text-danger fs-3 mt-3 mb-3">Message*</label>
                    <div class="col-12">
                        <textarea name="" id="" cols="30" rows="10" class="w-100 p-2 fs-4 border border-danger custom-outline text-danger" placeholder="Enter your message"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12"><input type="submit" class="w-100 p-2 fs-4 border border-none text-white" style="background-color: black; color: white; margin-top: 10px; margin-bottom: 10px;">
                    </div>
                </div>
            </form>
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

    <script>
        $(document).ready(function() {
            function showBlog(page) {
                $.ajax({
                    url: 'Showuserblog.php',
                    type: 'post',
                    data: {
                        blogpageid: page
                    },
                    success: function(response) {
                        $('#blog-container').html(response);
                    }
                })
            }
            showBlog(1);
            $(document).on('click', '#blog-pagination button', function() {
                var id = $(this).data('blog-page-id');
                showBlog(id);
            });
        });
    </script>

    <script>
        // Function to toggle the "Read More" and "Read Less" button text and content visibility
        // Function to toggle the "Read More" and "Read Less" button text and content visibility
        function toggleText(button) {
            var blogContent = button.parentNode.querySelector('.blog-content');
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

        // Execute the function for all "Read More" buttons on page load
        document.addEventListener("DOMContentLoaded", function() {
            var readMoreBtns = document.getElementsByClassName("btn1");

            for (var i = 0; i < readMoreBtns.length; i++) {
                var readMoreBtn = readMoreBtns[i];
                readMoreBtn.addEventListener("click", function() {
                    toggleText(this);
                });

                var blogContent = readMoreBtn.parentNode.querySelector('.blog-content');
                // Split the content into words and check its length
                var words = blogContent.innerText.trim().split(/\s+/);
                if (words.length > 20) {
                    // If the content has more than 20 words, initially collapse it and display the "Read More" button
                    blogContent.classList.add("collapsed");
                    blogContent.classList.remove("expanded");
                    readMoreBtn.innerText = "Read More";
                } else {
                    // If the content has 20 or fewer words, don't display the "Read More" button
                    blogContent.classList.remove("collapsed");
                    blogContent.classList.add("expanded");
                    readMoreBtn.style.display = "none"; // Hide the "Read More" button
                }
            }
        });
    </script>





</body>

</html>