<?php 

  ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start();

    function checkUserGoogleAuth(){
    	try{
			include 'dbconnect.php';
			$querry = $Connection->prepare("SELECT ID FROM GoogleAuth WHERE ID=:temp");
			$querry->execute(array('temp' => $_SESSION['userId']));
						if($querry->rowCount() > 0){
			return true;
			}else{
			return false;
			}
			$Connection = null;
    	}catch(Exception $e){
    		$e->getMessage();
    	}
    	
    }

    function AddUserSecret_GoogleAuth($secret){
    	try{

    	include 'dbconnect.php';
    	$querry = $Connection->prepare("INSERT INTO GoogleAuth VALUES(:tempId,:tempSecret)");
    	$querry->execute(array('tempId' => $_SESSION['userId'],'tempSecret' => $secret));
    	$Connection = null;
    	return $querry;

    	}catch(Exception $e){
    		$e->getMessage();
    	}
    	
    }
    function get_userSecret_GoogleAuth(){
    	try{
    		include 'dbconnect.php';
    	$querry = $Connection->prepare("SELECT Secret FROM GoogleAuth WHERE ID=:temp");
    	$querry->execute(array('temp' => $_SESSION['userId']));
    	$resutl = $querry->fetch();

    	return $resutl['Secret'];
    	}catch(Exception $e){
    		$e->getMessage();
    	}
    	
    	
    }
if(isset($_SESSION['userEmail']))
  {	
 
  		include_once 'PHPGangsta/GoogleAuthenticator.php';


			

		if(isset($_SESSION['secret'])){
			$gaSignUP = new PHPGangsta_GoogleAuthenticator();
			$qrCodeUrl = $gaSignUP->getQRCodeGoogleUrl('http://aaden001.cs518.cs.odu.edu/', $_SESSION['secret']);
		}elseif(isset($_GET['result'])){
			
			if($_GET['result'] == 'FAILED'){
				$gaSignUP = new PHPGangsta_GoogleAuthenticator();
				$secret = $gaSignUP->createSecret();
				$qrCodeUrl = $gaSignUP->getQRCodeGoogleUrl('http://aaden001.cs518.cs.odu.edu/', $secret);
			}elseif($_GET['result'] == 'OKUserSecretInAlready'){
				$_SESSION['authenticationFlag'] = 'true';
				header("Location:Welcome.php");
			}		
		
		}
		else{
		$gaSignUP = new PHPGangsta_GoogleAuthenticator();
		$secret = $gaSignUP->createSecret();
		$qrCodeUrl = $gaSignUP->getQRCodeGoogleUrl('http://aaden001.cs518.cs.odu.edu/', $secret);
		
		}
	  		
  		///check if user is already signup else make
  		if(checkUserGoogleAuth()){
  			echo "<h3>This is the user secret for sign-in</h3>";
  			include_once 'PHPGangsta/GoogleAuthenticator.php';
  			$secret = get_userSecret_GoogleAuth();

  			echo "Please enter the code you have from your GoogleAuthenticator application: ";
			$gaSignIn = new PHPGangsta_GoogleAuthenticator();
			echo '<form class="form-inline" action="" method="post">
			<div class="form-group">
			<input type="hidden" name="secret" value="'.$secret .' " />
			<label for="inputPassword6">Code Input</label>
			<input type="number" name="inputTest" id="inputPassword" class="form-control" />
			<input type="submit" name="SubmitButton"/>

			</div>
			</form>';
			echo "Resulting code from secret: " .$gaSignIn->getCode($secret);


  		}else{
  			
  			echo '<img src="'.$qrCodeUrl.'" /><br><br>';

  			echo "<h3>This is the user secret for sigup area</h3>";

			echo '<form class="form-inline" action="" method="post">
			<div class="form-group">
			<input type="hidden" name="secret" value="'.$secret .' " />
			<label for="inputPassword6">Code Input</label>
			<input type="number" name="inputTest" id="inputPassword" class="form-control" />
			<input type="submit" name="SubmitButton"/>

			</div>
			</form>';	

   		}

		if( isset($_POST['SubmitButton']) && isset($_POST['inputTest'])){
			$ga = new PHPGangsta_GoogleAuthenticator();
			$userInput = trim($_POST['inputTest']);
			$secret  = trim($_POST['secret']);

			

			$checkResult = $ga->verifyCode($secret, $userInput); 
			
			$result = '';   

			if ($checkResult) {
				$result .='OK';
				if(checkUserGoogleAuth()){
					$result .="UserSecretInAlready";
				}else{
					if(AddUserSecret_GoogleAuth($secret)){
					$result .="SecretAdded";
					}else{
					$result .="errorOccoured";
					}
					
				}
				
			}else{
			$result .='FAILED';
				///if it fail lets set the previous secret string in a session variable |user can use it with the passcode gotten already
				if(!empty($_POST['secret'])){
				$_SESSION['secret'] =$secret;
				}else{
				}
			}

			header("Location:2Fa.php?result=" .$result);

		}


	}

/*	
Working version
		include_once 'PHPGangsta/GoogleAuthenticator.php';

		if(isset($_SESSION['secret'])){

		}else{
		$ga = new PHPGangsta_GoogleAuthenticator();
		$secret = $ga->createSecret();
		$qrCodeUrl = $ga->getQRCodeGoogleUrl('http://192.168.56.152/', $secret);
		echo '<img src="'.$qrCodeUrl.'" /><br><br>';
		}

			
			$oneCode = $ga->getCode($secret);
			if(checkUserGoogleAuth()){

			}else{
			echo "This is the user New secret for sigup: " .$secret;
			
			echo "Resulting code from secret: " .$ga->getCode($secret);
			echo '<form class="form-inline" action="" method="post">
			<div class="form-group">
			<input type="hidden" name="secret" value="'.$secret .' " />
			<label for="inputPassword6">Code Input</label>
			<input type="number" name="inputTest" id="inputPassword" class="form-control" />
			<input type="submit" name="SubmitButton"/>

			</div>
			</form>';
			

			}

			if( isset($_POST['SubmitButton']) && isset($_POST['inputTest'])){
				$gaS = new PHPGangsta_GoogleAuthenticator();

				$userInput = trim($_POST['inputTest']);
				$secret  = trim($_POST['secret']);
				echo "<br><br>" .$secret;
				echo "<br><br>" .$userInput;
				if(!empty($_POST['secret'])){
				$_SESSION['secret'] = $secret;
				}else{
				}

				$checkResult = $gaS->verifyCode($secret, $userInput, 2);    // 2 = 2*30sec clock tolerance
				if ($checkResult) {
				echo 'OK';
				unset($_SESSION['counter']);
				} else {
				echo 'FAILED';
				echo $_POST['secret'];
				}


			}
*/


?>
