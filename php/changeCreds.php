<?php
session_start();
include("db_connect.php");
$email = $_SESSION['email'];
if(isset($_POST['changepass'])){
    $oldpass = md5($_POST['oldpass']);
    $sqlOldPass = "SELECT password FROM cc_users WHERE email = '$email'";
    $resultOldPass = mysqli_query($con, $sqlOldPass);
    $rowOldPassFromFB = $resultOldPass -> fetch_array(MYSQLI_ASSOC);
    if($oldpass == $rowOldPassFromFB['password']){
        $newpass = md5($_POST['newpass']);
        $sqlChangePass = "UPDATE cc_users SET password = '$newpass' WHERE email = '$email'";
        mysqli_query($con, $sqlChangePass);
        $msg = "Ο κωδικός σας άλλαξε επιτυχώς";
        $_SESSION['msg'] = "<div class='alert alert-success alert-dismissible fade show'>
                                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                $msg
                            </div>";
        header("location: ../profile.php");
    }
    else if($oldpass != $rowOldPassFromFB['password']){
        $msg = "Ο παλιός κωδικός δεν είναι σωστός";
        $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show'>
                                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                $msg
                            </div>";
        header("location: ../profile.php");
    }
    else{
        $msg = "Κάτι πήγε λάθος. Προσπαθήστε ξανά";
        $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible fade show'>
                                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                $msg
                            </div>";
        header("location: ../profile.php");
    }
}
?>