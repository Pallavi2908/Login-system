<?php
    require 'connection.php';
    require 'C:\xampp\htdocs\Login system\vendor\autoload.php';
    $host = "localhost";
    $user = "root";
    $password = '';
    $db_name = "otp_system";
    $con = mysqli_connect($host, $user, $password, $db_name);
    if (!$con) {
        die("Failed to connect with MySQL: " . mysqli_connect_error());
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $email = mysqli_real_escape_string($con, $email);  
        $password = mysqli_real_escape_string($con, $password);  
        // Retrieve the stored hashed password for the given username
        $retrieve_password_query = "SELECT password FROM `otp_table` WHERE email = '$email'";
        // echo $retrieve_password_query."<br>";
        $result = mysqli_query($con, $retrieve_password_query);
        if (mysqli_num_rows($result) > 0) 
        {
            $row = mysqli_fetch_assoc($result);
            $password_from_db = $row['password'];
            if (password_verify($password, $password_from_db)) {
                echo "Login successful!We need to authenticate user";
                header("refresh:5;url=otp.php"); 
                exit();
            } else {              
               echo "Incorrect username or password.";
                echo "MySQLi Error: " . mysqli_error($con);

                echo "<a href='login.html'>Redirect back to login form</a>";

            }
        } else {
            echo "NOT FOUND";
            echo "<a href='register.html'>Redirect back to registration form</a>";
        }
    }

// mysqli_close($con);
?>
