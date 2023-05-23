<?php
include 'config.php';
include 'header.php';
?>
<?php
    // Check if the form is submitted
    if(isset($_POST['submit'])) {
        // Get the form data
        $title = $_POST['title'];
        $description = $_POST['description'];
        $video_name = $_FILES['video']['name'];
        $thumbnail_name = $_FILES['thumbnail']['name'];
        $video_tmp_name = $_FILES['video']['tmp_name'];
        $thumbnail_tmp_name = $_FILES['thumbnail']['tmp_name'];
        $video_size = $_FILES['video']['size'];
        $thumbnail_size = $_FILES['thumbnail']['size'];
        $video_type = $_FILES['video']['type'];
        $thumbnail_type = $_FILES['thumbnail']['type'];
        $video_ext = strtolower(pathinfo($video_name, PATHINFO_EXTENSION));
        $thumbnail_ext = strtolower(pathinfo($thumbnail_name, PATHINFO_EXTENSION));
        $allowed_video_ext = array("mp4", "avi", "mov");
        $allowed_thumbnail_ext = array("jpg", "jpeg", "png");
        $max_video_size = 50000000; // 50MB
        $max_thumbnail_size = 5000000; // 5MB
        $upload_dir = "./uploads/";
        $video_file = $upload_dir . uniqid() . "." . $video_ext;
        $thumbnail_file = $upload_dir . uniqid() . "." . $thumbnail_ext;

        // Validate the form data
        if(empty($title) || empty($description)) {
            echo "<p>Please fill in all fields.</p>";
        } elseif(!in_array($video_ext, $allowed_video_ext) || !in_array($thumbnail_ext, $allowed_thumbnail_ext)) {
            echo "<p>Invalid file type.</p>";
        } elseif($video_size > $max_video_size || $thumbnail_size > $max_thumbnail_size) {
            echo "<p>File size too large.</p>";
        } else {
            // Check if the upload directory exists and is writable
            if(!is_dir($upload_dir) || !is_writable($upload_dir)) {
                echo "<p>Upload directory is missing or not writable.</p>";
            } else {
                // Upload the files
                if(move_uploaded_file($video_tmp_name, $video_file) && move_uploaded_file($thumbnail_tmp_name, $thumbnail_file)) {
                    // Save the data to the database
                    // Code to save data to database goes here
                    echo "<p>Video uploaded successfully.</p>";
                } else {
                    echo "<p>Failed to upload files.</p>";
                }
            }
        }
    }
?>
<style>
        <?php include 'styles.css';
         ?>
    </style>