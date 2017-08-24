<?php
    session_start();
    include_once("config.php");

    $error = FALSE;

    $username= filter_input(INPUT_POST,'username');
    $password= filter_input(INPUT_POST,'password');

    //logout message
    if ( isset($_GET['logout']) && $_GET['logout'] == 1 )
      {
     echo "<h2 style=\"color:#de8009\">You have been loged out</h2>";
    }


    if (isset($_POST['username']) && isset($_POST['password'])){
    $_SESSION['login_user'] = $username;
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    //HASH decrypt PASSWORD
    $pquery = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    $row_cnt = mysqli_num_rows($pquery);
    $rowpass = mysqli_fetch_array($pquery,MYSQLI_ASSOC);
    $hash_pwd = $rowpass['password'];
    $hash = password_verify($password, $hash_pwd);

    if (0 == $row_cnt || false === $hash) {
      $error = "<h4 style=\"color:#de8009\">Username oder Passwort falsch!</h4>";
    } else {
      header("location: index.php?login=ok");
    }
    mysqli_close($conn);
    }
?>
 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title>Login</title>
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
   </head>
   <body>
     <div class="container animated bounceInLeft">
       <div class="row">
         <div class="col-sm-6 col-md-4 col-md-offset-4">
               <div class="account-wall">
                 <h3 class="text-center login-title">Login</h3>
                 <img class="profile-img" src="img/full-user.png" alt="">
                 <?php echo $error; ?>
                 <form action="login.php" method="POST"  class="form-signin">
                 <input type="username" name="username" id="username" class="form-control" placeholder="Username" required autofocus>
                 <input type="password" name="password" id="password"  class="form-control" placeholder="Password" required>
                 <button type="submit"class="btn btn-lg btn-primary btn-block" name="submit" >Sign in</button>
                 </form>
                 <a href="register.php" class="text-center new-account">Create an account </a>
               </div>
         </div>
       </div>
     </div>
   </body>
 </html>
