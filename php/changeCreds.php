<?php
session_start();
include("db_connect.php");
$email = $_SESSION['email'];
if(isset($_POST['changepass'])){
    $oldpass = md5($_POST['oldpass']);
    $sqlOldPass = "SELECT password FROM users WHERE email = '$email'";
    $resultOldPass = mysqli_query($con, $sqlOldPass);
    $rowOldPassFromFB = $resultOldPass -> fetch_array(MYSQLI_ASSOC);
    if($oldpass == $rowOldPassFromFB['password']){
        $newpass = md5($_POST['newpass']);
        $sqlChangePass = "UPDATE users SET password = '$newpass' WHERE email = '$email'";
        mysqli_query($con, $sqlChangePass);
        $_SESSION['chngpass'] = "Ο κωδικός σας άλλαξε επιτυχώς";
        header("location: ../profile.php");
    }
}
?>