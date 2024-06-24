<?php 
session_start();

include("php/config.php");
if(!isset($_SESSION['valid'])){
    header("Location: index.php");
}

// Initialize error variable
$error = '';

// Check if the delete button is clicked
if(isset($_POST['delete'])){
    $id = $_SESSION['id'];
    
    // Delete user's posts from the posts table
    $delete_posts_query = mysqli_prepare($con, "DELETE FROM posts WHERE userid=?");
    mysqli_stmt_bind_param($delete_posts_query, "i", $id);
    if(mysqli_stmt_execute($delete_posts_query)) {
        // Delete user from the users table
        $delete_query = mysqli_prepare($con, "DELETE FROM users WHERE Id=?");
        mysqli_stmt_bind_param($delete_query, "i", $id);
        if(mysqli_stmt_execute($delete_query)) {
            // Account deleted successfully, redirect to logout page
            header("Location: php/logout.php");
            exit();
        } else {
            $error = "Error deleting account.";
        }
    } else {
        $error = "Error deleting posts associated with the account.";
    }
}

if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $bio = $_POST['bio']; // Updated bio from form

    // File upload handling
    $file_uploaded = false; // Variable to track if a file is uploaded

    if(isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['profile_pic']['tmp_name'];
        $file_name = $_FILES['profile_pic']['name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');
        
        if(in_array($file_ext, $allowed_ext)) {
            // Choose where to save the uploaded file
            $upload_dir = 'uploads/';
            $file_path = $upload_dir . $file_name;

            // Move the uploaded file to the destination directory
            if(move_uploaded_file($file_tmp, $file_path)) {
                $file_uploaded = true; // Set the flag to true if file is uploaded
            } else {
                $error = "Error moving uploaded file.";
            }
        } else {
            $error = "Invalid file format. Allowed formats: jpg, jpeg, png, gif";
        }
    } else if ($_FILES['profile_pic']['error'] !== UPLOAD_ERR_NO_FILE) { // Check if error is not 'no file uploaded'
        $error = "Error uploading file.";
    }

    // Update profile information (including bio) regardless of file upload status
    $id = $_SESSION['id'];
    $update_query = mysqli_prepare($con, "UPDATE users SET Username=?, Email=?, Age=?, Bio=? WHERE Id=?");
    mysqli_stmt_bind_param($update_query, "ssisi", $username, $email, $age, $bio, $id);
    if(mysqli_stmt_execute($update_query)) {
        if(mysqli_stmt_affected_rows($update_query) > 0){
            $error = "Profile Updated!";
            if ($file_uploaded) {
                // Update profile picture if a file is uploaded
                $update_query_pic = mysqli_prepare($con, "UPDATE users SET Profile_picture=? WHERE Id=?");
                mysqli_stmt_bind_param($update_query_pic, "si", $file_path, $id);
                if(mysqli_stmt_execute($update_query_pic)) {
                    if(mysqli_stmt_affected_rows($update_query_pic) <= 0){
                        $error = "Error updating profile picture.";
                    }
                } else {
                    $error = "Error executing SQL query for profile picture update: " . mysqli_error($con);
                }
            }
        } else {
            $error = "Error updating profile information.";
        }
    } else {
        $error = "Error executing SQL query for profile information update: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    // Retrieve user's theme preference from the database
    $id = $_SESSION['id'];
    $theme_query = mysqli_query($con, "SELECT theme FROM users WHERE Id=$id");
    $theme_row = mysqli_fetch_assoc($theme_query);
    $user_theme = $theme_row['theme'];

    // Determine the appropriate theme CSS file for the user
    $user_theme_css = ($user_theme === 'dark') ? 'edit_dark.css' : 'edit_light.css';
    ?>
    <link rel="stylesheet" href="/Pencraft/styles/<?php echo $user_theme_css; ?>"> <!-- Use the user's theme CSS file -->
    <title>Change Profile</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p><a href="home.php"> Pencraft</a></p>
        </div>

        <div class="right-links">
            <a href="php/logout.php" class="btn2">Log Out</a>
        </div>
    </div>
    <div class="container">
        <div class="box form-box">
            <?php 
                if(!empty($error)) {
                    echo "<div class='message'>
                            <p>$error</p>
                        </div> <br>";
                }

                $id = $_SESSION['id'];
                $query = mysqli_query($con,"SELECT * FROM users WHERE Id=$id ");

                while($result = mysqli_fetch_assoc($query)){
                    $res_Uname = $result['Username'];
                    $res_Email = $result['Email'];
                    $res_Age = $result['Age'];
                    $res_Bio = $result['Bio'];
                }
            ?>
            <header>Change Profile</header>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" value="<?php echo $res_Uname; ?>" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" value="<?php echo $res_Email; ?>" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="age">Age</label>
                    <input type="number" name="age" id="age" value="<?php echo $res_Age; ?>" autocomplete="off" required>
                </div>

                <!-- Add a field for biography -->
                <div class="field textarea">
                    <label for="bio">Biography</label>
                    <textarea name="bio" id="bio" rows="5"><?php echo htmlspecialchars($res_Bio); ?></textarea>
                </div>
                
                <!-- Add a field for profile picture -->
                <div class="field">
                    <label for="profile_pic">Profile Picture</label>
                    <input type="file" name="profile_pic" id="profile_pic">
                </div>
                
                <div class="field">   
                    <input type="submit" class="btn" name="submit" value="Update">
                    <a href="home.php" class="btn1">Back</a>
                </div>
                <div class="field">
                    <form action="" method="post" onsubmit="return confirm('Are you sure you want to delete your account?');">
                        <button type="submit" class="btn-link" name="delete">Delete Account</button>
                    </form>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

<?php
include("../php/config.php");
?>
