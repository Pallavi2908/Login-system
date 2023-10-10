<?php
   use PHPMailer\PHPMailer\PHPMailer;
   use PHPMailer\PHPMailer\Exception;
   require 'C:\xampp\htdocs\Login system\vendor\autoload.php';
   require 'connection.php'; // Make sure to include the connection file here
   if(isset($_POST['submit_mail']))
   {
    
    $email=$_POST['email'];
    $mail=new PHPMailer(true);
    try
    {
        //smtp protocol of sending mail
        //but first mail should be sent only if user is found in database
        $query="SELECT * FROM `main_table` WHERE email= '$email'";
        $result=$con->query($query);
        if($result->num_rows>0){
            $row=$result->fetch_assoc();
            $username=$row['username'];

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'pallavii.sinha029@gmail.com'; //sender email/username
            $mail->Password = 'kuzlparkfqxktqzh';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->setFrom('pallavii.sinha029@gmail.com', 'Admin'); //sender email and name of sender
            $mail->addAddress($email); //mail reciever
            $mail->isHTML(true); //message type is HTML not plain text
            $mail->Subject = 'request to update password';
            $mail->Body = 'Hello ' . $username . ',this is a reset forget email';
            //generating a token
            //using 2 tokens: 1 to authenticate user 2nd to use indatabase to pinpoint
            //prevents timing attack
            $selector=bin2hex(random_bytes(8));
            $token=random_bytes(32); //authenticates user;that this user is the right one
            $url = "http://localhost/Login%20system/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);
            $expired=date("U")+180; //1 min duration
            //created new table in same database for password reset
            $sql= "DELETE FROM `reset` WHERE reset_email=?";
            $stmt=mysqli_stmt_init($con); 
            //if prepared statement fails due to some or the other error
            //this increases our readibility and security against injection attacks
            if (!mysqli_stmt_prepare($stmt,$sql)) {
                die("Error");
                exit();
                # code...
            }else{
                mysqli_stmt_bind_param($stmt,"s",$email);
                mysqli_stmt_execute($stmt);

            }
            $sql="INSERT INTO `reset` (reset_email,reset_selector,reset_token,reset_expires)VALUES(?,?,?,?) ";
            if (!mysqli_stmt_prepare($stmt,$sql)) { 
                //using prepared statement again to sanitize data being inserted into our reset  table
                die("Error"). mysqli_stmt_error($stmt);
                exit();
                # code...
            }else{
                //using default hashing method
                $hashedToken=password_hash($token,PASSWORD_DEFAULT);
                mysqli_stmt_bind_param($stmt,"ssss",$email,$selector, $hashedToken,$expired);
                mysqli_stmt_execute($stmt);

            }
            mysqli_stmt_close($stmt);
            mysqli_close($con);
            //closing all connections and prepared statements
            $mail->Body .= '<a href=" '.$url. '">'.$url.'</a>';
            $mail->send();
            echo 'Email sent successfully. Please check mail box!';

        
        }else{
            echo "User not found in our database.Redirecting you to our registration page..";
            header("refresh:5;url=login.html"); 

        }

    }
    catch (Exception $e) {
        echo "Reset email could not be sent. Error: " . $mail->ErrorInfo;
    }

        


   }

?>