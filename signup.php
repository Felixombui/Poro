
<?php
include 'config.php';
include 'header.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: cyan;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            max-width: 500px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }
        label {
            display: block;
            margin-bottom: 10px;
            color: #333;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 16px;
        }
        input[type="submit"] {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border:none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: blue;
        }
        p {
            color: #333;
            margin-bottom: 20px;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
<img src ="images/newuser.png" height="100" width="100"> 
    <h1>User Registration</h1>
    <strong><form action="register.php" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required='required'>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email"required='required'>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required='required'>
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password" id="confirm_password" required>
        <input type="submit" name="submit" value="Register">
    </form></strong>
    <?php
        // Check if the form is submitted
        if(isset($_POST['submit'])) {
            // Get the form data
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            // Validate the form data
            if(empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
                echo "<p class='error'>Please fill in all fields.</p>";
            } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "<p class='error'>Invalid email address.</p>";
            } elseif($password != $confirm_password) {
                echo "<p class='error'>Passwords do not match.</p>";
            } else {
                // Connect to the database
                $servername = "localhost";
                $db_username = "root";
                $db_password = "";
                $dbname = "poro";
                $conn = mysqli_connect($servername, $db_username, $db_password, $dbname);

                // Check connection
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                // Check if the username or email already exists in the database
                $sql = "SELECT * FROM users WHERE username='$username' OR email='$email'";
                $result = mysqli_query($conn, $sql);

                if(mysqli_num_rows($result) > 0) {
                    echo "<p class='error'>Username or email already exists.</p>";
                } else {
                    // Hash the password
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    // Insert the user data into the database
                    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";

                    if(mysqli_query($conn, $sql)) {
                        echo  "<p>User registered successfully.</p>";
                    } else {
                        echo "<p class='error'>Failed to register user.</p>";
                    }
                }

                // Close the database connection
                mysqli_close($conn);
            }
        }
    ?>
</body>
</html>
<style>
        <?php include 'styles.css' ?>
    </style>