<?php
     include 'connection.php';
     $user_name=$_GET['name'];
     echo "<h3>This will delete user from database!</h3>";
     $sql="DELETE FROM  `main_table` WHERE username='$user_name'";
     $result=mysqli_query($con,$sql);
     if($result){
        echo "wiped out,going to CRUD :D";
        header("refresh:5;url=CRUD.html"); 

     }
     else{
       echo" Error:".mysqli_error($con);
     }
?>