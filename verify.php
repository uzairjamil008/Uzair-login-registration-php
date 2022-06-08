<?php
require('config.php');
if (isset($_GET['email']) && isset($_GET['vcode'])) {
    $query="SELECT * FROM sign_up WHERE `email`='$_GET[email]' AND `vcode`='$_GET[vcode]'";
    $result=mysqli_query($cnn, $query);
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $result_fetch=mysqli_fetch_assoc($result);
            if ($result_fetch['active'] == 0) {
                $update="UPDATE `sign_up` SET `active`='1' WHERE `email`='$result_fetch[email]'";
                if (mysqli_query($cnn, $update)) {
                    echo"Email Verification Successfull";
                } else {
                    echo "Query is not run";
                }
            } else {
                echo "Email Already Verified";
            }
        }
    } else {
        echo"Cannot Run Query";
    }
}
?>