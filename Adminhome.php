<?php
include 'connect.php';
include 'Adminsessions.php';
if (isset($_POST['submit']) and isset($_FILES['image'])) {
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
    <title>Home</title>

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
        border-bottom: 1px solid rgb(54, 51, 51) !important;
    }

    .comment-section::-webkit-scrollbar {
        width: 0;
    }

    .comment-section p {
        margin: 0;
        word-break: break-word;
    }

    .thead-dark {
        background-color: #333 !important;
        color: white !important;
    }

    @media (max-width: 600px) {
        table {
            overflow-x: auto;
        }

        ul li .active {
            padding-left: 10px;
        }
    }

    .image-border {
        border-radius: 50%;
        border: 1px solid red;
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

    #custom-toggler-icon {
        filter: invert(1);
    }
</style>

<body>

    <!-- Example Code -->
    <div style="margin-bottom: 10px;">
        <nav class="navbar navbar-expand-lg navbar-light bg-dark" id="navbar-border">

            <a class="navbar-brand profile-margin text-white" href="#">Admin Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon" id='custom-toggler-icon'></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item" style='border-bottom: 3px solid white;'>
                        <a class="nav-link active text-white" aria-current="page" href="Adminhome.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="Adminaddpost.php">Add Post</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" aria-current="page" href="Adminaddblog.php">Add Blog</a>
                    </li>
                </ul>

                <div class="dropdown profile-margin">
                    <a href="#" class="d-flex align-items-center secondary text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">

                        <img src="<?php echo $adminimage; ?>" alt="" width="50" height="50" class="image-fluid" style="border-radius: 50%;">
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

    <!-- Users list -->
    <div class="container" id='user-container'>

    </div>

    <!-- Posts list -->

    <div class="container" id='post-container'>

    </div>

    <!-- Blogs list  -->

    <div class="container" id='blog-container'>

    </div>

    <!-- Comments list-->
    <div class="container" id='comment-table-data'>
    </div>


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

    <!-- AJAX Code For Users -->
    <script>
        function UserAjax(page) {
            $.ajax({
                url: 'Adminshowusers.php',
                type: 'post',
                data: {
                    userpageid: page
                },
                success: function(response) {
                    $('#user-container').html(response);
                }
            })
        }

        function PostAjax(page) {
            $.ajax({
                url: 'Adminshowposts.php',
                type: 'post',
                data: {
                    postpageid: page
                },
                success: function(response) {
                    $('#post-container').html(response);
                }
            })
        }

        function BlogAjax(page) {
            $.ajax({
                url: 'Adminshowblog.php',
                type: 'post',
                data: {
                    blogpageid: page
                },
                success: function(response) {
                    $('#blog-container').html(response);
                }
            });
        }

        function CommentAjax(page) {
            $.ajax({
                url: 'Adminshowcomments.php',
                type: 'post',
                data: {
                    pageid: page
                },
                success: function(response) {
                    $('#comment-table-data').html(response);
                }
            });
        }

        // Users delete Ajax 
        $(document).ready(function() {
            $(document).on('click', '.user-delete-btn', function() {
                var id = $(this).data('user-id');
                var row = $(this).closest("tr");
                $.ajax({
                    url: 'Admindeleteuser.php',
                    type: 'post',
                    data: {
                        userid: id
                    },
                    success: function(response) {
                        row.fadeOut('slow', function() {
                            $(this).remove();
                        })
                    }
                })
            });
            UserAjax(1);
            // Pagination for Users 
            $(document).on('click', '#user-pagination button', function() {
                var id = $(this).data('user-page-id');
                UserAjax(id);
            })

            // Ajax for Delete Posts
            $(document).on('click', '#delete-post-btn', function() {
                var id = $(this).data('post-id');
                var row = $(this).closest('tr');
                $.ajax({
                    url: 'Admindeletepost.php',
                    type: 'post',
                    data: {
                        postid: id
                    },
                    success: function(response) {
                        row.fadeOut('slow', function() {
                            $(this).remove();
                        });
                    }
                })
            });
            PostAjax(1);
            // Pagination for Posts 
            $(this).on('click', '#post-pagination button', function() {
                var id = $(this).data('post-page-id');
                PostAjax(id);
            })
            // AJAX for Delete Blog 

            $(document).on('click', '.blog-delete-btn', function() {
                var blogid = $(this).data('blog-id');
                var row = $(this).closest('tr');
                $.ajax({
                    url: 'Admindeleteblog.php',
                    type: 'post',
                    data: {
                        blogid: blogid
                    },
                    success: function(response) {
                        row.fadeOut('slow', function() {
                            $(this).remove();
                        })
                    }
                })
            })
            BlogAjax(1);
            // Pagination for Blog 
            $(document).on('click', '#blog-pagination button', function() {
                var id = $(this).data('blog-page-id');
                BlogAjax(id);
            })

            // Comment delete through AJAX 

            $(document).on('click', '.comment-delete-btn', function() {
                var commentid = $(this).data('comment-id');
                var row = $(this).closest('tr');
                $.ajax({
                    url: 'Admindeletecomment.php',
                    type: 'post',
                    data: {
                        commentid: commentid
                    },
                    success: function(response) {
                        row.fadeOut('slow', function() {
                            $(this).remove();
                        })
                    }
                })
            })
            CommentAjax(1);
            // Pagination AJAX 
            $(document).on('click', '#comment-pagination button', function() {
                var page_id = $(this).data('page-id');
                CommentAjax(page_id);
            })
        });
    </script>



</body>

</html>