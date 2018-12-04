<?php 

  ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start();

if(isset($_SESSION['userEmail']))
  {	
  		phpinfo();
		include_once __DIR__.'/app/sonata/FixedBitNotation.php';
		include_once __DIR__.'/sonata/GoogleAuthenticator.php';
  	 $username = $_SESSION['userName'];
		/*$g = new \Google\Authenticator\GoogleAuthenticator();*/
		$g = new GoogleAuthenticator();
		$salt = '7WAO342QFANY6IKBF7L7SWEUU79WL3VMT920VB5NQMW';
		$secret = $username.$salt;
		echo '<img src="'.$g->getURL("", 'http://aaden001.cs518.cs.odu.edu', $secret).'" />';

		$g = new GoogleAuthenticator();
		$salt = '7WAO342QFANY6IKBF7L7SWEUU79WL3VMT920VB5NQMW';
		$secret = $username.$salt;
		$oneCode = $g->getCode($secret);
		echo $oneCode;
		echo '<form class="form-inline" action="" method="post">
		<div class="form-group">
		<label for="inputPassword6">Code Input</label>
		<input type="text" name="inputTest" id="inputPassword" class="form-control" />
		<input type="submit" name="SubmitButton"/>

		</div>
		</form>';


		if( isset($_POST['SubmitButton']) && isset($_POST['inputTest'])){
			$userInput = $_POST['inputTest'];

			$checkResult = $g->checkCode($secret, $userInput);    // 2 = 2*30sec clock tolerance
			if ($checkResult) {
			echo 'OK';
			} else {
			echo 'FAILED';
			}	
		}

		//$check_this_code =$g->getCode($secret);
/*
			
		$ga = new PHPGangsta_GoogleAuthenticator();
		$secret = $ga->createSecret();
		

		$qrCodeUrl = $ga->getQRCodeGoogleUrl('http://192.168.56.152/', $secret);


		echo '<img src="'.$qrCodeUrl.'" /><br><br>';

		echo '<form class="form-inline" action="" method="post">
		<div class="form-group">
		<label for="inputPassword6">Code Input</label>
		<input type="text" name="inputTest" id="inputPassword" class="form-control" />
		<input type="submit" name="SubmitButton"/>

		</div>
		</form>';

		///$oneCode = $ga->getCode($secret);
		echo "Checking Code '$oneCode' and Secret '$secret':\n";
		if( isset($_POST['SubmitButton']) && isset($_POST['inputTest'])){
			$userInput = $_POST['inputTest'];

			$checkResult = $ga->verifyCode($secret, $userInput, 10);    // 2 = 2*30sec clock tolerance
			if ($checkResult) {
			echo 'OK';
			} else {
			echo 'FAILED';
			}	
		}
		*/


		
/*		echo '<img src="'.$g->getQRCodeGoogleUrl('http://aaden001.cs518.cs.odu.edu', $secret).'" />';
			echo '<img src="'.$g->getQRCodeGoogleUrl('http://192.168.56.152/', $secret).'" />';
	echo '<form class="form-inline" action="" method="post">
		<div class="form-group">
		<label for="inputPassword6">Code Input</label>
		<input type="text" name="inputTest" id="inputPassword" class="form-control" />
		<input type="submit" name="SubmitButton"/>

		</div>
		</form>';


		if(isset($_POST['SubmitButton']) && isset($_POST['inputTest']) && isset($_SESSION['userEmail']))
			$_SESSION['code'] = $_POST['inputTest'];
				if(isset($_SESSION['code'])){
					

					$secret = $_SESSION['userEmail'];
					$check_this_code = $_POST['code'];
				if ($g->checkCode($secret, $check_this_code)) {
					echo 'Success!';
				} else {
					echo 'Invalid login';
				}
		}

*/
   }



?>
