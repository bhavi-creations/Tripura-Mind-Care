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

// Function to generate a unique file name
function generateUniqueFileName($fileName)
{
    $ext = pathinfo($fileName, PATHINFO_EXTENSION);
    return uniqid() . '_' . time() . '.' . $ext;
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $blog_id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Handle video upload
    $video_path = "";
    if (!empty($_FILES['video']['name'])) {
        $video_directory = "uploads/videos/";
        $file_name = generateUniqueFileName($_FILES['video']['name']);
        $file_path = $video_directory . $file_name;
        if (move_uploaded_file($_FILES['video']['tmp_name'], $file_path)) {
            $video_path = basename($file_path);
        }
    }

    // Handle photo uploads
    $photo_paths = [];
    if (!empty($_FILES['photos']['name'][0])) {
        $photo_directory = "uploads/photos/";
        foreach ($_FILES['photos']['name'] as $key => $name) {
            if ($_FILES['photos']['error'][$key] === UPLOAD_ERR_OK) {
                $file_name = generateUniqueFileName($name);
                $file_path = $photo_directory . $file_name;
                if (move_uploaded_file($_FILES['photos']['tmp_name'][$key], $file_path)) {
                    $photo_paths[] = basename($file_path);
                }
            } else {
                echo "Error uploading photo: " . $_FILES['photos']['error'][$key];
            }
        }
    }
    $photos_json = json_encode($photo_paths);

    if ($blog_id) {
        // Fetch existing data
        $stmt = $conn->prepare("SELECT video, photos FROM blog WHERE id = ?");
        $stmt->bind_param("i", $blog_id);
        $stmt->execute();
        $stmt->bind_result($existing_video, $existing_photos);
        $stmt->fetch();
        $stmt->close();

        // Ensure $existing_photos is decoded as an array
        $existing_photos = json_decode($existing_photos, true);
        if (!is_array($existing_photos)) {
            $existing_photos = [];
        }

        // If a new video is uploaded, remove the old one
        if (!empty($_FILES['video']['name']) && file_exists("uploads/videos/" . $existing_video)) {
            unlink("uploads/videos/" . $existing_video);
        }

        // If no new video is uploaded, keep the existing one
        if (empty($video_path)) {
            $video_path = $existing_video;
        }

        // Merge existing and new photos
        $merged_photos = array_merge($existing_photos, $photo_paths);
        $photos_json = json_encode($merged_photos);

        // Update the blog post in the database
        $stmt = $conn->prepare("UPDATE blog SET title = ?, content = ?, video = ?, photos = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $title, $content, $video_path, $photos_json, $blog_id);

        if ($stmt->execute()) {
            echo "Blog post updated successfully!";
            header("Location: allBlog.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
            header("Location: editBlog.php?id=$blog_id");
            exit();
        }
    } else {
        // Save the new blog post to the database
        $stmt = $conn->prepare("INSERT INTO blog (title, content, video, photos) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $title, $content, $video_path, $photos_json);

        if ($stmt->execute()) {
            echo "Blog post published successfully!";
            header("Location: allBlog.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
            header("Location: newBlog.php");
            exit();
        }
    }

    $stmt->close();
}

$conn->close();
?>
