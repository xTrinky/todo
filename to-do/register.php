<?php
include_once ("config.php");


$checkusername = FALSE;
$checkemail = FALSE;


$username = filter_input(INPUT_POST, 'username');
$password = filter_input(INPUT_POST, 'password');
$vorname = filter_input(INPUT_POST, 'vorname');
$nachname = filter_input(INPUT_POST, 'nachname');
$mail = filter_input(INPUT_POST, 'mail');


//add data to db
if (!empty($username) && !empty($password) && !empty($vorname) && !empty($nachname) && !empty($mail)) {


  $username = mysqli_real_escape_string($conn, $username);
  $mail = mysqli_real_escape_string($conn, $mail);


  //Select from db
  $check = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
  $check2 = mysqli_query($conn, "SELECT * FROM users WHERE mail = '$mail'");


  //Check if they exists
  if (mysqli_num_rows($check)) {
    $checkusername = "<h5 style=\"color:#de8009\">This Username already exists</h5>";
  }
  elseif (mysqli_num_rows($check2)) {
    $checkemail = "<h5 style=\"color:#de8009\">This Email address already exists</h5>";
  }
  else {


    //HASH encrypt PASSWORD
    $password = password_hash($password, PASSWORD_DEFAULT);


    //add data to db query
    $insert = 'INSERT INTO `to_do`.`users` (`username`,`password`, `vorname`, `nachname`, `mail`)
      VALUES ("'.mysqli_real_escape_string($conn, $username).'",
      "'.mysqli_real_escape_string($conn, $password).'",
      "'.mysqli_real_escape_string($conn, $vorname).'",
      "'.mysqli_real_escape_string($conn, $nachname).'",
      "'.mysqli_real_escape_string($conn, $mail).'")';


    //check if they are inserted
    if (!mysqli_query($conn,$insert)){
      echo "Error adding values: " . mysqli_error($conn);
    } else {
      header('Location: login.php');
    }
    exit;
  }
}


mysqli_close($conn);
?>

<html>
  <head>
    <meta charset="utf-8">
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" />
    <link rel="stylesheet" href="https://formden.com/static/cdn/font-awesome/4.4.0/css/font-awesome.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="inc/sweetalert.min.js"></script>
    <link rel="stylesheet" href="inc/style.css">
    <link rel="stylesheet" href="inc/sweetalert.css">
    <link rel="stylesheet" href="inc/animate.css">
</head>
<body>
<div class="container">
  <div class="row animated bounceInLeft" >

    <div class="col-sm-6 col-md-4 col-md-offset-4 ">

          <div class="account-wall">
            <h3 class="text-center login-title">Register</h3>
              <img class="profile-img-reg" src="img/photo.jpg.png" alt="">
            
            <form action="register.php" method="POST"  class="form-signin">
                  <input type="text" name="vorname" id="vorname" class="form-control" placeholder="Vorname*" required>
                  <input type="text" name="nachname" id="nachname"  class="form-control" placeholder="Nachname*" required><br>
                  <input type="email" name="mail" id="emailAddress"  class="form-control" placeholder="Email*" required>
              
               <?php echo $checkemail; ?> <br>
              
                  <input type="username" name="username" id="username" class="form-control" placeholder="Username*" required autofocus>
              
               <?php echo $checkusername; ?>
              
                  <input type="password" name="password" id="password"  class="form-control" placeholder="Password*" required>
                    <button type="submit"class="btn btn-lg btn-success btn-block" name="submit">Sign up </button>
            </form>
            
            <a href="login.php" class="text-center new-account">Back to Log in</a>
          </div>
      
    </div>

  </div>
</div>
</body>
<!-- Include Date Range Picker -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

<script>
	$(document).ready(function(){
		var date_input=$('input[name="date"]'); //our date input has the name "date"
		var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
		date_input.datepicker({
			format: 'mm/dd/yyyy',
			container: container,
			todayHighlight: true,
			autoclose: true,
		});
	});
</script>
</html>
