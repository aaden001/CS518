<?php 
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	include "UserClass.php";

	if(isset($_POST['Fullname']) && isset($_POST['email']) && isset($_POST['handle']) && isset($_POST['password']) && isset($_POST['Cpassword']))
	{
		$new_User = new User();

		if ($_POST['password']== $_POST['Cpassword'])
		{
			$new_User->setUserEmail($_POST['email']);
			$new_User->setUserHandle($_POST['handle']);
			if($new_User->checkEmailHandle())
			{
				$Name = stripslashes(htmlspecialchars($_POST['Fullname']));
				$Email = stripslashes(htmlspecialchars($_POST['email']));
				$Handle = stripslashes(htmlspecialchars($_POST['handle']));
				$password = stripslashes(htmlspecialchars($_POST['Cpassword']));
				$new_User->setUserEmail($Email);
				$new_User->setUserFullname($Name);
				$new_User->setUserHandle($Handle);
				$new_User->setUserPassword($password);
				$new_User->SignUpUser();
				/*	echo $Name ." <br> ".$Email ." <br> " .$Handle ." <br> " .$password ;*/
			}

			


		}else{
			header("Location:index2.php?error=7");
		}


	}
	if(isset($_GET['error'])){
		$error = $_GET['error'];
	header("Location:index2.php?error=$error");
	}
	/*
	///wont be neccesary 
	Required takes care of these errors so no 
	submission unless all fields are completed
	else{
		if (empty($_POST['Fullname']))
		{
			header("Location:index2.php?error=2");  
		}elseif(empty($_POST['email'])){
		header("Location:index2.php?error=3");
		}elseif(empty($_POST['handle'])){
 		header("Location:index2.php?error=4");
		}elseif(empty($_POST['password'])){
		header("Location:index2.php?error=5");
		}else{
		header("Location:index2.php?error=6");
		}

	}
*/
/*
	error numbers meaning 
	 Required takes case of this errors so no 
	 submittion unless all field are completed
	 1
	 2 Full Name not inputed
	 3 email not inputed 
	 4 handle not inputed 
	 5 password not inputed
	 6 Confirmed password not inputed

     ///Definitely need this for important error handling
	 7 password and Cpassword not matching 
	 8 Email match to database
	 9 Handle mathc to database
	 10 Both Email and Handle to match to database

*/

 ?>