<?php
require('config.php');
require('auth.php');
session_start();
$nameErr ="";
$emailErr="";
$phoneErr="";
$passwordErr="";
$username="";
$email="";
$phone="";
$password="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  //to show the error message in name field
  if (empty($_POST["username"])) {
    $nameErr = "Name is required";
  } else {
    $username = test_input($_POST["username"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-z]*$/",$username)) {
      $nameErr = "Only letters and white space allowed";
    }
  }
//to show error message in email field
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    }
  }
//to show error message in phone number field
  if (empty($_POST["phonenumber"])) {
    $phoneErr = "Phone is required";
  } else {
    $phone = test_input($_POST["phonenumber"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[0-9]*$/",$phone)) {
      $phoneErr = "Enter Phone Number Start With 0";
    }
  }
//to show error message in password field 
  if (empty($_POST["password"])) {
    $passwordErr = "Password is required";
  } else{
    $password = test_input($_POST["password"]);
  }
// ------------------------------------------------
if (empty($_POST["username"]) 
|| !preg_match("/^[a-zA-z]*$/",$username)
|| empty($_POST["email"])
|| !filter_var($email, FILTER_VALIDATE_EMAIL)
|| empty($_POST["phonenumber"])
|| !preg_match("/^[0-9]*$/",$phone)
|| empty($_POST["password"])
) { 
  echo"<div class='alert alert-danger alert-dismissible fade show' role='alert'>
      <strong>Danger!</strong> Invalid Entry
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
}
else {
   $username=$_POST["username"];
   $email=$_POST["email"];
   $phone=$_POST["phonenumber"];
   //line used for email verification
   $v_code=bin2hex(random_bytes(16));
   //password hash is used for encrypted password
   $password=password_hash($_POST["password"], PASSWORD_BCRYPT);
   $sql1="SELECT * FROM `sign_up` WHERE email='$email'";
   $res1=mysqli_query($cnn, $sql1);
   if(mysqli_num_rows($res1) > 0) {
     $result_fetch=mysqli_fetch_assoc($res1);
     //this line is written for koi 1 email ko pick kry gaa ager 2 email same aa jay ge to
     if ($result_fetch['active'] == 1) {
      echo"<div class='alert alert-danger alert-dismissible fade show' role='alert'>
      <strong>Danger!</strong> Email Already Exists Please User Another Email
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
     } else {
      echo"<div class='alert alert-danger alert-dismissible fade show' role='alert'>
      <strong>Danger!</strong> Email Pending For Verification!
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
     }  
  } else {
    $sql="INSERT INTO `sign_up`(`username`, `email`, `phone`, `password`, `vcode`, `active`) VALUES ('$username','$email','$phone','$password','$v_code','0')";
    $result=mysqli_query($cnn, $sql);
    //line 42 is used for sending email verification 
    if ($result && sendmail($_POST['email'], $v_code)) {
       echo"<div class='alert alert-success alert-dismissible fade show' role='alert'>
      <strong>Success!</strong> Your Email is Send For Verfication
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
    } else {
      echo"<div class='alert alert-danger alert-dismissible fade show' role='alert'>
      <strong>Danger!</strong> Unable to Process Your Request Please Try Again!
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

    <title>SignUp</title>
    <style>
    .error {color: #FF0000;}
    </style>
  </head>
  <body>
    <div class="container">
     <h1 class="text-center">SignUp To Our Website</h1>
     <form action="signup.php" method="POST">
  <div class="mb-3 col-md-5" >
    <label for="username" class="form-label">Username</label>
    <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp" value="<?php echo $username; ?>">
    <span class="error"><?php echo $nameErr;?></span>
  </div>
  <div class="mb-3 col-md-5" >
    <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" value="<?php echo $email; ?>">
    <span class="error"><?php echo $emailErr;?></span>
  </div>
  <div class="mb-3 col-md-5">
    <label for="phonenumber" class="form-label">Phone Number</label>
    <input type="text" class="form-control" id="phonenumber" name="phonenumber" value="<?php echo $phone; ?>">
    <span class="error"><?php echo $phoneErr;?></span>
  </div>
  <div class="mb-3 col-md-5">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" id="password" name="password" >
    <span class="error"><?php echo $passwordErr;?></span>
  </div>
  <button type="submit" class="btn btn-primary">SignUp</button>
  <br><br>
  <h5>Already Have an Account <a href="login.php">Login</a></h5>
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