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

// Check if the id is set in the URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Prepare and bind the delete statement
    $stmt = $conn->prepare("DELETE FROM blog WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    // Execute the statement
    if ($stmt->execute()) {
        echo "Blog post deleted successfully.";
        // Redirect to the blogs page
        header("Location: allBlog.php");
    } else {
        echo "Error deleting blog post: " . $stmt->error;
    }
    
    // Close the statement
    $stmt->close();
} else {
    echo "No blog ID provided.";
    header("Location: allBlog.php");
}

// Close the connection
header("Location: allBlog.php");
$conn->close();
?>
