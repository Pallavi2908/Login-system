<?php     
     require 'C:\xampp\htdocs\Login system\vendor\autoload.php';
     require 'connection.php';
//  first is to make sure user entered the page in a valid way
    if (isset($_POST["reset-password"]))
    {
        $selector=$_POST["selector"];
        $validator=$_POST["validator"];
        $password=$_POST["pwd"];
        $passwordrepeat=$_POST["repeat_pwd"];

        if( $password != $passwordrepeat){
            echo "Passwords do not match\n";
            echo "Redirecting... <a href='create-new-password.php'> Update password </a>";
            exit();
        }
        $currentdate=date("U");
        //to check if request is still valid
        $sql= "SELECT * FROM `reset` WHERE reset_selector=? AND reset_expires>=?";
        $stmt=mysqli_stmt_init($con); //a prepared statement

        if (!mysqli_stmt_prepare($stmt,$sql))
        {
            die("Timed out");
            exit();
            # code...
        }else{ 
            //using default hashing method
           //binding parameters 
            mysqli_stmt_bind_param($stmt,"ss",$selector,$currentdate);
            mysqli_stmt_execute($stmt); //executing statement
            $result=mysqli_stmt_get_result($stmt); //retrieving result
            if(!$row= mysqli_fetch_assoc($result)){
                echo "Error retrieving user data: " . mysqli_error($con);
                //User not in table
                // echo "Could not grab data from table";
                mysqli_error($con);
                exit();
            }
            else
            {
                //convert token back to binary for usage-> selector token
                $tokenBin=hex2bin($validator);
                $tokenCheck=password_verify($tokenBin,$row["reset_token"]);
                if($tokenCheck===false)
                {//habit to check errors first
                    echo "Something went wrong,try again later";
                    exit();

                }
                elseif($tokenCheck===true)
                {
                    //unlike else, it will execute that alternative expression only if the elseif conditional expression evaluates to true
                    //doing actual work:updating password
                    $tokenEmail=$row['reset_email']; //pinpointing same user in table who wanted to change password
                    $sql= "SELECT * FROM `reset` WHERE reset_email=?";
                    $stmt=mysqli_stmt_init($con); 
                    if (!mysqli_stmt_prepare($stmt,$sql))
                    {
                        echo "error";
                        exit();
                        # code...
                    }else
                    {
                        mysqli_stmt_bind_param($stmt,"s",$tokenEmail);
                        mysqli_stmt_execute($stmt);
                        $result=mysqli_stmt_get_result($stmt); //retrieving result
                           
                        if(!$row= mysqli_fetch_assoc($result))
                        {
                            echo "Error error";
                            exit();
                        }
                        else{ //updating
                            $sql= "UPDATE `main_table` SET password=? WHERE email=?  ";
                            $stmt=mysqli_stmt_init($con); 
                            if (!mysqli_stmt_prepare($stmt,$sql)) {
                                echo "error";
                                exit();
                                # code...
                            }else
                            {
                                //hashing the new password
                                $newHashedpwd=password_hash( $password,PASSWORD_DEFAULT);
                                mysqli_stmt_bind_param($stmt,"ss", $newHashedpwd,$tokenEmail);
                                mysqli_stmt_execute($stmt);
                                $sql="DELETE FROM `reset` WHERE reset_email=?";
                                $stmt=mysqli_stmt_init($con); 
                                if (!mysqli_stmt_prepare($stmt,$sql)) {
                                    echo "error";
                                    exit();
                                    # code...
                                }else
                                {
                                    mysqli_stmt_bind_param($stmt,"s", $tokenEmail);
                                    mysqli_stmt_execute($stmt);
                                    echo "Congrats,you have successfully changed password \n";
                                    header("refresh:5;url=login.html"); 

                                }
                            }
                        }
                    }                            
                }
            }
        }
    }else{
        echo "Invalid  method.Redirecting";
        header("refresh:5;url=login.html");
    }


?>