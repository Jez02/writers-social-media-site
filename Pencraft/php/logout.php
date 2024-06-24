<?php
      // Start session
      session_start();
      // Destroy session
      session_destroy();
      // Redirect to index.php in parent directory
      header("Location: ../index.php");
?>
