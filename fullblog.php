<?php
// Database connection (replace with your actual database connection details)
include './db.connection/db_connection.php';

// Get blog ID from URL
$blog_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($blog_id > 0) {
    // Fetch blog data
    $stmt = $conn->prepare("SELECT title, main_content, full_content, title_image, main_image, video FROM blogs WHERE id = ?");
    $stmt->bind_param("i", $blog_id);
    $stmt->execute();
    $stmt->bind_result($title, $main_content, $full_content, $title_image, $main_image, $video);
    $stmt->fetch();
    $stmt->close();
} else {
    echo "Invalid blog ID.";
    exit;
}

$conn->close();
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
     @media (max-width: 767px) {
       .scrollable-div {
         order: 1;
         margin-bottom: 150px;
         padding: 50px;
       }

       .readmore_btn {
         width: 150px;
         margin-left: 15px;
       }
     }

     .readmore_btn {
       width: 120px;


     }
   </style>



 </head>



 <body>

   <!-- ======= Header ======= -->
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
   </header><!-- End Header -->
  
   <main>
        <!-- ======= Blogs Section ======= -->
        <!-- <div class="page-header bg-more-light tittle-image">
            <?php
            if (!empty($title_image)) {
                $title_image_path = "./admin/uploads/photos/{$title_image}";
                echo "<img class='img-fluid img_sts' src='{$title_image_path}' style='width: 3000px;  ' alt='Title Image'>";
            } else {
                echo "<img class='img-fluid img_sts' src='assets/images/title images2/Deep_vein_thrombosis_title_image_one_stop_vascular_solutions.webp' style='width: 3000px;' alt='Deep_vein_thrombosis_title_image_one_stop_vascular_solutions'>";
            }
            ?>
        </div> -->

        <div class="container blog-detailed blog-detailed-sidebar" style="padding-bottom: 0px;padding-top: 50px;">
            <div class="row">
                <div class="col-lg-8 offset-lg-0 col-sm-8 offset-sm-2 col-10 offset-1 order-lg-1">
                    <div class="blog-content">
                        <h4 class="blog-title tittle ls-n-20" style="color: #283779; font-weight:800"><?php echo htmlspecialchars($title); ?></h4>

                        <p class="main-content" style="text-align: justify;">
                            <?php echo $main_content; ?>
                        </p>

                        <?php
                        // Check if video is available
                        if (!empty($video)) {
                            $video_path = "./admin/uploads/videos/{$video}";
                            echo "<video class='main-video img-fluid' controls>
                    <source src='{$video_path}' type='video/mp4'>
                    Your browser does not support the video tag.
                  </video>";
                        }
                        // If no video, display the image
                        elseif (!empty($main_image)) {
                            $main_image_path = "./admin/uploads/photos/{$main_image}";
                            echo "<img class='main-image img-fluid blog_main_img' src='{$main_image_path}'  alt='Main Image'>";
                        }
                        ?>

                        <div class="full-content">
                            <?php echo $full_content; ?>
                        </div>
                    </div>
                </div>




                <div class="col-lg-4 offset-lg-0 col-sm-8 offset-sm-2 col-10 offset-1 order-lg-2">
                    <div class="side-bar">


                        <div class="row scrollable-row" style="max-height: 700px; overflow-y: auto;  overflow-x:hidden">
                            <?php
                            // Fetch all blog data for sidebar
                            $conn = new mysqli($servername, $username, $password, $dbname); // Re-establish connection
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            $sql = "SELECT id, title, main_image FROM blogs ORDER BY created_at DESC";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $sidebar_image_path = !empty($row['main_image']) ? "./admin/uploads/photos/{$row['main_image']}" : "https://mailrelay.com/wp-content/uploads/2018/03/que-es-un-blog-1.png";
                                    $title = strlen($row['title']) > 20 ? substr($row['title'], 0, 50) . '...' : $row['title'];

                                    echo "
                      <div class='col-5 background_sidebar mb-3'>
                          <figure>
                              <img src='{$sidebar_image_path}' class='w-100 height-auto mt-3 ' alt='Blog Image'>
                          </figure>
                      </div>
                      <div class='col-7   background_sidebar d-flex flex-column justify-content-center mb-3'>
                          <a href='fullblog.php?id={$row['id']}'>
                              <p class='blog-card-text'>{$title}</p>
                          </a>
                      </div>";
                                }
                            } else {
                                echo "<p>No blog posts found.</p>";
                            }
                            $conn->close();
                            ?>
                        </div>



                    </div>
                </div>


            </div>
        </div>

    </main>
   <!-- ======= Footer ======= -->
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
               <li><i class="bx bx-chevron-right"></i> <a href="index.php">Adults</a></li>
               <li><i class="bx bx-chevron-right"></i> <a href="index.php">Children</a></li>
               <li><i class="bx bx-chevron-right"></i> <a href="index.php">Fear</a></li>
               <li><i class="bx bx-chevron-right"></i> <a href="index.php">Anger</a></li>
               <li><i class="bx bx-chevron-right"></i> <a href="index.php">Nerve Weakness</a></li>
               <li><i class="bx bx-chevron-right"></i> <a href="index.php">Sleep Problems</a></li>
               <li><i class="bx bx-chevron-right"></i> <a href="index.php">Migraine</a></li>
               <li><i class="bx bx-chevron-right"></i> <a href="index.php">Stress</a></li>
               <li><i class="bx bx-chevron-right"></i> <a href="index.php">Memory Loss</a></li>


             </ul>
           </div>

           <div class="col-xl-3 col-lg-3 col-md-6 col-7 footer-links">
             <h4>For Children</h4>

             <ul>
               <li><i class="bx bx-chevron-right"></i> <a href="index.php">Stress</a></li>
               <li><i class="bx bx-chevron-right"></i> <a href="index.php">Exam Stress for Children</a>
               </li>
               <li><i class="bx bx-chevron-right"></i> <a href="index.php">Lagging Behind in Studies</a>
               </li>
               <li><i class="bx bx-chevron-right"></i> <a href="index.php">Easily Distracted</a></li>
               <li><i class="bx bx-chevron-right"></i> <a href="index.php">Excessive Mischievousness</a>
               </li>
               <li><i class="bx bx-chevron-right"></i> <a href="index.php">Losing Concentration Easily</a>
               </li>
               <li><i class="bx bx-chevron-right"></i> <a href="index.php">Headache</a></li>
             </ul>
           </div>

           <div class="col-xl-3 col-lg-4 col-md-6 footer-newsletter footerbgcolor">
             <h4>Contact us</h4>
             <p class="mt-2">
               <span class="phone_email"> <strong>Phone:</strong></span> <span class="mini_text">+91
                 9493066633 </span>
               <br>
               <span class="phone_email"> <strong>Email:</strong></span> <span class="mini_text">
                 tripuramindcare@gmail.com</span> <br>
             </p>
             <p class="mt-4 mini_text">
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
               <a href="https://www.facebook.com/dr.akrstripuraskinandmindclinic/" target="_blank"
                 class="facebook"><i class="bx bxl-facebook"></i></a>
               <a href="https://www.instagram.com/dr.akrs_tripura_mind_and_poly?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="
                 target="_blank" class="instagram"><i class="bx bxl-instagram"></i></a>


             </div>

           </div>

         </div>
       </div>
     </div>

     <div class="footer-area-bottom theme-bg pb-3" style="background-color: #01539D">
       <div class="container">
         <div class="row pt-4">
           <div class="col-md-6 col-12">
             <div class="footer-widget__copyright-info info-direction">
               <p class="last_text">
                 <a
                   href="terms.html"
                   style="text-decoration: none; color: #ffffff">Terms & conditions :
                 </a>
                 <a
                   href="privacy.html"
                   style="text-decoration: none; color: #ffffff">
                   Privacy & policy</a>
               </p>
             </div>
           </div>

           <div class="col-md-6 col-12 second_divv_end_brand">
             <div
               class="footer-widget__copyright-info info-direction d-flex flex-row justify-content-end align-items-center">
               <a
                 href="https://bhavicreations.com/"
                 target="_blank"
                 style="
                      text-decoration: none;
                      color: #ffffff;
                      display: flex;
                      align-items: center;
                    ">
                 <p class="mini_text last_text mb-0" style="color: white">
                   Branding By @
                 </p>
                 <img
                   src="assets/img/bhavi_logo/Bhavi_Branding_Stamp.png"
                   class="img-fluid brand_image"
                   alt="" />
               </a>
             </div>
           </div>
         </div>
       </div>

       <style>
         @media (min-width: 1200px) {
           .second_divv_end_brand {
             padding-left: 35%;
             margin-top: -10px;
           }

           .brand_image {
             width: 23%;
             margin-top: 0%;
             margin-left: 5px;
           }
         }

         @media (min-width: 992px) and (max-width: 1200px) {
           .second_divv_end_brand {
             padding-left: 32%;
             margin-top: -10px;
           }

           .brand_image {
             width: 23%;
             margin-top: 0%;
             margin-left: 5px;
           }
         }

         @media (max-width: 768px) {
           .second_divv_end_brand {
             padding-left: 4%;
             margin-top: 0px;
           }

           .brand_image {
             width: 12%;
             margin-top: 0%;
             margin-left: 5px;
           }
         }

         @media (min-width: 768px) and (max-width: 992px) {
           .second_divv_end_brand {
             padding-left: 23%;
             margin-top: -10px;
           }

           .brand_image {
             width: 23%;
             margin-top: 0%;
             margin-left: 5px;
           }
         }
       </style>
     </div>
   </footer>
   <!-- End Footer -->

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