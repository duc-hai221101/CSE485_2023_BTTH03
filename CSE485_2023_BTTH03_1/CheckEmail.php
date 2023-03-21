<?php
require_once './src/DB_con.php';
$code_hash=$_GET['code'];
$sqlCheck="SELECT * FROM users WHERE user_hash='$code_hash'";
$resultCheck=mysqli_query($conn,$sqlCheck);
if(mysqli_num_rows($resultCheck)<0){
        header("Location:register.php?error='Mã xác nhận sai'");
}
else{


$sql="UPDATE users SET active=1 WHERE user_hash='$code_hash'";
$result=mysqli_query($conn,$sql);
header("Location:register.php?error='Xác nhận thành công");
}