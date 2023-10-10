<?php
    include 'connection.php';
    include 'read.php';
    $user_name=$_GET['name'];
    $sql="SELECT * FROM main_table where username=?";
    $stmt=mysqli_prepare($con,$sql);
    mysqli_stmt_bind_param($stmt,"s",$user_name);
    mysqli_stmt_execute($stmt);
    $result=mysqli_stmt_get_result($stmt);
    
    $user_info=mysqli_fetch_assoc($result);
    if($user_info){
        // $sql="SELECT * FROM main_table where username=?";

        // $res=mysqli_query($con,$sql);
        // $username=$row['username'];
        echo "<h2>email: {$user_info['email']}</h2>";
        echo "<h2>company: {$user_info['company']}</h2><br>";
        echo "<h3><a href='update.php?name=$user_name'>Click here to Update</a></h3>";
        echo "<h3><a href='delete.php?name=$user_name'>Click here to delete</a></h3>";
        
    }else{
        echo "not found sorry";
    }
    mysqli_close($con);
?>
