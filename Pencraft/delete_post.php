<?php
session_start();

include("php/config.php");

if(isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];
    $id = $_SESSION['id'];
    
    // Check if the post belongs to the logged-in user
    $check_query = mysqli_query($con, "SELECT * FROM posts WHERE postid = $post_id AND userid = $id");
    $count = mysqli_num_rows($check_query);
    
    if($count == 1) {
        // Delete the post
        $delete_query = mysqli_query($con, "DELETE FROM posts WHERE postid = $post_id");
        if($delete_query) {
            // Post deleted successfully
            echo "success";
            exit;
        } else {
            // Error deleting post
            echo "error";
            exit;
        }
    } else {
        // Post does not belong to the logged-in user
        echo "error";
        exit;
    }
} else {
    // Invalid request
    echo "error";
    exit;
}
?>
