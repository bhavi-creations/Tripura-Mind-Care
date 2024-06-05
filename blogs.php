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

    <main>
        <!-- ======= Blogs Section ======= -->
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
                <h2 class="mb-3">' . $row['title'] . '</h2>
                <video class="custom-video" autoplay controls style="width: 100%; height: auto;">
                  <source src="admin/uploads/videos/' . $row['video'] . '" type="video/mp4">
                  Your browser does not support the video tag.
                </video>
                <p>Published On ';
                                ?>
                                <?php echo date("Y-m-d H:i:s", strtotime($row['time']));
                                echo '</p>
                <div class="row d-flex my-3">';
                                echo '</div>';
                                echo $row['content'];
                                echo '<div style="display: none" id="lastchild"><video onclick="swapDivs(`' . $counter . '`)" class="custom-video" controls autoplay style="width: 100%; height: auto;">
                <source src="admin/uploads/videos/' . $row['video'] . '" type="video/mp4">
                Your browser does not support the video tag.
              </video>
              <h6 class="mb-3" onclick="swapDivs(`' . $counter . '`)">' . $row['title'] . '</h6></div>';
                                echo '</div>';
                                if ($result->num_rows > 1) {
                                    echo '<div class="col-md-3  order-1 order-md-2 scrollable-div">';
                                }
                            } else {
                                echo '<div id="sidebardiv' . $counter . '" onclick="swapDivs(`' . $counter . '`)"><video class="custom-video" autoplay controls style="width: 100%; height: auto;">
                <source src="admin/uploads/videos/' . $row['video'] . '" type="video/mp4">
                Your browser does not support the video tag.
              </video>
              <h6 class="mb-3">' . $row['title'] . '</h6>';
                                echo '<div class="col-md-9  order-2 order-md-1" id="lastchild" style="display: none">
                  <h2 class="mb-3">' . $row['title'] . '</h2>
                  <video class="custom-video" autoplay controls style="width: 100%; height: auto;">
                    <source src="admin/uploads/videos/' . $row['video'] . '" type="video/mp4">
                    Your browser does not support the video tag.
                  </video>
                  <p>Published On ';
                                ?>
                                <?php echo date("Y-m-d H:i:s", strtotime($row['time']));
                                echo '</p>
                  <div class="row d-flex my-3">';
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
                currentDiv.setAttribute('id', 'sidebardiv' + document.getElementById('selectedBlogId').innerText);
                console.log(document.getElementById('selectedBlogId').innerText);
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
    </main>
    <!-- ======= Footer ======= -->
    <footer id="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-3 col-md-6 footer-links">
                        <h4>Useful Links</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="index.php">Home</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="index.php">About us</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="index.php">Facilities</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="index.php">Gallery</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="blogs.php">Blogs</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="index.php">Contact</a></li>
                        </ul>
                    </div>

                    <div class="col-xl-4 col-lg-3 col-md-6 footer-contact">
                        <h4>Contact Us</h4>
                        <p>
                            Near Dipti Bridge,<br>
                            Jogendranagar, Agartala,<br>
                            Tripura (W), PIN-799010 <br><br>
                            <strong>Phone:</strong> 8415951498, 8415951496<br>
                            <strong>Email:</strong> tripuramentalhealth@gmail.com<br>
                        </p>
                    </div>
                    <div class="col-xl-4 col-lg-3 col-md-6 footer-info">
                        <h3>About Tripura Mind Care</h3>
                        <p>Tripura Mind Care - (A unit of Cure Heart Centre Pvt. Ltd.) Centre for Mental Health &
                            Wellness, Near
                            Dipti Bridge, Jogendranagar, Agartala, Tripura (W), PIN-799010</p>
                    </div>
                    <div class="col-xl-4 col-lg-3 col-md-6 footer-info">
                        <h3>Follow Us</h3>
                        <div class="social-links mt-3">
                            <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                            <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                            <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                            <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container footer-bottom clearfix">
            <div class="copyright">
                &copy; Copyright <strong><span>Tripura-Mind-Care</span></strong>. All Rights Reserved
            </div>
            <div class="credits">
                Designed by <a href="#">Grow Your Vision</a>
            </div>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>