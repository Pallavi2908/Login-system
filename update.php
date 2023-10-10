<?php
    include 'connection.php';
    $user_name=$_GET['name'];
    $sql="SELECT * FROM `main_table` WHERE username= '$user_name'";
    $result=mysqli_query($con,$sql);
    $info=mysqli_fetch_assoc($result);
    $name=$info['username'];
    $company_name=$info['company'];
    $email_id=$info['email'];
?>
<html>
    <title>Edit data</title>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit data</title>
    </head>
    <body>
        <form action="verifyedit.php" method="post">
            <div>
                <input type="text" id="username" name="username" placeholder="Update  username" value="<?php echo $name; ?>">
            </div>
            <div>
                <input type="text" id="company" name="company" value="<?php echo $company_name; ?>">
            </div>
            <div>
                <input type="email" id="email" name="email" value="<?php echo $email_id; ?>">
            </div>
            <div class="holder">
                <input type="submit"  id="btn" name="update" value="Change">
            </div>

        </form>
    </body>
</html>