<?php
require('config.php');
if (isset($_GET['email'])) {
    $query="SELECT * FROM sign_up WHERE `email`='$_GET[email]'";
    $result=mysqli_query($cnn, $query);
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            echo "  <div class='container'>
            <h3 class='text-center'>Reset Your Password</h3>
            <form action='resetpassword.php' method='post'>
         <div class='mb-3 col-md-5' >
           <label for='password' class='form-label'>Password</label>
           <input type='password' class='form-control' id='password' name='password' required>
           <br>
           <button type='submit' class='btn btn-primary' name='update-password'>Reset Now</button>
           <input type='hidden' name='email' value='$_GET[email]'>
         </div>
       </form>
        </div>";
        }
    }
}
//this code is written for forget password
if (isset($_POST['update-password'])) {
    $pass=password_hash($_POST["password"], PASSWORD_BCRYPT);
    $update="UPDATE `sign_up` SET `password`='$pass' WHERE `email`='$_POST[email]'";
    if (mysqli_query($cnn, $update)) {
        echo"<div class='alert alert-success alert-dismissible fade show' role='alert'>
      <strong>Success!</strong> Password Updated Successfully
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
    } else {
        echo"<div class='alert alert-danger alert-dismissible fade show' role='alert'>
      <strong>Danger!</strong> Password Update Error
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Reset Password</title>
  </head>
  <body>
    <!-- <div class="container">
     <h3 class="text-center">Reset Your Password</h3>
     <form action="resetpassword.php" method="post">
  <div class="mb-3 col-md-5" >
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" id="password" name="password" required>
    <br>
    <button type="submit" class="btn btn-primary">Reset Now</button>
  </div>
</form>
 </div> -->

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
  </body>
</html>