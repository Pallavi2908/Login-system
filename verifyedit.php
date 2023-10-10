<?php
    include 'connection.php';
    if(isset($_POST['update'])){
        $name=mysqli_real_escape_string($con,$_POST['username']);
        $company_name=mysqli_real_escape_string($con,$_POST['company']);
        $email_id=mysqli_real_escape_string($con,$_POST['email']);
        // $password=mysqli_real_escape_string($con,)
        if(empty($name) || empty($company_name) || empty($email_id)){
            echo "One of the fields is empty,this is not allowed!";
        }else{
            $sql="UPDATE `main_table`  SET username='$name', email='$email_id', company='$company_name'";
            $result=mysqli_query($con,$sql);
            echo "Data has been updated!";
            echo"<a href='profile.php?name=$name'>View changes</a>";
        }



    }
?>