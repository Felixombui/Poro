<?php
include 'config.php';
?>
<?php
include 'header.php';
    ?>
<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
</head>
<body>
    <h1>User Profile</h1>
    <?php
        // Start the session
        session_start();

        // Check if the user is logged in
        if(isset($_SESSION['username'])) {
            // Connect to the database
            $servername = "localhost";
            $username = "username";
            $password = "password";
            $dbname = "database";
            $conn = mysqli_connect($servername, $username, $password, $dbname);

            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Retrieve the user data from the database
            $username = $_SESSION['username'];
            $sql = "SELECT * FROM users WHERE username='$username'";
            $result = mysqli_query($conn, $sql);

            // Display the user data
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<p>Username: " . $row["username"] . "</p>";
                    echo "<p>Email: " . $row["email"] . "</p>";
                }
            } else {
                echo "<p>User not found.</p>";
            }

            // Close the database connection
            mysqli_close($conn);
        } else {
            echo "<p>You are not logged in.</p>";
        }
    ?>
</body>
</html>
<style>
        <?php include 'styles.css' ?>
    </style>