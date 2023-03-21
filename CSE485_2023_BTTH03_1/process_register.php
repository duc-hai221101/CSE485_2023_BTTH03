<?php
require_once './src/DB_con.php';
if(isset($_POST['submit']))
{   
    $user_email=$_POST["email"];
    $user_pass=$_POST["password"];
    $code_hash = md5(uniqid(rand(), true));
    $pass_hash = password_hash($user_pass, PASSWORD_DEFAULT);
    $sqlCheck="SELECT * FROM users WHERE user_email='$user_email'";
    $resultCheck=mysqli_query($conn,$sqlCheck);
    if(mysqli_num_rows($resultCheck)>0){
        header("Location:register.php?error='Email đã tồn tại'");
    }
    else{
    $sql="INSERT INTO users(user_email, user_pass ,user_hash,pass_hash) VALUES ('$user_email','$user_pass','$code_hash','$pass_hash')";
    $result=mysqli_query($conn,$sql);
    if($result)
    {
        require 'vendor/autoload.php';
        require 'Utils/MyEmailServer.php';
        require 'Utils/EmailSender.php';
        $emailServer = new MyEmailServer();
        $emailSender = new EmailSender($emailServer);
        $emailSender->send($user_email, "Activation", "http://localhost/cse485_2023_btth03_1/CheckEmail.php?code=".$code_hash);
    }
    else
    {
        echo "Đăng kí thất bại";
    }
    }

}