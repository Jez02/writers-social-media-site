<?php
// Start session
session_start();

// Include database configuration
include("php/config.php");

// Check if the logout button is clicked
if(isset($_POST['logout'])) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to the login page
    header("Location: index.php");
    exit;
}

// Check if the post ID is provided in the URL
if(isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];

    // Retrieve the post from the database
    $post_query = mysqli_query($con, "SELECT posts.*, users.Username AS author_name, users.Id AS userid FROM posts LEFT JOIN users ON posts.userid = users.Id WHERE posts.postid = $post_id");
    
    // Check if the query was successful
    if($post_query && mysqli_num_rows($post_query) > 0) {
        $post = mysqli_fetch_assoc($post_query);
    } else {
        // If the post is not found, redirect to an error page or display a message
        echo "Post not found.";
        exit;
    }
} else {
    // If post ID is not provided in the URL, redirect to an error page or display a message
    echo "Post ID not provided.";
    exit;
}

// Retrieve user's theme preference from the database
$user_id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
$theme_query = mysqli_query($con, "SELECT theme FROM users WHERE Id = $user_id");
if($theme_query && mysqli_num_rows($theme_query) > 0) {
    $user_theme = mysqli_fetch_assoc($theme_query)['theme'];
} else {
    $user_theme = 'light'; // Default to light theme if theme retrieval fails
}
$theme_css = ($user_theme === 'dark') ? 'reading_dark.css' : 'reading_light.css';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencraft</title>
    <link id="theme" rel="stylesheet" href="/Pencraft/styles/<?php echo $theme_css; ?>">
    <style>
        /* CSS for hiding the full content initially */
        .full-content {
            display: block; /* Show the full content by default */
        }
        .container {
            background-color: #ffffff; /* Set container background color to white */
            color: #000000; /* Set text color to black */
            max-width: 800px;
            margin: 20px auto; /* Add margin between navbar and container */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            text-align: center; /* Center the content */
        }
        .post-title {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .post-author {
            font-style: italic;
            color: #666666;
            margin-top: 10px;
        }
        .post-content {
            line-height: 1.6;
        }
    </style>
</head>
<body class="<?php echo $user_theme === 'dark' ? 'dark-theme' : 'light-theme'; ?>">
<h1>Pencraft</h1> <!-- Add the Pencraft logo text -->

<div class="navbar">
    <a href="dashboard.php">Dashboard</a>
    <a href="home.php">Profile</a>
    <form method="post">
        <button type="submit" name="logout">Log Out</button>
    </form>
</div>
<!-- Displays information from the database -->
<div class="container">
    <?php
    if(isset($post)) {
        echo '<h2 class="post-title">' . $post['title'] . '</h2>';
        echo '<p class="post-post">' . $post['post'] . '</p>';
        echo '<p class="post-author">By: <a href="profile.php?user_id=' . $post['userid'] . '">' . $post['author_name'] . '</a></p>'; // Modified line
    } else {
        echo '<p>Post not found.</p>';
    }
    ?>
</div>

<script>
// Apply the retrieved theme on page load
window.onload = function() {
    var themeLink = document.getElementById('theme');
    themeLink.setAttribute('href', '/Pencraft/styles/<?php echo $theme_css; ?>');
};
</script>
</body>
</html>
