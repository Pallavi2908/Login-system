<?php
    include 'connection.php';
    
     $user="root";
    $password="";
    $db_name="login_system";
    $con=mysqli_connect($host,$user,$password,$db_name);
    if(!$con){
        die("Failed to connect with MySQL: ". mysqli_connect_error()); 
    }
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $username=$_POST['username'];
        $sql="SELECT username,password FROM main_table WHERE username='$username'";
        $result=mysqli_query($con,$sql);
        if(!$result){
            die("Error in query.");
        }
        while($row=mysqli_fetch_assoc($result)){
            $username=$row['username'];
            echo "<a href='profile.php?name=$username'>$username 's profile</a>";
        }
        mysqli_close($con);

    }
?>