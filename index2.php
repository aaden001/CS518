<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
 ?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="style.css">
<meta charset="UTF-8">
<title>Get together</title>
</head>
<body id="index">
  <div class="container">
    <div class="logo">
      <img src="logo.png">
    </div>
    <form class="form-horizontal" action="signUp.php" method="post">
    <?php 
        if(isset($_SESSION['access_token'])){

        echo '<div class="form-group">
            <h3><label for="Fullname" style="color: #ff0000">Full name</label></h3>
            <input type="text" class="form-control" id="Fullname" name="Fullname" placeholder="John Hopkins" required="">
        </div>
        <div class="form-group">
            <h3><label for="email"style="color: #ff0000">Email address</label></h3>
            <input type="email" class="form-control" id="Email" name="email" placeholder="email@example.com" required="">
        </div>
        <div class="form-group">
            <h3><label for="handle"style="color: #ff0000">Handle </label></h3>
            <input type="text" class="form-control" id="handle" name="handle" placeholder="@example" required="">
        </div>
        <div class="form-group">
            <h3><label for="password"style="color: #ff0000">Password</label></h3>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required="">
        </div>
        <div class="form-group">
            <h3><label for="Cpassword"style="color: #ff0000">Confirm Password</label></h3>
            <input type="password" class="form-control" id="Cpassword" name="Cpassword" placeholder="Password" required="">
        </div>
        <button type="submit" class="btn btn-primary">SignUp</button>';
        }else
        



    ?>
        <div class="form-group">
            <h3><label for="Fullname" style="color: #ff0000">Full name</label></h3>
            <input type="text" class="form-control" id="Fullname" name="Fullname" placeholder="John Hopkins" required="">
        </div>
        <div class="form-group">
            <h3><label for="email"style="color: #ff0000">Email address</label></h3>
            <input type="email" class="form-control" id="Email" name="email" placeholder="email@example.com" required="">
        </div>
        <div class="form-group">
            <h3><label for="handle"style="color: #ff0000">Handle </label></h3>
            <input type="text" class="form-control" id="handle" name="handle" placeholder="@example" required="">
        </div>
        <div class="form-group">
            <h3><label for="password"style="color: #ff0000">Password</label></h3>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required="">
        </div>
        <div class="form-group">
            <h3><label for="Cpassword"style="color: #ff0000">Confirm Password</label></h3>
            <input type="password" class="form-control" id="Cpassword" name="Cpassword" placeholder="Password" required="">
        </div>
        <button type="submit" class="btn btn-primary">SignUp</button>
        <?php 
          if(isset($_GET['error'])){
                if($_GET['error'] ==7){
         ?>
            <br> 
            <div style="background-color: red">
            <h2 stlye="color: #FFFFFF;">Confirm password and Password doesn't match</h2>
            </div>
        <?php 
            }
            if($_GET['error'] == 8){
          
        ?>
        <br> 
        <div style="background-color: red">
        <h2 stlye="color: #FFFFFF;">A user already has that email address </h2>
        </div>
        <?php 
            }
             if($_GET['error'] == 9){
        
        ?>
        <br> 
        <div style="background-color: red">
        <h2 stlye="color: #FFFFFF;">A user already has that handle address </h2>
        </div>
        <?php 
            }
            if($_GET['error'] == 10){
         
        ?>
        <br> 
        <div style="background-color: red">
        <h2 stlye="color: #FFFFFF;">A user already has that email address and Handle </h2>
        </div>
        <?php 
            }
         }
        ?>
    </form>
  </div>



  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
