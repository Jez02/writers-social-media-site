<?php 
session_start();
include("php/config.php");

// Check if user is logged in
if(!isset($_SESSION['valid'])){
    header("Location: index.php");
    exit;
}

// Get user id from GET parameter or session
$id = isset($_GET['user_id']) ? $_GET['user_id'] : $_SESSION['id'];

// Fetch user's theme preference
$user_id = $_SESSION['id'];
$user_query = mysqli_query($con, "SELECT theme FROM users WHERE Id = $user_id");
$user_theme = 'light';
if(mysqli_num_rows($user_query) > 0) {
    $user_theme = mysqli_fetch_assoc($user_query)['theme'];
}

// Fetch user details
$query = mysqli_query($con,"SELECT * FROM users WHERE Id=$id");

// Check if user exists
if(mysqli_num_rows($query) > 0) {
    $result = mysqli_fetch_assoc($query);
    $res_Uname = $result['Username'];
    $res_Email = $result['Email'];
    $res_Age = $result['Age'];
    $res_Bio = $result['bio'];
    $res_id = $result['Id'];
    $cover = $result['Profile_picture'];
    $registration_date = $result['registration_date'];
} else {
    header("Location: error.php");
    exit;
}

// Logout
if(isset($_POST['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

// Fetch user's posts
$post_query = mysqli_query($con, "SELECT * FROM posts WHERE userid = $id ORDER BY date DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $res_Uname; ?>'s Profile</title>
    <?php
    // Determine the user's theme CSS file
    $user_theme_css = ($user_theme === 'dark') ? 'home_dark.css' : 'home_light.css';
    ?>
    <link rel="stylesheet" href="/Pencraft/styles/<?php echo $user_theme_css; ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        .post { display: flex; align-items: center; }
        .post img { max-width: 200px; max-height: 200px; margin-right: 20px; }
        .post .text { flex: 1; } /* This will make the text take up the remaining space */
    </style>
</head>
<body>
<!-- Navigation -->
<span class="brand">PenCraft</span>

<div class="navbar">
    <a href="dashboard.php">Dashboard</a>
    <a href="home.php">Profile</a>
    <form method="post">
        <button type="submit" name="logout">Log Out</button>
    </form>
</div>

<div class="container">
    <!-- Display profile picture -->
    <?php if (!empty($cover)): ?>
        <img class="profile-picture" src="<?php echo $cover; ?>" alt="Profile Picture">
    <?php else: ?>
        <img class="profile-picture" src="pfp.jpeg" alt="Default Profile Picture">
    <?php endif; ?>
    <div class="profile-info">
        <div>
            <!-- Display user information -->
            <h2><?php echo $res_Uname; ?></h2>
            <p>Email: <?php echo $res_Email; ?></p>
            <p class="bio-label">Bio:</p>
            <p class="bio"><?php echo $res_Bio; ?></p>
        </div>
    </div>

    <h2 class="books-title"><?php echo $res_Uname; ?>'s Writings</h2>
    <hr>
    <!-- Display user's posts -->
    <?php while($post = mysqli_fetch_assoc($post_query)): ?>
        <div class="post" id="post_<?php echo $post['postid']; ?>">
            <?php if (!empty($post['cover'])): ?>
                <img src="<?php echo $post['cover']; ?>" alt="Cover Image">
            <?php else: ?>
                <img src="bookpic.jpeg" alt="Book Picture">
            <?php endif; ?>
            <div class="text">
                <h3><strong>Title:  </strong><?php echo $post['title']; ?></h3>
                <p><strong>description:</strong><br><?php echo $post['description']; ?></p>
                <p><strong>Tags:</strong> <?php echo $post['tags']; ?></p>
                <p><strong>Date:</strong> <?php echo $post['date']; ?></p> <!-- Display post date -->
                <p class="read-here"><a class="read-link" href="reading.php?post_id=<?php echo $post['postid']; ?>">Read Here</a></p> <!-- Link to reading.php page -->
            </div>
            <!-- Additional styles for post link -->
            <style>
                .read-here a.read-link {
                    color: #2483e8;
                }
            </style>
        </div>
        <hr>
    <?php endwhile; ?>
</div>

</body>
</html>
