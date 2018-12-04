<?php 

  ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start();

if(isset($_SESSION['userEmail']))
  {
		
		include_once 'src/FixedBitNotation.php';
		include_once 'src/GoogleAuthenticator.php';
		$g = new \Google\Authenticator\GoogleAuthenticator();
		$salt = '7WAO342QFANY6IKBF7L7SWEUU79WL3VMT920VB5NQMW';
		$secret = $_SESSION['userEmail'].$salt;
		echo '<img src="'.$g->getURL($_SESSION['userEmail'], 'http://aaden001.cs518.cs.odu.edu', $secret).'" />';
		echo '<form class="form-inline" action="" method="post">
		<div class="form-group">
		<label for="inputPassword6">Code Input</label>
		<input type="text" name="inputTest" id="inputPassword" class="form-control" />
		<input type="submit" name="SubmitButton"/>

		</div>
		</form>';
   }

if(isset($_POST['SubmitButton']) && isset($_POST['inputTest']) && sset($_SESSION['userEmail']))
	$_SESSION['code'] = $_POST['inputTest'];
   if(isset($_SESSION['code'])){
			$g = new \Google\Authenticator\GoogleAuthenticator();
			$salt = '7WAO342QFANY6IKBF7L7SWEUU79WL3VMT920VB5NQMW';
			$secret = $_SESSION['userEmail'].$salt;
			$check_this_code = $_POST['code'];
			if ($g->checkCode($secret, $check_this_code)) {
			echo 'Success!';
			} else {
			echo 'Invalid login';
			}
   }

?>
