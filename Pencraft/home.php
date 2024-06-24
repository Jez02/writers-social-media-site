<?php 
session_start();

include("php/config.php");

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ensure user is logged in
if(!isset($_SESSION['valid'])){
    header("Location: index.php");
    exit;
}

// Get user details
$id = $_SESSION['id'];
$query = mysqli_prepare($con, "SELECT Username, Email, Age, Bio, Id, theme, IFNULL(Profile_picture, 'pfp.jpeg') FROM users WHERE Id = ?");
mysqli_stmt_bind_param($query, "i", $id);
mysqli_stmt_execute($query);
mysqli_stmt_store_result($query);
mysqli_stmt_bind_result($query, $res_Uname, $res_Email, $res_Age, $res_Bio, $res_id, $res_theme, $res_Profile_picture);
mysqli_stmt_fetch($query);
mysqli_stmt_close($query);

// Logout
if(isset($_POST['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

// Fetch user's posts
$post_query = mysqli_query($con, "SELECT postid, title, description, tags, cover, date FROM posts WHERE userid = $id ORDER BY date DESC");

// Check for database errors
if(!$post_query) {
    die("Database error: " . mysqli_error($con));
}

// Update theme preference
if(isset($_POST['theme'])) {
    $theme = $_POST['theme'];
    $update_query = mysqli_prepare($con, "UPDATE users SET theme = ? WHERE Id = ?");
    mysqli_stmt_bind_param($update_query, "si", $theme, $id);
    mysqli_stmt_execute($update_query);
    mysqli_stmt_close($update_query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <?php if ($res_theme == 'dark'): ?>
        <link id="theme-style" rel="stylesheet" href="/Pencraft/styles/home_dark.css">
    <?php else: ?>
        <link id="theme-style" rel="stylesheet" href="/Pencraft/styles/home_light.css">
    <?php endif; ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        .post {
            display: flex;
            align-items: center;
        }
        .post img {
            margin-right: 20px; /* Adjust as needed */
            max-width: 200px; /* Max width same as bookpic */
            max-height: 200px; /* Max height same as bookpic */
        }
        .profile-picture {
            max-width: 200px; /* Adjust the width as needed */
            max-height: 200px; /* Adjust the height as needed */
        }

    .read-here a.read-link {
        color: #2483e8;
    }
    

    </style>
</head>
<body>
<span class="brand">PenCraft</span>

<div class="navbar">
    <a href="dashboard.php">Dashboard</a>
    <a href="#">Profile</a>
    <form method="post">
        <button type="submit" name="logout">Log Out</button>
    </form>
   
</div>

<div class="container">
    <form id="theme-form" method="post">
        <input type="hidden" name="theme" id="theme-value">
        <button type="button" id="theme-toggle-btn">Toggle Theme</button>
    </form>
    <!-- Use dynamic path for the profile picture -->
    <?php if (!empty($res_Profile_picture)): ?>
        <img class="profile-picture" src="<?php echo $res_Profile_picture; ?>" alt="Profile Picture">
    <?php else: ?>
        <img class="profile-picture" src="bookpic.jpeg" alt="Default Profile Picture" style="max-width: 200px; max-height: 200px;">
    <?php endif; ?>
    <div class="profile-info">
        <div>
            <h2><?php echo $res_Uname; ?></h2>
            <p>Email: <?php echo $res_Email; ?></p>
            <p class="bio-label">Bio:</p>
            <!-- Echo the fetched bio here -->
            <p class="bio"><?php echo $res_Bio; ?></p>
        </div>
         <!-- Theme switch buttons -->

        <div class="button-container">
            <a href='edit.php?Id=<?php echo $res_id; ?>' class="edit-button">Edit</a>
        </div>
    </div>

    <h2 class="books-title">My Writings</h2>
    <p><a href="post.php" id="buttoncolour" style="text-decoration: none;">Add new writing</a></p>
    <hr>
<!-- Display user's posts -->
<?php while($post = mysqli_fetch_assoc($post_query)): ?>
    <div class="post" id="post_<?php echo $post['postid']; ?>">
        <?php if (!empty($post['cover'])): ?>
            <img src="<?php echo $post['cover']; ?>" alt="Cover Image" style="max-width: 200px; max-height: 200px;">
        <?php else: ?>
            <img src="bookpic.jpeg" alt="Default Cover Image" style="max-width: 200px; max-height: 200px;">
        <?php endif; ?>
        <div>
            <h3><strong>Title:  </strong><?php echo $post['title']; ?></h3>
            <p><strong>description:</strong><br><?php echo $post['description']; ?></p>
            <p><strong>Tags:</strong> <?php echo $post['tags']; ?></p>
            <p><strong>Date:</strong> <?php echo $post['date']; ?></p> <!-- Display post date -->
            <p class="read-here"><a class="read-link" href="reading.php?post_id=<?php echo $post['postid']; ?>">Read Here</a></p> <!-- Link to reading.php page -->
            <!-- Additional post details as needed -->
            <button class="delete-post" data-postid="<?php echo $post['postid']; ?>">Delete</button>
        </div>
    </div>
    <hr> <!-- Line to separate each post -->
<?php endwhile; ?>

<script>
$(document).ready(function(){
    $('#theme-toggle-btn').click(function(){
        // Get the current theme
        var currentTheme = $('#theme-style').attr('href');
        
        // Toggle between light and dark themes
        if(currentTheme == '/Pencraft/styles/home_light.css') {
            $('#theme-style').attr('href', '/Pencraft/styles/home_dark.css');
            $('#theme-value').val('dark'); // Set theme value to dark
        } else {
            $('#theme-style').attr('href', '/Pencraft/styles/home_light.css');
            $('#theme-value').val('light'); // Set theme value to light
        }
        
        // Submit the form to update theme preference
        $('#theme-form').submit();
    });
        // Deletes post
    $('.delete-post').click(function(){
        var post_id = $(this).data('postid');
        var confirmation = confirm("Are you sure you want to delete this post?");
        if (confirmation) {
            $.ajax({
                type: 'POST',
                url: 'delete_post.php',
                data: {post_id: post_id},
                success: function(data){
                    if(data.trim() === 'success') {
                        // Remove the deleted post from the UI
                        $('#post_'+post_id).next('hr').remove(); // Remove the <hr> element following the deleted post
                        $('#post_'+post_id).remove(); // Remove the post itself
                    } else {
                        console.error('Error deleting post. Response:', data); // Log error response
                        alert('Error deleting post: ' + data);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error deleting post:', error); // Log AJAX error
                    alert('Error deleting post. Please try again later.');
                }
            });
        }
    });
});
</script>

</body>
</html>
