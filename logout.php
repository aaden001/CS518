<?php 
  ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
  echo "logging you out.... ";
session_unset();
session_destroy();
 unset($_SESSION['access_token']);
  unset($_SESSION['state']);
unset($_SESSION['oauth_token'] );
   unset($_SESSION['oauth_token_secret']); 
    
    

  header("Location:index.php");

?>
