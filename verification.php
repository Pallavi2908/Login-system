<?php
    $token=$_GET["token"];
     ?>
    <form action="check_otp.php" method="post">
        <input type="hidden" name="token" value="<?php echo $token ?>">      
        <div class="container-1">
            <i class='bx bxs-lock-alt' ></i>
        
            <input type="text" id="new_otp" name="new_otp" placeholder="Enter OTP" class="otp">
        </div>
        <div class="holder">
            <input type="submit"  id="btn" name="submit_otp" value="Enter">
        </div>    


    </form>
   


    
   
   
 
