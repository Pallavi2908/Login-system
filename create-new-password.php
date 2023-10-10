<?php
    $selector=$_GET["selector"];
    $validator=$_GET["validator"];

    if(empty($selector) || empty($validator)){
        echo "Unable to validate request";
    }else{
        //making sure that the tokens are in valid format-> hexadecimal format
        if(ctype_xdigit($validator)==true && ctype_xdigit($selector)==true){
            ?>
            <!-- if yes then user can gob ahead with generating new password -->
            <form action="new-password.php" method="post">
                <input type="hidden" name="selector" value="<?php echo $selector ?>">
                <input type="hidden" name="validator" value="<?php echo $validator ?>">
                <input type="text" name="pwd" placeholder="Enter new password...">
                <input type="password" name="repeat_pwd" placeholder="Re-enter password..." required>
                <button type="submit" name="reset-password" required>Reset password</button>

            </form>


            <?php

        }
    }
?>