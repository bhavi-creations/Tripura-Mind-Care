<?php
// Database connection (replace with your actual database connection details)
$servername = "localhost";
$username = "drakrtripuramind";
$password = "9rTHaMUNGyUaaW1";
$dbname = "drakrtripuramindcareandpolyclinic";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get blog ID from URL
$blog_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($blog_id > 0) {
    // Fetch blog data
    $stmt = $conn->prepare("SELECT title, content, video FROM blog WHERE id = ?");
    $stmt->bind_param("i", $blog_id);
    $stmt->execute();
    $stmt->bind_result($title, $content, $video);
    $stmt->fetch();
    $stmt->close();
    // $photos_array = json_decode($photos, true);
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Tripura-Mind-Care - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php
        include 'sidebar.php';
        ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php
                include 'navbar.php';
                ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Edit BLOG</h1>
                        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-xl-11 ">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-success">CREATE CONTENT</h6>
                                    <!-- <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div> -->
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <form style='color:black;' id="addblogform" action="addBlog.php" method="POST"
                                        enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label text-primary">ENTER
                                                TITLE</label>
                                            <input type="TEXT" class="form-control text-grey-900"
                                                id="exampleFormControlInput1"
                                                value="<?php echo htmlspecialchars($title); ?>" placeholder="TITLE"
                                                name="title">
                                        </div>
                                        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css"
                                            rel="stylesheet" />

                                        <!-- Create the editor container -->
                                        <label for="exampleFormControlInput1" class="form-label text-primary">ENTER
                                            CONTENT</label>
                                        <div id="editor" style='height:200px;'>
                                            <?php echo $content; ?>
                                        </div>
                                        <input name="content" id="formcontentdata" style="display: none"></input>

                                        <!-- Include the Quill library -->
                                        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

                                        <!-- Initialize Quill editor -->
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function () {
                                                const quill = new Quill('#editor', {
    theme: 'snow'
  });
                                                console.log(document.querySelector('#formcontentdata'))
                                                document.querySelector('#addblogform').onsubmit = function () {
                                                    document.querySelector('#formcontentdata').value = quill.getSemanticHTML();
                                                };
                                            });
                                        </script>
                                        <div class="mb-3">
                                            <label for="formFileMultiple" class="form-label text-primary my-2">Choose
                                                Photos
                                                (you can choose multiple photos)</label>
                                            <input class="form-control" name="photos[]" type="file"
                                                id="formFileMultiple" multiple>
                                        </div>
                                        <div class="mb-3">
                                        </div>
                                        <div class="mb-3">
                                            <label for="formFileMultiple" class="form-label text-primary">Choose
                                                Video</label>
                                            <input class="form-control" name="video" type="file" id="formFileMultiple">
                                        </div>
                                        <input type="hidden" name="id" value="<?php echo $blog_id; ?>">
                                        <div class='row p-3'>
                                            <div class='col-xl-7 col-sm-2 '></div><button type='reset'
                                                class='btn btn-danger mx-1 my-2 col-xl-2'>Clear</button><button
                                                type='submit'
                                                class='btn btn-success mx-1 my-2 col-xl-2'>Publish</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.container-fluid -->

                </div>
                <!-- End of Main Content -->

                <!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                        <div class="footer-widget__copyright">
              <p class="mini_text" style="color:black"> ©2024 Tripura-Mind-Care . All Rights Reserved. Designed &
                Developed by <a href="https://bhavicreations.com/" target="_blank" style="text-decoration: none;color:black">Bhavi
                  Creations</a></p>
            </div>
                        </div>
                    </div>
                </footer>
                <!-- End of Footer -->

            </div>
            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-primary" href="login.html">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin-2.min.js"></script>

        <!-- Page level plugins -->
        <script src="vendor/chart.js/Chart.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="js/demo/chart-area-demo.js"></script>
        <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>