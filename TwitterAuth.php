<?php
	//require 'sample.php';  
	class TwitterAuth{
		protected $client;
		protected $clientCallback = 'http://niyiserverhost.com/callback.php';
		public function __construct(\Codebird\Codebird $temp)
		{
			$this->client = $temp;
			//var_dump($this->client);
		}
		public function getAuthUrl()
		{
			# code...
			$this->requestTokens();
			$this->verifyTokens();
		
				
			
			//var_dump($this->client->oauth_authenticate());
			return $this->client->oauth_authenticate();
		}
		public function signedIn()
		{
			# code...
			 return isset($_SESSION['user_id']);
		}
		public function signIn()
		{
			# code...
			if($this->hasCallback()){

				$this->verifyTokens();

				$reply = $this->client->oauth_accessToken(array('oauth_verifier' => $_GET['oauth_verifier']));

				
				if($reply->httpstatus == 200){

					$this->storeTokens($reply->oauth_token,$reply->oauth_token_secret);
					$this->verifyTokens();
					$_SESSION['user_id'] =  $reply->user_id;
               		$_SESSION['user_name'] =  $reply->screen_name;
               		$params = array('screen_name' => $_SESSION['user_name']);

					$user_info = $this->client->users_show($params);

					$user_info2 = $this->client->account_verifyCredentials();
					/*echo json_decode($user_info);
					echo "<br><br>";
					echo json_encode($user_info);
					echo "<br><br>";*/
					var_dump($user_info2);   
					exit;   


    
					/*
					$_SESSION['user_id']=  $reply->user_id;
               		$_SESSION['user_name']=  $reply->screen_name;
               		$this->verifyTokens();
               		$params = array('screen_name' => $_SESSION['user_name']);
               		$user_info = $this->client->users_show($params);
                //$user_info = $this->client->account_verifyCredentials($params);
                	var_dump($user_info);   
                	die();
                	exit;   */

                	return true;  

				}

/*				$this->verifyTokens();
				var_dump($reply);
$this->verifyTokens();
				$params = array('screen_name' => $reply->screen_name);
$this->verifyTokens();
				$user_info = $this->client->account_verifyCredentials($params);

                
				echo "<br><br>";

				var_dump($user_info);*/
				
				
		/*		$this->storeTokens($reply->oauth_token,$reply->oauth_token_secret);
				$this->verifyTokens();

				$params = array('screen_name' => $_SESSION['user_name']);*/

				

				
			}
			return false;
		}
		protected function hasCallback()
		{
			# code...
			return isset($_GET['oauth_verifier']);
		}
		protected function requestTokens()
		{
			# code...
			$reply = $this->client->oauth_requestToken(array('oauth_callback' => $this->clientCallback));
			
			//var_dump($reply);
			//echo 'Oauth token: ' .$reply->oauth_token;
			//echo '<br><br> Oauth token secret:' .$reply->oauth_token_secret;
			$this->storeTokens($reply->oauth_token,$reply->oauth_token_secret);
		}
		//var_dump($reply);

		protected function storeTokens($token,$tokenSecret)
		{
			# code...
			$_SESSION['oauth_token'] = $token;
			$_SESSION['oauth_token_secret'] = $tokenSecret;

		}
		protected function verifyTokens()
		{
			# code...
			$this->client->setToken($_SESSION['oauth_token'],$_SESSION['oauth_token_secret']);
		}
	}

?>