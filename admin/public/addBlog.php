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

// Function to generate a unique file name
function generateUniqueFileName($fileName)
{
  $ext = pathinfo($fileName, PATHINFO_EXTENSION);
  return uniqid() . '_' . time() . '.' . $ext;
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $blog_id = intval($_POST['id']);
  $title = $_POST['title'];
  $content = $_POST['content'];

  if ($blog_id) {
    // Fetch existing data
    $stmt = $conn->prepare("SELECT video FROM blog WHERE id = ?");
    $stmt->bind_param("i", $blog_id);
    $stmt->execute();
    $stmt->bind_result($existing_video);
    $stmt->fetch();
    $stmt->close();

    $video_path = $existing_video;
    if (!empty($_FILES['video']['name'])) {
      // Remove old video
      if (file_exists($existing_video)) {
        unlink($existing_video);
      }
      // Upload new video
      $video_directory = "uploads/videos/";
      $file_name = generateUniqueFileName($_FILES['video']['name']);
      $file_path = $video_directory . $file_name;
      if (move_uploaded_file($_FILES['video']['tmp_name'], $file_path)) {
        $video_path = $file_path;
      }
    }

    // Update the blog post in the database
    $stmt = $conn->prepare("UPDATE blog SET title = ?, content = ?, video = ? WHERE id = ?");
    $stmt->bind_param("sssi", $title, $content, $video_path, $blog_id);

    if ($stmt->execute()) {
      echo "Blog post updated successfully!";
      header("Location: allBlog.php");
    } else {
      echo "Error: " . $stmt->error;
      header("Location: editBlog.php?id=$blog_id");
    }
  } else {
    $video_path = "";
    if (!empty($_FILES['video']['name'])) {
      $video_directory = "uploads/videos/";
      $file_name = generateUniqueFileName($_FILES['video']['name']);
      $file_path = $video_directory . $file_name;
      if (move_uploaded_file($_FILES['video']['tmp_name'], $file_path)) {
        $video_path = $file_path;
      }
    }

    // Save the blog post to the database
    $stmt = $conn->prepare("INSERT INTO blog (title, content, video) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $content, basename($video_path));

    if ($stmt->execute()) {
      echo "Blog post published successfully!";
      header("Location: allBlog.php");
    } else {
      echo "Error: " . $stmt->error;
      header("Location: newBlog.php");
    }

    $stmt->close();
  }
}

$conn->close();
?>
