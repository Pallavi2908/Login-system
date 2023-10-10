<?php
    include 'connection.php';
    $host="localhost";
    $user="root";
    $password="";
    $db_name="login_system";
    $con=mysqli_connect($host,$user,$password,$db_name);
    if(!$con){
        die("Failed to connect with MySQL: ". mysqli_connect_error()); 
    }
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $username=mysqli_real_escape_string($con,$_POST['username']); //$username = mysqli_real_escape_string($db, $_POST['username']);
        $pwd=mysqli_real_escape_string($con,$_POST['pwd']);
        $reset_pwd=mysqli_real_escape_string($con,$_POST['checkpwd']);
        $email=mysqli_real_escape_string($con,$_POST['email']);
        $company=$_POST['company'];

        if(strlen($username)<5 OR !preg_match('/^[a-zA-Z0-9]+$/', $username)){
            echo "Invalid username format";
            exit();
        }else{
            $check_username_query= "SELECT * FROM `main_table` WHERE username='$username'";
            $check_email_query= "SELECT * FROM `main_table` WHERE email='$email'";
            $check_password_query= "SELECT * FROM `main_table` WHERE password='$pwd'";
            $result_user=mysqli_query($con,$check_username_query);
            $result_email=mysqli_query($con,$check_email_query);
            $result_pwd=mysqli_query($con,$check_password_query);

            if(mysqli_num_rows($result_user)>0 OR mysqli_num_rows($result_email)>0 OR mysqli_num_rows($result_pwd)>0){
                echo "One of the entered data already exists in the database.\n";
                echo "<a href=read.html>Login?</a>";
            }else if($pwd!=$reset_pwd){
                echo "Passwords entered do not match!";
                header("refresh:5;url=CRUD.html");           
            }else{
               
                $hashed_password=password_hash($pwd,PASSWORD_DEFAULT);
                $sql="INSERT INTO `main_table`(username,password,email,company) VALUES ('$username','$hashed_password','$email', '$company')";
                if(mysqli_query($con,$sql)){
                    echo "<a href='read.html'>Go to Read form</a>";
                }else{
                    echo "Error: ".mysqli_error($con);
                }
            
            }
            
        }
        
    }



   
    
?>