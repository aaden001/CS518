<?php 
  ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

  echo "logging you out.... ";

if(isset($_SESSION['google'])){
     session_start();
    session_unset();
    session_destroy();
    session_write_close();
    setcookie(session_name(),'',0,'/');
    session_regenerate_id(true);
 unset($_SESSION['access_token']);
  unset($_SESSION['state']);
unset($_SESSION['oauth_token'] );
   unset($_SESSION['oauth_token_secret']); 
  unset($_SESSION['google']);

    if (isset($_SERVER['HTTP_COOKIE'])) {
    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
    foreach($cookies as $cookie) {
        $parts = explode('=', $cookie);
        $name = trim($parts[0]);
        setcookie($name, '', time()-1000);
        setcookie($name, '', time()-1000, '/');
    }
}

 header("Location:https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=http://aaden001.cs518.cs.odu.edu/index.php");
}else{
     session_start();
    session_unset();
    session_destroy();
    session_write_close();
    setcookie(session_name(),'',0,'/');
    session_regenerate_id(true);
 unset($_SESSION['access_token']);
  unset($_SESSION['state']);
unset($_SESSION['oauth_token'] );
   unset($_SESSION['oauth_token_secret']); 
unset($_SESSION['google']);

    if (isset($_SERVER['HTTP_COOKIE'])) {
    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
    foreach($cookies as $cookie) {
        $parts = explode('=', $cookie);
        $name = trim($parts[0]);
        setcookie($name, '', time()-1000);
        setcookie($name, '', time()-1000, '/');
    }
}

   header("Location:index.php");
}

    

 

?>
