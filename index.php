<?php  include('services.php');
  session_start();
/*parse_str(implode('&', array_slice($argv, 1)), $_GET);*/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 


  //credit: https://gist.github.com/asika32764/b204ff4799d577fd4eef
  function gitLogin()
  {
    define('OAUTH2_CLIENT_ID', '541b6e510ce03d138842');
    define('OAUTH2_CLIENT_SECRET', '728df75aa33cd44226a78ee687be6df49f69a722');

    $authorizeURL = 'https://github.com/login/oauth/authorize';
    $tokenURL     = 'https://github.com/login/oauth/access_token';
    $apiURLBase   = 'https://api.github.com/';


    // Start the login process by sending the user to Github's authorization page
    if(get('action') == 'login') 
    {
        // Generate a random hash and store in the session for security
        $_SESSION['state'] = hash('sha256', microtime(TRUE) . rand() . $_SERVER['REMOTE_ADDR']);
        unset($_SESSION['access_token']);
        $params = array(
            'client_id' => OAUTH2_CLIENT_ID,
            'redirect_uri' => 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'],
            'scope' => 'user:email',
            'state' => $_SESSION['state']
        );
        // Redirect the user to Github's authorization page
        header('Location: ' . $authorizeURL . '?' . http_build_query($params));
        die();
    }

    // When Github redirects the user back here, there will be a "code" and "state" parameter in the query string
    if (get('code')) 
    {
        // Verify the state matches our stored state
        if (!get('state') || $_SESSION['state'] != get('state')) {
            header('Location: ' . $_SERVER['PHP_SELF']);
            die();
        }
        // Exchange the auth code for a token
      $token = apiRequest($tokenURL, array(
      'client_id' => OAUTH2_CLIENT_ID,
      'client_secret' => OAUTH2_CLIENT_SECRET,
      'redirect_uri' => 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'],
      'state' => $_SESSION['state'],
      'code' => get('code')
      ));
      
     /* 	echo json_encode($token);*/
      $_SESSION['access_token'] = $token->access_token;
      header('Location: ' . $_SERVER['PHP_SELF']);
    }
    /*function twitterLogin(){
      require 'twitteroauth/autoload.php';
      use Abraham\TwitterOAuth\TwitterOAuth;

      define('CONSUMER_KEY', 'dKbBvndNgJFQQYVSAzmQfKFcS');
      define('CONSUMER_SECRET', 'owZENw37LnjdRsdtiMyIDYscXsJ1Dq36RoYDaVLJlqbrmAk8MW');
      define('OAUTH_CALLBACK', 'http://niyiserverhost.com');

    }*/


	if (session('access_token')) 
	  {
	      echo '<h3>Git: Logged In</h3>';

				
		$user= apiRequest('https://api.github.com/user');
		
 		$useremail = apiRequest('https://api.github.com/user/emails');
		$userEmail = $useremail[0]->email  ;
	 	$userName  = $user->name;
    $userName = trim($userName);
		$userHandle  = '@' .$user->login;
		$_SESSION['avatarLink'] = $user->avatar_url;

    ///Process GitHub sign up here

		header("Location:signUp.php?username=".$userName ."&useremail=".$userEmail ."&userhandle=" .$userHandle);  
	     
	  } 
	  else 
	  {
	      echo '<h3>Git: Not logged in</h3>';
	      echo '<p><a href="?action=login">Log In with Github</a></p>';
	  }


  }

  function twitterLogin(){
 
      require_once __DIR__ .'/init.php';
   
      $auth = new TwitterAuth($client);  ///this is taken to TwitterAuth.php
      $auth->getAuthUrl();

     if($auth->signedIn()){
      
         echo "<p>You are signed In</p>";
        }else{
        echo '<p><a href="' .$auth->getAuthUrl() .'">Sigin with Twitter</a></p>';
     } 

  }
  function apiRequest($url, $post = FALSE, $headers = array())
  {
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      if ($post)
          curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
      $headers[] = 'Accept: application/json';
      $headers[] = 'User-Agent: PHP Api Call';
      if (session('access_token'))
          $headers[] = 'Authorization: Bearer ' . session('access_token');
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      $response = curl_exec($ch);
      return json_decode($response);
  }

  function get($key, $default = NULL)
  {
      return array_key_exists($key, $_GET) ? $_GET[$key] : $default;
  }

  function session($key, $default = NULL)
  {
      return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : $default;
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta name="google-signin-client_id" content="895157867960-3ek9vivk30r9gefbj0uqdbq5lqpa8juo.apps.googleusercontent.com">
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
    <form class="form-horizontal" action="Login.php" method="post">
      <div class="form-group">
        <label for="exampleDropdownFormEmail1">Email address</label>
        <input type="email" class="form-control" id="Email" name="email" placeholder="email@example.com">
      </div>
      <div class="form-group">
        <label for="exampleDropdownFormPassword1">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
      </div>
<!--       <div class="form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Remember me</label>
      </div>

 -->  
    <div class="g-recaptcha" data-sitekey="6LcuJHkUAAAAAK_9o842eo2aN0aYvTmbYdavnxvB" ></div>
    <button type="submit" class="btn btn-primary">Sign in</button>
      <?php
            echo "<br>";
              gitLogin();
              
          echo ' <div class="g-signin2" data-onsuccess="onSignIn" data-theme="dark"></div>';
          twitterLogin();
        ?>
      <b><a href="index2.php">Click to Sign Up</a></b>
      
        

      <?php 
          if(isset($_GET['error'])){
        
      ?>
      <br> 
          <div style="background-color: red">
            <h2 stlye="color: #FFFFFF;">Incorrect sign-in details </h2>
            </div>
      <?php 
          }
       ?>
    </form>
  </div>


   <script src="https://apis.google.com/js/platform.js?onload=onLoad" async defer></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script src='https://www.google.com/recaptcha/api.js'></script>
  <script type="text/javascript" src="checkrecaptcha.js"></script>
  <script type="text/javascript" src="jquery.js"></script>
     <script>
      function onSignIn(googleUser) {
        // Useful data for your client-side scripts:
         var profile = googleUser.getBasicProfile();
         
        var username = profile.getName();
        var imgLink  = profile.getImageUrl();
        var email = profile.getEmail();
        var handle = profile.getGivenName();
        var id_token = googleUser.getAuthResponse().id_token;
       
        
        if(username != "" && imgLink !="" && email !="" && handle != "" && id_token != "")
          $.ajax({
            url: 'signUp.php',
            type: 'post',
            data: {
            'googleUserName':username,
            'imgLinkGoogle': imgLink,
            'emailGoogle': email,
            'handleGoogle': handle,
            'id_token': id_token,
            },success: function(data){
              data = $.trim(data);
           alert(data);
          console.log(data);
              if (data != ''){
                if(data == 9){
                  alert("Cant sign you up. There is a match in with a user handle in our database.");

                }else{
                  window.location.replace("Welcome.php")  
                } 
                
              }
          }
          });
        // The ID token you need to pass to your backend:
     /* var profile = googleUser.getBasicProfile();
        console.log("ID: " + profile.getId()); // Don't send this directly to your server!
        console.log('Full Name: ' + profile.getName());
        console.log('Given Name: ' + profile.getGivenName());
        console.log('Family Name: ' + profile.getFamilyName());
        console.log("Image URL: " + profile.getImageUrl());
        console.log("Email: " + profile.getEmail());*/
        
      };

    
    </script>
</body>
</html>
