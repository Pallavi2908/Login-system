<?php

    include 'connection.php';
    $host="localhost";
    $user="root";
    $password='';
    $db_name="login_system";
    $con=mysqli_connect($host,$user,$password,$db_name);
    if(!$con){
        die("Failed to connect with MySQL: ". mysqli_connect_error()); 
    }
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $username=$_POST['user'];
        $password=$_POST['password'];
        $email=$_POST['email'];
        $company=$_POST['company'];
        if(empty($password)){
            echo "Empty field detected";
            echo "<a href='registration.html'>Redirect back to registration form</a>";
       
        }else{
            $check_username_query= "SELECT * FROM `main_table` WHERE username='$username'";
            $check_email_query= "SELECT * FROM `main_table` WHERE email='$email'";
            $result=mysqli_query($con, $check_username_query);
            $res=mysqli_query($con, $check_email_query);

            if(mysqli_num_rows($result)>0 OR mysqli_num_rows($res)>0){
                echo "Username  or email already exists.";
                echo "<a href='registration.html'>Redirect back to registration form</a>";

            }else{
                //hashing passwords
                $hashed_password=password_hash($password,PASSWORD_DEFAULT);
                $sql="INSERT INTO `main_table`(username,password,email,company) VALUES ('$username','$hashed_password','$email', '$company')";
                if(mysqli_query($con,$sql)){
                    echo "Registered successfully";
                    echo "<a href='login.html'>Click here</a> to log in.";
                }else{
                    echo "Error: ".mysqli_error($con);
                }
            }
        }   
    }
    mysqli_close($con);
?>