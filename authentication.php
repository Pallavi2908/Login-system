<?php
    require 'connection.php';
    require 'C:\xampp\htdocs\Login system\vendor\autoload.php';

    $host = "localhost";
    $user = "root";
    $password = '';
    $db_name = "login_system";

    $con = mysqli_connect($host, $user, $password, $db_name);
    if (!$con) {
        die("Failed to connect with MySQL: " . mysqli_connect_error());
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['user'];
        $password = $_POST['password'];
        $username = mysqli_real_escape_string($con, $username);  
        $password = mysqli_real_escape_string($con, $password);  
    

        // Retrieve the stored hashed password for the given username
        $retrieve_password_query = "SELECT password FROM `main_table` WHERE username = '$username'";
        echo $retrieve_password_query."<br>";
        $result = mysqli_query($con, $retrieve_password_query);

        if (mysqli_num_rows($result) > 0) 
        {
            $row = mysqli_fetch_assoc($result);
            $password_from_db = $row['password'];

        //     // Compare the entered password with the hashed
            if (password_verify($password, $password_from_db)) {
                echo "Login successful!";
                header("refresh:5;url=login.html"); 
                exit();

            } else {
                
              
                echo "Incorrect username or password.";
                echo "MySQLi Error: " . mysqli_error($con);

                echo "<a href='login.html'>Redirect back to login form</a>";

            }
        } else {
            echo "NOT FOUND";
            echo "<a href='registration.html'>Redirect back to registration form</a>";
        }
    }

mysqli_close($con);
?>
