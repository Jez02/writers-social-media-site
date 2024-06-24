
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PenCraft</title>
    <?php
    session_start();
    include("php/config.php");

    if(!isset($_SESSION['valid'])){
        header("Location: index.php");
        exit; // Ensure to exit after redirection
    }

    if(isset($_POST['logout'])) {
        session_destroy();
        header("Location: index.php");
        exit; // Ensure to exit after redirection
    }

    // Retrieve user's theme preference from the database
    $id = $_SESSION['id'];
    $theme_query = mysqli_query($con, "SELECT theme FROM users WHERE Id=$id");
    $theme_row = mysqli_fetch_assoc($theme_query);
    $current_theme = $theme_row['theme'];

    // Fetch all posts from the database
    if(isset($_GET['sort']) && ($_GET['sort'] == 'oldest')) {
        $post_query = mysqli_query($con, "SELECT posts.*, users.Id AS author_id, users.Username AS author_name FROM posts LEFT JOIN users ON posts.userid = users.Id ORDER BY date ASC");
    } else {
        $post_query = mysqli_query($con, "SELECT posts.*, users.Id AS author_id, users.Username AS author_name FROM posts LEFT JOIN users ON posts.userid = users.Id ORDER BY date DESC");
    }
    ?>
    <?php
    // Determine the appropriate theme CSS file
    $theme_css = ($current_theme === 'dark') ? 'dashboard_dark.css' : 'dashboard_light.css';
    ?>
    <link id="theme" rel="stylesheet" href="/Pencraft/styles/<?php echo $theme_css; ?>"> <!-- Apply the retrieved theme -->
    <style>
        /* CSS to position the logout button */
        .logout-container {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        /* CSS for the navbar */
        .navbar {
            background-color: #333;
            overflow: hidden;
            text-align: center; /* Center the links */
            margin-bottom: 20px; /* Add margin to the bottom */
        }

        .navbar a {
            display: inline-block; /* Make the links display in a row */
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            font-size: 16px;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        /* Style for the cover image */
        .cover-image {
            max-width: 200px; /* Adjust the width as needed */
            max-height: 200px; /* Adjust the height as needed */
        }

        /* Style for the author box */
        .author-box {
            margin-bottom: 20px;
        }

        /* Style for the author details */
        .author-details {
            margin-left: 10px;
        }

        .author-title {
            margin-top: 0;
        }
    </style>
</head>
<body>
    <div class="logout-container">
        <!-- Logout form -->
        <form method="post">
            <button type="submit" name="logout" style="background-color: #333; color: white; padding: 14px 20px; text-decoration: none; border: none; cursor: pointer; font-size: 16px;">
                Logout
            </button>
        </form>
    </div>

    <div class="container">
        <div class="title">
            <h1>PenCraft</h1>
        </div>
        <div class="navbar">
            <a href="#">Dashboard</a>
            <a href="home.php">Profile</a>
        </div>

        <!-- Filter and Sort Section -->
        <div class="filter-sort">
            <label for="sort">Sort by:</label>
            <select id="sort" onchange="sortPosts()">
                <option value="newest" <?php if(!isset($_GET['sort']) || ($_GET['sort'] == 'newest')) echo 'selected'; ?>>Newest First</option>
                <option value="oldest" <?php if(isset($_GET['sort']) && ($_GET['sort'] == 'oldest')) echo 'selected'; ?>>Oldest First</option>
            </select>
        </div>

        <!-- PHP code to fetch and display posts -->
        <?php
        // Check if query was successful
        if ($post_query) {
            // Loop through fetched posts and display them
            while($post = mysqli_fetch_assoc($post_query)):
        ?>
        <div class="author-box">
            <div class="author-image-container">
                <!-- Display the cover image for the post -->
                <?php if (!empty($post['cover'])): ?>
                    <img src="<?php echo $post['cover']; ?>" alt="Cover Image" class="cover-image">
                <?php else: ?>
                    <img src="bookpic.jpeg" alt="Default Cover Image" class="cover-image">
                <?php endif; ?>
                <!-- Add any other author-related information here -->
            </div>
            <div class="author-details">
                <h2 class="author-title"><?php echo $post['title']; ?></h2>
                <p class="author-name">Author: <a href="profile.php?user_id=<?php echo $post['author_id']; ?>"><?php echo $post['author_name']; ?></a></p> <!-- Link to user's profile page -->
                <p class="author-info">Type | Genre: <?php echo $post['tags']; ?></p>
                <p class="author-info"><strong>Description:</strong><br><?php echo $post['description']; ?></p> <!-- Add description here -->
                <p class="author-info date"><strong>Date:</strong> <?php echo $post['date']; ?></p> <!-- Add date here -->
                <!-- Add any other content related to the post here -->
                <p class="read-here"><a href="reading.php?post_id=<?php echo $post['postid']; ?>">Read Here</a></p> <!-- Link to reading.php page -->
            </div>
        </div>
        <?php 
            endwhile; 
        } else {
            echo "Error fetching posts: " . mysqli_error($con);
        }
        ?>
        <!-- End of PHP code -->
    </div>

    <script>
        // Apply the retrieved theme on page load
        window.onload = function() {
            var themeLink = document.getElementById('theme');
            themeLink.setAttribute('href', '/Pencraft/styles/<?php echo $theme_css; ?>');
        };

        function sortPosts() {
            var selectedSort = document.getElementById('sort').value;
            window.location.href = 'dashboard.php?sort=' + selectedSort;
        }
    </script>
</body>
</html>
