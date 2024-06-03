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
$sql = "SELECT id, title, content, photos, video FROM blog";
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
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

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



</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top">
        <div class="container d-flex align-items-center">

            <a href="index.php" class="logo me-auto">
                <img src="assets/img/tripura/nav_logo.png" alt="">
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
    </header><!-- End Header -->

    <!-- ======= Hero Section ======= -->
    <!-- <div id="carouselExampleFade" data-bs-interval="3000" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-inner cor_med" id="bb">

            <div class="carousel-item active ">
                <img src="assets/img/slide/mind 2.png" class="d-block img-fluid   " alt="...">

            </div>
            <div class="carousel-item">
                <img src="assets/img/slide/mind.png" class="d-block  img-fluid " alt="...">
            </div>
            <div class="carousel-item">
                <img src="assets/img/slide/mind 1.png" class="d-block   img-fluid" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true" style="margin-top: 100px !important;"> </span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true" style="margin-top: 100px !important;"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div> -->


    <main>
        <!-- =======  Blogs Section ======= -->
        <section id="blogs">
            <div class="container">
                <div class="section-title">
                    <h2>Blogs</h2>
                </div>

                <div class="row" id="blogRow">
                    <?php
                    $counter = 0;
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            if ($counter === 0) {
                                echo '<div class="col-md-9  order-2 order-md-1" id="selectedblog">
                <div id="selectedBlogId" style="display: none">' . $counter . '</div>
                <h2 class="mb-3">'
                                    . $row['title'] .
                                    '</h2>
                <video class="custom-video" controls style="width: 100%; height: auto;">
                  <source src="admin/uploads/videos/' . $row['video'] . '" type="video/mp4">
                  Your browser does not support the video tag.
                </video>
                <p>time stamp 12-04-2024</p>
                <div class="row d-flex my-3">';
                                $photos_array = json_decode($row['photos'], true);
                                if (!empty($photos_array)) :
                                    foreach ($photos_array as $photo) : ?>
                                        <img src="admin/uploads/photos/<?php echo htmlspecialchars($photo); ?>" alt="Blog Photo" style="width:100px;height:100px;margin:5px;">
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <p>No photos available.</p>
                                    <?php endif;
                                echo '</div>';
                                echo $row['content'];
                                echo '<div style="display: none" id="lastchild"><video class="custom-video" controls style="width: 100%; height: auto;">
                <source src="admin/uploads/photos/' . $row['video'] . '" type="video/mp4">
                Your browser does not support the video tag.
              </video>
              <h6 class="mb-3" onclick="swapDivs(`' . $counter . '`)">'
                                    . $row['title'] .
                                    '</h6></div>';
                                echo '</div>';
                                if ($result->num_rows > 1) {
                                    echo '<div class="col-md-3  order-1 order-md-2 scrollable-div">';
                                }
                            } else {
                                echo '<div id="sidebardiv' . $counter . '"><video class="custom-video" controls style="width: 100%; height: auto;">
                <source src="admin/uploads/photos/' . $row['video'] . '" type="video/mp4">
                Your browser does not support the video tag.
              </video>
              <h6 class="mb-3" onclick="swapDivs(`' . $counter . '`)">'
                                    . $row['title'] .
                                    '</h6>';
                                echo '<div class="col-md-9  order-2 order-md-1" id="lastchild" style="display: none">
                  <h2 class="mb-3">'
                                    . $row['title'] .
                                    '</h2>
                  <video class="custom-video" controls style="width: 100%; height: auto;">
                    <source src="admin/uploads/videos/' . $row['video'] . '" type="video/mp4">
                    Your browser does not support the video tag.
                  </video>
                  <p>time stamp 12-04-2024</p>
                  <div class="row d-flex my-3">';
                                $photos_array = json_decode($row['photos'], true);
                                if (!empty($photos_array)) :
                                    foreach ($photos_array as $photo) : ?>
                                        <img src="admin/uploads/photos/<?php echo htmlspecialchars($photo); ?>" alt="Blog Photo" style="width:100px;height:100px;margin:5px;">
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <p>No photos available.</p>
                    <?php endif;
                                echo '</div>';
                                echo $row['content'];
                                echo '</div></div>';
                            }
                            $counter++;
                        }
                        if ($result->num_rows > 1) {
                            echo '</div>';
                        }
                    }
                    ?>
                </div>
            </div>
        </section>

        <script>
            function swapDivs(currentDivId) {
                var currentDiv = document.getElementById('sidebardiv' + currentDivId);
                currentDiv.setAttribute('id', 'sidebardiv' + document.getElementById('selectedBlogId').innerText)
                console.log(document.getElementById('selectedBlogId').innerText)
                let selectedBlog = document.getElementById('selectedblog');
                let currentDivLastChild = currentDiv.querySelector('#lastchild');
                let selectedDivLastChild = selectedBlog.querySelector('#lastchild');
                var currentDivNewDiv = document.createElement('div');
                currentDivNewDiv.innerHTML = selectedBlog.querySelector('#lastchild').innerHTML;
                let currentDivNewDivLastChild = document.createElement('div');
                currentDivNewDivLastChild.id = 'lastchild';
                currentDivNewDivLastChild.style.display = 'none';
                selectedBlog.removeChild(selectedDivLastChild);
                selectedBlog.removeChild(document.getElementById('selectedBlogId'));
                currentDivNewDivLastChild.innerHTML = selectedBlog.innerHTML;
                currentDivNewDiv.appendChild(currentDivNewDivLastChild);
                let selectedBlogNewDiv = document.createElement('div');
                selectedBlogNewDiv.innerHTML = currentDiv.querySelector('#lastchild').innerHTML;
                let selectedBlogIDNewDiv = document.createElement('div');
                selectedBlogIDNewDiv.id = 'selectedBlogId';
                selectedBlogIDNewDiv.innerText = currentDivId;
                let selectedBlogNewDivLastChild = document.createElement('div');
                selectedBlogNewDivLastChild.id = 'lastchild';
                selectedBlogNewDivLastChild.style.display = 'none';
                currentDiv.removeChild(currentDivLastChild);
                selectedBlogNewDivLastChild.innerHTML = currentDiv.innerHTML;
                selectedBlogNewDiv.appendChild(selectedBlogIDNewDiv);
                selectedBlogNewDiv.appendChild(selectedBlogNewDivLastChild);
                currentDiv.innerHTML = currentDivNewDiv.innerHTML;
                selectedBlog.innerHTML = selectedBlogNewDiv.innerHTML;
            }
        </script>



        <!-- End Blogs Section -->



    </main>
    <!-- ======= Footer ======= -->
    <footer id="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row">

                    <div class="col-xl-4 col-lg-3 col-md-6 d-flex flex-column justify-content-center">


                        <div class="footer-info d-none d-xl-block  ">
                            <a href="index.php" class="logo me-auto "><img src="assets/img/tripura/nav_logo.png" alt="" class="img-fluid footer_img_size" style="height: 180px; width:auto"></a>

                        </div>

                        <div class="footer-info  d-xl-none">
                            <a href="index.php" class="logo me-auto "><img src="assets/img/tripura/nav_logo.png" alt="" class="img-fluid footer_img_size"></a>

                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-2 col-md-6 col-5 footer-links">
                        <h4>For Adults</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="#facilities">Depression</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#facilities">Anxiety</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#facilities">Fear</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#facilities">Anger</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#facilities">Nerve Weakness</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#facilities">Sleep Problems</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#facilities">Migraine</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#facilities">Stress</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#facilities">Memory Loss</a></li>


                        </ul>
                    </div>

                    <div class="col-xl-3 col-lg-3 col-md-6 col-7 footer-links">
                        <h4>For Children</h4>

                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="#facilities2">Stress</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#facilities2">Exam Stress for Children</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#facilities2">Lagging Behind in Studies</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#facilities2">Easily Distracted</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#facilities2">Excessive Mischievousness</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#facilities2">Losing Concentration Easily</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#facilities2">Headache</a></li>
                        </ul>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-md-6 footer-newsletter footerbgcolor">
                        <h4>Contact us</h4>
                        <p class="mt-2">
                            <span class="phone_email"> <strong>Phone:</strong></span> <span class="mini_text">+91 9493066633 </span>
                            <br>
                            <span class="phone_email"> <strong>Email:</strong></span> <span class="mini_text">
                                tripuramindcare@gmail.com</span> <br>
                        </p>
                        <p class="mt-4">
                            2-56-5,
                            <br> SANTHI NAGAR,<br>
                            ROAD NO.1,<br>
                            100 BUILDING CENTER,<br>

                            HOUSING BOARD COLONY<br>

                            OPP. CHRISTIAN COMMUNITY HALL
                            <br>
                            KAKINADA-533003 <br>
                            Andhra Pradesh, India
                            <br><br>
                        </p>
                        <div class="social-links mt-3">
                            <a href="https://www.facebook.com/dr.akrstripuraskinandmindclinic/" target="_blank" class="facebook"><i class="bx bxl-facebook"></i></a>
                            <a href="https://www.instagram.com/dr.akrs_tripura_mind_and_poly?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank" class="instagram"><i class="bx bxl-instagram"></i></a>


                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="footer-area-bottom theme-bg">
            <div class="container">
                <div class="row  pt-4">
                    <div class="col-xl-8 col-lg-9 col-md-12 col-12">
                        <div class="footer-widget__copyright">
                            <p class="mini_text" style="color:#ffffff"> ©2024 Tripura-Mind-Care . All Rights Reserved. Designed &
                                Developed by <a href="https://bhavicreations.com/" target="_blank" style="text-decoration: none;color:#ffffff">Bhavi
                                    Creations</a></p>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-3 col-md-12 col-12">
                        <div class="footer-widget__copyright-info info-direction ">
                            <p class="mini_text"><a href="terms.html" style="text-decoration: none;color:#ffffff">Terms & conditions
                                </a>
                                <a href="privacy.html" style="text-decoration: none;color:#ffffff"> Privacy & policy</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- End Footer -->

    <!-- WhatsApp link -->


    <!-- Scroll Up Button  -->
    <button id="scrollBtn" onclick="scrollToTop()"><i class="fa-solid fa-arrow-up "></i></button>

    <script>
        // Function to scroll to the top of the page
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth' // Optional, smooth scrolling animation
            });
        }

        // Show scroll button when scrolling down
        window.onscroll = function() {
            scrollFunction()
        };

        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                document.getElementById("scrollBtn").style.display = "block";
            } else {
                document.getElementById("scrollBtn").style.display = "none";
            }
        }
    </script>

    <style>
        #scrollBtn {
            display: none;
            /* Initially hide the button */
            position: fixed;
            /* Fix the position of the button */
            bottom: 20px;
            /* Adjust the bottom distance */
            right: 20px;
            /* Adjust the right distance */
            z-index: 999;
            /* Set a high z-index to ensure the button is on top */
            padding: 10px 15px;
            background-color: #01539D;
            ;
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
        }
    </style>


    <a href="https://api.whatsapp.com/send?phone=919493066633" style="color: #fff;" class="whatsapp-link" target="_blank">
        <i class="fab fa-whatsapp"></i>
    </a>


    <div id="preloader"></div>
    <!-- <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a> -->

    <!-- Vendor JS Files -->
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>