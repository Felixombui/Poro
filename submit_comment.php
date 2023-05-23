<?php
include 'header.php';
?>
<?php
include 'config.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Comments and Ratings</title>
</head>
<body>
    <h1>Comments and Ratings</h1>
    <?php
        // Connect to the database
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "poro";
        $conn = mysqli_connect($servername, $username, $password, $dbname);

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Retrieve the video data from the database
        $video_id = 1; // Replace with the actual video ID
        $sql = "SELECT * FROM videos WHERE id='$video_id'";
        $result = mysqli_query($conn, $sql);

        // Display the video data
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<h2>" . $row["title"] . "</h2>";
                echo "<p>" . $row["description"] . "</p>";
                echo '<video width="320" height="240" controls>';
                echo '<source src="' . $row["video_file"] . '" type="' . $row["video_type"] . '">';
                echo '</video>';
                echo '<img src="' . $row["thumbnail_file"] . '" alt="' . $row["title"] . '">';
            }
        } else {
            echo "<p>Video not found.</p>";
        }

        // Retrieve the comments and ratings from the database
        $sql = "SELECT * FROM comments WHERE video_id='$video_id'";
        $result = mysqli_query($conn, $sql);

        // Display the comments and ratings
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<p>" . $row["comment"] . "</p>";
                echo "<p>Rating: " . $row["rating"] . "</p>";
            }
        } else {
            echo "<p>No comments or ratings found.</p>";
        }

        // Close the database connection
        mysqli_close($conn);
    ?>
     <style>
        <?php include 'styles.css' ?>
    </style>
    