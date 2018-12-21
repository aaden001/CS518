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

               		$user_info2 = $this->client->account_verifyCredentials(array('include_entities' => 'true', 'skip_status' => 'true', 'include_email' => 'true'));
					$userFullname = $user_info2->name;
					$userHandle = '@' .$user_info2->screen_name;
					$userEmail = $user_info2->email;
					$userProfileLink = $user_info2->profile_image_url;
					if(isset($userFullname) && isset($userHandle) && isset($userEmail) && isset($userProfileLink)){
						header('Location:signUp.php?twitFullname=' .$userFullname .'&twitHandle=' .$userHandle .'&twitEmail=' .$userEmail .'&PicLink=' .$userProfileLink );	
					
					}else{
						echo "Error getting one of this information user Full name, user Handle, user Email , user profile Link";
					}
					
					//$userInfo = array('Fullname' => $userFullname, 'Handle' => $userHandle, 'Email' => $userEmail, 'ProfileLink' => $userProfileLink);
					//echo 'user Full name: '.$userFullname .'  userHandle: ' .$userHandle .' <br>userEamil: ' .$userEmail .'ProfileImgLink: ' .$userProfileLink;
					//var_dump($userInfo) ;
					exit;   
					

						return true;  

				}else{
					echo "fail to retrieve details";
				}


				
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