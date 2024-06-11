<?php
// Database connection (replace with your actual database connection details)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Tripura";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch blog data
$sql = "SELECT * FROM blog";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Tripura-Mind-Care</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/tripura/nav_logo.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <link href="assets/css/style.css" rel="stylesheet">
    <style>
        @media (max-width: 768px) {
            #blogRow {
                display: flex;
                flex-direction: column;
            }

            #scrollArea {
                height: 120vh;
                overflow-y: auto;
            }

            #mainBlogContent {
                height: calc(100vh - 120vh);
                overflow-y: auto;
                display: none;
            }
        }
    </style>
</head>

<body>
    <header id="header" class="fixed-top">
        <div class="container d-flex align-items-center">
            <a href="index.php" class="logo me-auto">
                <img src="assets/img/tripura/new-nav-image.png" alt="">
            </a>
            <nav id="navbar" class="navbar order-lg-0 ">
                <ul>
                    <li><a class="nav-link scrollto " href="index.php">Home</a></li>
                    <li><a class="nav-link scrollto  " href="index.php">About</a></li>
                    <li><a class="nav-link scrollto  " href="index.php">Facilities</a></li>
                    <li><a class="nav-link scrollto  " href="index.php">Gallery</a></li>
                    <li><a class="nav-link scrollto  " href="blogs.php">Blogs</a></li>
                    <li><a class="nav-link scrollto " href="index.php">Contact</a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->
            <a href="#appointment" class="appointment-btn scrollto"><span class="d-none d-md-inline">Make an</span>
                Appointment</a>
        </div>
    </header>

    <main>
        <section id="blogs">
            <div class="container">
                <div class="section-title" style="margin-top: 100px;">
                    <h2>Blogs</h2>
                </div>

                <div class="row" id="blogRow">
                    <div id="scrollArea">
                        <?php
                        $counter = 0;
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<div class="blog-preview" onclick="showBlogContent(' . $counter . ')">
                                    <video class="custom-video" autoplay controls style="width: 100%; height: auto;">
                                        <source src="admin/public/uploads/videos/' . $row['video'] . '" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                    <h6 class="mb-3">' . $row['title'] . '</h6>
                                </div>';
                                echo '<div class="full-blog-content" id="blogContent' . $counter . '" style="display: none;">
                                    <h2 class="mb-3">' . $row['title'] . '</h2>
                                    <video class="custom-video" autoplay controls style="width: 100%; height: auto;">
                                        <source src="admin/public/uploads/videos/' . $row['video'] . '" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                    <p>Published On ' . date("Y-m-d H:i:s", strtotime($row['time'])) . '</p>
                                    <div class="row d-flex my-3">';
                                    echo '<div>';
                                    if (!empty($row['photos'])) {
                                        echo '<div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="100">
                                            <div class="swiper-wrapper row">';
                                            foreach (json_decode($row['photos']) as $photo) {
                                                echo '<div class="testimonial-item col-6 col-md-4 col-lg-3">
                                                    <img src="admin/public/uploads/photos/' . htmlspecialchars($photo) . '" alt="Blog Photo" class="img-fluid my-2">
                                                </div>';
                                            }
                                            echo '</div></div>';
                                    } else {
                                        echo '<p>No photos available.</p>';
                                    }
                                    echo '</div></div>';
                                    echo $row['content'];
                                    echo '</div>';
                                $counter++;
                            }
                        }
                        ?>
                    </div>
                    <div id="mainBlogContent">


 

                    </div>
                </div>
            </div>
        </section>

            <script>
                function showBlogContent(blogId) {
                    var blogContent = document.getElementById('blogContent' + blogId).innerHTML;
                    document.getElementById('mainBlogContent').innerHTML = blogContent;
                    document.getElementById('mainBlogContent').style.display = 'block';
                    window.scrollTo(0, document.getElementById('mainBlogContent').offsetTop);
                }
            </script>
    </main>

    <footer id="footer">
        <div class="footer-top" style="background-color:rgb(242 252 255);">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-3 col-md-6 d-flex flex-column justify-content-center">
                        <div class="footer-info d-none d-xl-block">
                            <a href="index.php" class="logo me-auto "><img src="assets/img/tripura/new-nav-image.png"
                                    style="height:150px;" alt=""></a>
                        </div>
                        <div class="footer-info d-block d-xl-none">
                            <a href="index.php" class="logo me-auto "><img src="assets/img/tripura/new-nav-image.png"
                                    class="img-fluid" alt=""></a>
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-2 col-md-6 col-5 footer-links">
                        <h4>For Adults</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="index.php">Depression</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="index.php">Anxiety</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="index.php">Fear</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="index.php">Anger</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="index.php">Nerve Weakness</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="index.php">Phobia</a></li>
                        </ul>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-7 footer-links">
                        <h4>For Child & Teen</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="index.php">Career</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="index.php">Memory</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="index.php">Laziness</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="index.php">Concentration</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="index.php">Anger</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="index.php">Study Problem</a></li>
                        </ul>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-12 footer-newsletter d-flex flex-column justify-content-center"
                        style="text-align: center;">
                        <h4>Follow us on</h4>
                        <div class="social-links " style="text-align: center;">
                            <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                            <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                            <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                            <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
                        </div>
                        <div class="social-links mt-3" style="text-align: center;">
                            <a href="#">www.tripuramindcare.org</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
