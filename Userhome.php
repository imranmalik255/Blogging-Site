<?php
session_start();
include 'connect.php';
include 'Sessions.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Varela&display=swap" rel="stylesheet">

</head>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Varela', sans-serif;
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
            width: 60%;
        }

        ul li .active {
            border-bottom-width: 1px;
        }

        .border-class {
            border-bottom: none !important;
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

        .comment-section p {
            padding-left: 10px;
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

    .comment-input:focus {
        border: none;
        outline: none;
    }

    .comment-section::-webkit-scrollbar {
        width: 0;
    }

    .comment-section p {
        margin: 0;
        /* word-break: break-word; */
    }

    .liked-css {
        filter: invert(100%) sepia(100%) saturate(100%) hue-rotate(0deg) brightness(100%) contrast(100%);
    }

    .pointer {
        cursor: pointer;
    }

    #custom-toggler-icon {
        filter: invert(1);
    }

    .posts-color {
        background-color: #ede8ed;
    }

    input:focus {
        outline: none;
    }

    textarea:focus {
        outline: none;
    }

    .myactive {
        background-color: #ff0099;
        color: white;
        border: none;
    }

    .myactive:hover {
        background-color: #ff0066;
        color: white;
        border: none;
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

    .rounded-image {
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        border-radius: 50%;
    }

    .box {
        overflow: hidden;
    }

    .box:hover img {
        scale: 1.2;
        transition: all ease 1s;
    }
</style>

<body>

    <!-- Example Code -->
    <div style="margin-bottom: 10px;">
        <nav class="navbar navbar-expand-lg navbar-light bg-dark" id="navbar-border">

            <a class="navbar-brand profile-margin text-white" href="#">Imran Malik</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon" id="custom-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse text-white" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item custom-width">
                        <a class="nav-link text-white active" aria-current="page" href="Userhome.php" style='border-bottom: 3px solid white;'>Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="Userabout.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" aria-current="page" href="Userblog.php">Blog</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Account
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Log In</a></li>
                            <li><a class="dropdown-item" href="#">Sign Up</a></li>
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

    <div class="container-fluid mt-5">

        <div class="row px-3" id='post-container'>

        </div>
    </div>



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
        function getCurrentPage() {
            var currentPageButton = $('#home-pagination button.myactive');
            if (currentPageButton.length > 0) {
                return currentPageButton.data('home-page-id');
            } else {
                return 1; // Default to the first page if no active button found
            }
        }

        // Function to load posts and comments
        function loadPostsAndComments(page) {
            $.ajax({
                url: 'load.php',
                type: 'POST',
                data: {
                    homepageid: page
                },
                success: function(response) {
                    $('#post-container').html(response);
                }
            });
        }

        // Load posts and comments initially
        loadPostsAndComments(1);

        // Handle the click event on the "comment" button (image)
        $(document).on('click', '.comment-button', function() {
            var postID = $(this).data("comment-id");
            var commentSectionID = "#comment-section-" + postID;
            var commentSection = $(commentSectionID);

            // Check if the comment section is visible
            var isVisible = commentSection.is(":visible");

            // Toggle the visibility of the corresponding comment section
            commentSection.slideToggle();

            // If the comment section was hidden, hide other comment sections (except the one clicked)
            if (!isVisible) {
                $(".comment-section").not(commentSectionID).slideUp();
            }

            // Set the postID as a data attribute in the form
            var form = commentSection.find('.myform');
            form.data("comment-id", postID);
        });

        // Handle form submission when posting a comment
        $(document).on('submit', '.myform', function(e) {
            e.preventDefault(); // Prevent form from submitting traditionally

            // Get the postID from the form data
            var postID = $(this).data("comment-id");

            // Get the comment text from the input field
            var commentText = $(this).find('.comment-input').val();

            // Send the comment data to the server using AJAX
            $.ajax({
                type: 'POST',
                url: 'add_comments.php',
                data: {
                    postId: postID,
                    commentText: commentText,
                    currentPage: getCurrentPage() // Pass the current page number
                },
                success: function(response) {
                    // Handle the response from the server (if needed)
                    // For example, you can update the comment section with the newly added comment
                    // or display a success message to the user.
                    loadPostsAndComments(getCurrentPage()); // Reload the posts and comments after adding a new comment

                    // Clear the input field after submitting the comment
                    $('.myform[data-comment-id="' + postID + '"]').find('.comment-input').val('');
                },
                error: function(xhr, status, error) {
                    // Handle errors, if any
                    console.error(error);
                }
            });

        });

        // Handle the click event on the like and dislike buttons
        $('#post-container').on('click', '.like, .dislike', function() {
            var name = $(this).data('name');
            var postId;
            if (name === 'Like') {
                postId = $(this).data('like-post-id');
            } else if (name === 'Dislike') {
                postId = $(this).data('dislike-post-id');
            }
            $.ajax({
                url: 'change.php',
                type: 'POST',
                data: {
                    status: name,
                    postId: postId
                },
                success: function(response) {
                    // Assuming you want to reload the posts and comments after handling like/dislike
                    loadPostsAndComments(getCurrentPage());
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });

        // Pagination for posts 
        $(document).on('click', '#home-pagination button', function() {
            var id = $(this).data('home-page-id');
            loadPostsAndComments(id);
        })
    </script>

</body>

</html>