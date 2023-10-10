<?php
    include 'connection.php';
    require 'C:\xampp\htdocs\otp\vendor\autoload.php';
    use PHPMailer\PHPMailer\PHPMailer;
    if(!$con){
        die("Failed to connect with MySQL: ". mysqli_connect_error()); 
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $otp=rand(10000, 99999);
        $token=uniqid();
        // echo $token;
        // echo $email;
        // echo $otp;
        $otp_expiry = date('Y-m-d H:i:s', strtotime('+200 seconds'));
        
        $sql="UPDATE `otp_table` SET otp=?, otp_expiry=? WHERE email=?";
        $stmt=$con->prepare($sql);
        $stmt->bind_param("sss",$otp,$otp_expiry,$email);
        $stmt->execute();
        $stmt->close();
        $mail = new PHPMailer(true);


        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail-> SMTPAuth = true;
        $mail->Username = 'pallavii.sinha029@gmail.com'; //sender email/username
        $mail->Password = 'kuzlparkfqxktqzh';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->setFrom('pallavii.sinha029@gmail.com', 'Admin'); //sender email and name of sender
        $mail->addAddress($email); //mail reciever
        $mail->isHTML(true); //message type is HTML not plain text
        $mail->Subject = 'request to login';
        $url="http://localhost/otp/verification.php?token=".$token;
        $mail->Body = "Hello ,this is an otp-based login mail.Your OTP code is: $otp.Link to verify OTP:<br><a href='$url'>$url</a>";
        $mail->send();
        echo "Please check your email!";
        $stmt=mysqli_stmt_init($con); 
        $sql="UPDATE `otp_table` SET token=? WHERE email=?";
        if(!mysqli_stmt_prepare($stmt,$sql)){
            die("error");
            exit();
        }else{
            mysqli_stmt_bind_param($stmt,"ss",$token,$email);
            mysqli_stmt_execute($stmt);

        }

    }
    mysqli_stmt_close($stmt);
    // mysqli_close($con);

?>
 

   
