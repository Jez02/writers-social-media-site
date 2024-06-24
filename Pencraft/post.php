<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start the session and include the configuration file
session_start();
include("php/config.php");

// Redirect to the login page if the user is not logged in
if(!isset($_SESSION['valid'])){
    header("Location: index.php");
    exit;
}

// Handle logout
if(isset($_POST['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

// Handle form submission
if(isset($_POST['submit'])) {
    // Retrieve data from the form
    $userid = $_POST['userid'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $tags = $_POST['tags'];
    $post_content = $_POST['post_content'];
    $date = $_POST['date'];
    
    // Check if a file has been uploaded
    if(isset($_FILES["cover"]) && $_FILES["cover"]["error"] == 0 && $_FILES["cover"]["size"] > 0) {
        // Validate the uploaded file
        $allowed_types = array("image/jpeg", "image/png", "image/gif");
        if(in_array($_FILES["cover"]["type"], $allowed_types)) {
            // Choose where to save the uploaded file
            $upload_dir = 'uploads/';
            $file_name = $_FILES['cover']['name'];
            $file_path = $upload_dir . $file_name;
            // Move the uploaded file to the chosen directory
            if(move_uploaded_file($_FILES["cover"]["tmp_name"], $file_path)) {
                // Prepare and execute the SQL query to insert the post into the database
                $insert_query = mysqli_prepare($con, "INSERT INTO posts (userid, title, description, tags, post, date, cover) VALUES (?, ?, ?, ?, ?, ?, ?)");
                mysqli_stmt_bind_param($insert_query, "issssss", $userid, $title, $description, $tags, $post_content, $date, $file_path);
                if(mysqli_stmt_execute($insert_query)) {
                    echo "<script>alert('Post saved successfully');</script>";
                } else {
                    echo "<script>alert('Error saving post: " . mysqli_error($con) . "');</script>";
                }
            } else {
                echo "<script>alert('Error uploading cover image');</script>";
            }
        } else {
            echo "<script>alert('Error: Only JPEG, PNG, and GIF images are allowed');</script>";
        }
    } else {
        // If no file is uploaded, proceed without attempting to process the image
        // Prepare and execute the SQL query to insert the post into the database
        $insert_query = mysqli_prepare($con, "INSERT INTO posts (userid, title, description, tags, post, date) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($insert_query, "isssss", $userid, $title, $description, $tags, $post_content, $date);
        if(mysqli_stmt_execute($insert_query)) {
            echo "<script>alert('Post saved successfully');</script>";
        } else {
            echo "<script>alert('Error saving post: " . mysqli_error($con) . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Writing</title>
    <?php
    // Retrieve user's theme preference from the database
    $id = $_SESSION['id'];
    $theme_query = mysqli_query($con, "SELECT theme FROM users WHERE Id=$id");
    $theme_row = mysqli_fetch_assoc($theme_query);
    $user_theme = $theme_row['theme'];

    // Determine the appropriate theme CSS file for the user
    $user_theme_css = ($user_theme === 'dark') ? 'post_dark.css' : 'post_light.css';
    ?>
    <link rel="stylesheet" href="/Pencraft/styles/<?php echo $user_theme_css; ?>"> <!-- Use the user's theme CSS file -->
</head>
<body>
    <h1>Add New Writing</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <!-- Hidden field for postid, it will be automatically generated -->
        <input type="hidden" name="postid" value="">

        <!-- Hidden field for userid, it will be retrieved from the session -->
        <input type="hidden" name="userid" value="<?php echo $_SESSION['id']; ?>">

        <!-- Hidden field for title, it will be retrieved from the session -->
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" required><br><br>

        <!-- Hidden field for description, it will be retrieved from the session -->
        <label for="description">Description:</label><br>
        <textarea id="description" name="description" rows="4" cols="50" required></textarea><br><br>

        <!-- Hidden field for tags, it will be retrieved from the session -->
        <label for="tags">Tags:</label><br>
        <input type="text" id="tags" name="tags" required><br><br>

        <!-- Hidden field for post, it will be retrieved from the session -->
        <label for="post_content">Your work:</label><br>
        <textarea id="post_content" name="post_content" rows="4" cols="50" required></textarea><br><br>

        <!-- Hidden field for cover, it will be retrieved from the session -->
        <label for="cover">Cover Image (max size: 5MB):</label><br>
        <input type="file" name="cover" id="cover"><br><br>

        <!-- Hidden field for date, it will be automatically set to the current timestamp -->
        <input type="hidden" name="date" value="<?php echo date("Y-m-d H:i:s"); ?>">

        <input type="submit" name="submit" value="Submit">
    </form>

    <!-- Button to go back to the home page -->
    <form action="home.php" method="GET">
        <button type="submit">Back</button>
    </form>
</body>
</html>
