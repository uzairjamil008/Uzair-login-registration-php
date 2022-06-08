<?php
require('config.php');
session_start();
$emailErr="";
$passwordErr="";
$email="";
$password="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  //to show the error message in name field
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    }
  }
  //to show error message in password field 
  if (empty($_POST["password"])) {
    $passwordErr = "Password is required";
  } else{
    $password = test_input($_POST["password"]);
  }
  if (empty($_POST["email"])
|| !filter_var($email, FILTER_VALIDATE_EMAIL)
|| empty($_POST["password"])
) { 
  echo"<div class='alert alert-danger alert-dismissible fade show' role='alert'>
      <strong>Danger!</strong> Invalid Entry
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
}
else {
   $email=$_POST["email"];
   //line 8 is written for show the email of user jis email sy wo login hoga on welcome page
   $_SESSION['email']=$email;
   $password=$_POST["password"];
   $sql="SELECT * FROM `sign_up` where email='$email'";
   $result=mysqli_query($cnn,$sql);
   //line 13 is written for line 20
   $result_fetch=mysqli_fetch_assoc($result);
   $num=mysqli_num_rows($result);
   if ($num == 1) {
     //line 18 is written for email verification
     if ($result_fetch['active'] == 1) {
       //line 20 is written for verify password from database
     if (password_verify($password, $result_fetch['password'])) {
      header("location: welcome.php");
     } else {
      echo"<div class='alert alert-danger alert-dismissible fade show' role='alert'>
      <strong>Danger!</strong> Invalid Password
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
     }
     } else {
      echo"<div class='alert alert-danger alert-dismissible fade show' role='alert'>
      <strong>Danger!</strong> Email Not Verified
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
     }    
   }
}
}
//this function is make for form validation
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
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

    <title>Login</title>
    <style>
    .error {color: #FF0000;}
    </style>
  </head>
  <body>
    <div class="container">
     <h1 class="text-center">Login To Our Website</h1>
     <form action="login.php" method="post">
  <div class="mb-3 col-md-5" >
    <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" value="<?php echo $email; ?>">
    <span class="error"><?php echo $emailErr;?></span>
  </div>
  <div class="mb-3 col-md-5">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" id="password" name="password">
    <span class="error"><?php echo $passwordErr;?></span>
    <br>
    <h5><a href="forgetpassword.php">Forget Password</a></h5>
  </div>
  <button type="submit" class="btn btn-primary">Login</button>
  <br><br>
  <h5>Don't Have an Account <a href="Signup.php">SignUp</a></h5>
</form>
 </div>

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