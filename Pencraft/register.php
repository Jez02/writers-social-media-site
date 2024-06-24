<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Pencraft/styles/reg.css"> 
    <title>Register</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">

        <?php 
         
         include("php/config.php");
         if(isset($_POST['submit'])){
            $username = $_POST['username'];
            $email = $_POST['email'];
            $age = $_POST['age'];
            $password = $_POST['password'];

            // Verify the uniqueness of the email
            $verify_query = mysqli_query($con,"SELECT Email FROM users WHERE Email='$email'");

            if ($age < 18) {
                echo "<div class='message'>
                          <p>You must be at least 18 years old to register!</p>
                      </div> <br>";
                echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || !strpos($email, '@') || !strpos($email, '.')) {
                echo "<div class='message'>
                          <p>Email must be a valid email address!</p>
                      </div> <br>";
                echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
            } elseif(mysqli_num_rows($verify_query) != 0 ){
                echo "<div class='message'>
                          <p>This email is already in use. Please try another one.</p>
                      </div> <br>";
                echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
            } else {
                // Insert the user into the database
                mysqli_query($con,"INSERT INTO users(Username,Email,Age,Password) VALUES('$username','$email','$age','$password')") or die("Error Occurred");

                echo "<div class='message'>
                          <p>Registration successful!</p>
                      </div> <br>";
                echo "<a href='index.php'><button class='btn'>Login Now</button>";
            }

         } else {
        ?>

            <header>Sign Up</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                    <div id="email-error" class="error-message"></div> <!-- Placeholder for error message -->
                </div>

                <div class="field input">
                    <label for="age">Age</label>
                    <input type="number" name="age" id="age" autocomplete="off" required>
                    <div id="age-error" class="error-message"></div> <!-- Placeholder for error message -->
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field">
                    
                    <input type="submit" class="btn" name="submit" value="Register" required>
                </div>
                <div class="links">
                    Already a member? <a href="index.php">Sign In</a>
                </div>
            </form>
        </div>
        <?php } ?>
    </div>

    <script>
        // Function to validate email format
        function validateEmail() {
            var emailInput = document.getElementById('email');
            var emailError = document.getElementById('email-error');
            var email = emailInput.value;

            if (!email.includes('@') || !email.includes('.')) {
                emailError.textContent = "Email must be a valid email address!";
            } else {
                emailError.textContent = "";
            }
        }

        // Function to show or hide the age error message
        function validateAge() {
            var ageInput = document.getElementById('age');
            var ageError = document.getElementById('age-error');
            var age = parseInt(ageInput.value);

            if (age < 18) {
                ageError.textContent = "You must be at least 18 years old to register!";
            } else {
                ageError.textContent = "";
            }
        }

        // Listen for input event on the email input field
        document.getElementById('email').addEventListener('input', validateEmail);

        // Listen for input event on the age input field
        document.getElementById('age').addEventListener('input', validateAge);
    </script>

</body>
</html>
