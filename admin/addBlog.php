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
    $stmt = $conn->prepare("SELECT photos, video FROM blog WHERE id = ?");
    $stmt->bind_param("i", $blog_id);
    $stmt->execute();
    $stmt->bind_result($existing_photos, $existing_video);
    $stmt->fetch();
    $stmt->close();

    $existing_photos_array = json_decode($existing_photos, true);

    // Handle file uploads
    $photo_paths = $existing_photos_array;
    if (!empty($_FILES['photos']['name'][0])) {
      // Remove old photos
      foreach ($existing_photos_array as $photo) {
        if (file_exists($photo)) {
          unlink($photo);
        }
      }
      // Upload new photos
      $photo_paths = [];
      $photo_directory = "uploads/photos/";
      foreach ($_FILES['photos']['tmp_name'] as $key => $tmp_name) {
        $file_name = generateUniqueFileName($_FILES['photos']['name'][$key]);
        $file_path = $photo_directory . $file_name;
        if (move_uploaded_file($tmp_name, $file_path)) {
          $photo_paths[] = $file_path;
        }
      }
    }

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
    $stmt = $conn->prepare("UPDATE blog SET title = ?, content = ?, photos = ?, video = ? WHERE id = ?");
    $photo_file_names = [];
    foreach ($photo_paths as $photo_path) {
      $photo_file_names[] = basename($photo_path);
    }
    $photos_json = json_encode($photo_file_names); // Save photo paths as JSON
    $stmt->bind_param("ssssi", $title, $content, $photos_json, basename($video_path), $blog_id);

    if ($stmt->execute()) {
      echo "Blog post updated successfully!";
      header("Location: allBlog.php");
    } else {
      echo "Error: " . $stmt->error;
      header("Location: editBlog.php?id=$blog_id");
    }
  } else {
    // Handle file uploads
    $photo_paths = [];
    if (!empty($_FILES['photos']['name'][0])) {
      $photo_directory = "uploads/photos/";
      foreach ($_FILES['photos']['tmp_name'] as $key => $tmp_name) {
        $file_name = generateUniqueFileName($_FILES['photos']['name'][$key]);
        $file_path = $photo_directory . $file_name;
        if (move_uploaded_file($tmp_name, $file_path)) {
          $photo_paths[] = $file_path;
        }
      }
    }

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
    $stmt = $conn->prepare("INSERT INTO blog (title, content, photos, video) VALUES (?, ?, ?, ?)");
    $photo_file_names = [];
    foreach ($photo_paths as $photo_path) {
      $photo_file_names[] = basename($photo_path);
    }
    $photos_json = json_encode($photo_file_names);
    $stmt->bind_param("ssss", $title, $content, $photos_json, basename($video_path));

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

header("Location: allBlog.php");
$conn->close();
?>