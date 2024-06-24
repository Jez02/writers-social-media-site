<?php 
// Start session
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Pencraft/styles/style.css"> <!-- Update the href attribute -->
    <title>Login</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <?php 
             
            // Include database configuration
            include("php/config.php");
            // Check if form submitted
            if(isset($_POST['submit'])){
                // Sanitize user input
                $email = mysqli_real_escape_string($con,$_POST['email']);
                $password = mysqli_real_escape_string($con,$_POST['password']);

                // Query user data from database
                $result = mysqli_query($con,"SELECT * FROM users WHERE Email='$email' AND Password='$password' ") or die("Select Error");
                $row = mysqli_fetch_assoc($result);

                // If user found in database, set session variables and redirect
                if(is_array($row) && !empty($row)){
                    $_SESSION['valid'] = $row['Email'];
                    $_SESSION['username'] = $row['Username'];
                    $_SESSION['age'] = $row['Age'];
                    $_SESSION['id'] = $row['Id'];

                    // Redirect to home.php after successful login
                    header("Location: home.php");
                    exit; // Make sure to exit after redirection
                } else {
                    // Display error message if credentials are invalid
                    echo "<div class='message'>
                    <p>Wrong Username or Password</p>
                    </div>"; // Remove the back button
                }
            }
            ?>
            <!-- Login form -->
            <header>Login</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Login" required>
                </div>
                <div class="links">
                    Don't have an account? <a href="register.php">Sign Up Now</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
