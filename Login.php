<?php 
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	session_start();
  	require_once('UserClass.php');
  	try{
  		
            if(isset($_POST['email']) && isset($_POST['password'])&& isset($_POST['g-recaptcha-response']))
            {
              
		                require_once "recaptchalib.php";
		            $secret = "6LcuJHkUAAAAAGAJCUhJ32FVGgCmFYpbA-m1PrjC";
		            $response = null;
		            $reCaptcha = new ReCaptcha($secret);

					if ($_POST["g-recaptcha-response"]) {
					$response = $reCaptcha->verifyResponse($_SERVER["REMOTE_ADDR"],$_POST["g-recaptcha-response"]);

						if ($response != null && $response->success) {
						$email =  $_POST["email"];
						$password = $_POST["password"];
						$user = new User();
						$user->setUserEmail($email);
						$user->setUserpassword($password);
						$user->getUserEmail();
						$user->getUserPassword();
							if($user->loginUser() == true){
							$_SESSION['userId'] = $user->getUserId();
							$_SESSION['userName'] = $user->getUserFullname();
							$_SESSION['userEmail'] = $user->getUserEmail();
							$_SESSION['userHandle'] = $user->getUserHandle();

							}
						}
					}

            }
		
	}
	catch(Exception $e)
	{
		echo "This Error Occured: " .$e->getMessage();
	}
	
 ?>
