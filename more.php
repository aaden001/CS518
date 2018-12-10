<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
	if(isset($_FILES['file'])){
		$target_dir = "POSTFiles/";
		$target_file = $target_dir . basename($_FILES["file"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		
		// Check if file already exists
		if (file_exists($target_file)) {
		echo "Sorry, file already exists.";
		$uploadOk = 0;
		}
		
	if ($_FILES["file"]['error'] == 0 && $uploadOk ==1) {

		if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
				$fileName = $_FILES["file"]["name"];
				$fileName = stripslashes(htmlspecialchars($fileName));
				$userId =$_POST['userId'];
				$roomId = $_POST['roomId'];
				$fileLink = '../POSTFiles/' .$fileName;
				
			if($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif" ) {
				try{
					$img = 'PF';
				include 'dbconnect.php';
				$textArea = "Picture As File";

				$query = $Connection->prepare("INSERT INTO ChatBox (RoomID,UserID,TextA,type,Link) VALUES(:tempRoom,:tempUser,:tempText,:tempType,:tempLink)");
				$query->execute(array('tempRoom' => $userId, 'tempUser' => $roomId, 'tempText' => $textArea, 'tempType' => $img ,'tempLink' => $fileLink));


				}catch(Exception $e){
					$e->getMessage();
				}
			}else{
				try{
					$doc = 'DF';
				include 'dbconnect.php';
				$textArea = "Document As File";
				$query = $Connection->prepare("INSERT INTO ChatBox (RoomID,UserID,TextA,type,Link) VALUES(:tempRoom,:tempUser,:tempText,:tempType,:tempLink)");
				$query->execute(array('tempRoom' => $userId, 'tempUser' => $roomId, 'tempText' => $textArea, 'tempType' => $doc ,'tempLink' => $fileLink));


				}catch(Exception $e){
					$e->getMessage();
				}
			}
		echo "success";
		} else {
		echo "Sorry, there was an error uploading your file.";
		}	
	}elseif($_FILES["file"]['error'] == 1){
		echo "The uploaded file exceeds the upload_max_filesize directive in php.ini. which is 2mb";
	}elseif($_FILES["file"]['error'] == 2){
		echo "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.";
	}elseif($_FILES["file"]['error'] == 3){
		echo "The uploaded file was only partially uploaded.";
	}elseif($_FILES["file"]['error'] == 4){
		echo "echo no file was uploaded";
	}elseif($_FILES["file"]['error'] == 6){
		echo "Missing a temporary folder.";
	}elseif($_FILES["file"]['error'] == 7){
		echo "nothing";
	}elseif($_FILES["file"]['error'] == 8){
		echo "nothing";
	}
}elseif (isset($_POST['pictureLink'])) {
	# code...
	$pictureLink =  $_POST['pictureLink'];
	$pictureLink = stripslashes(htmlspecialchars($pictureLink));
	$userId = $_POST['userId'];
	$roomId = $_POST['roomId'];
	$textArea = 'Picture as a Link';
	$PL = 'PO';
	try{
		include 'dbconnect.php';
		$query =  $Connection->prepare("INSERT INTO ChatBox(RoomID,UserID,TextA,type,Link) VALUES(:tempRoom,:tempUser,:tempText,:tempType,:tempLink)");
		$query->execute(array('tempRoom' => $userId, 'tempUser' => $roomId, 'tempText' => $textArea, 'tempType' => $PL ,'tempLink' => $pictureLink));
		if ($query){
			echo 'success';
		}else{
			echo 'error to post Picture as Link';
		}
		$Connection = null;
	}catch(Exception $e){
		$e->getMessage();
	}


}elseif(isset($_POST['code'])){
		$codeText =  $_POST['code'];
	$codeText = htmlspecialchars($codeText);	
	$userId = $_POST['userId'];
	$roomId = $_POST['roomId'];
	$textArea = 'Code';
	$PL = 'CO';
	try{
		include 'dbconnect.php';
		$query =  $Connection->prepare("INSERT INTO ChatBox(RoomID,UserID,TextA,type,Code) VALUES(:tempRoom,:tempUser,:tempText,:tempType,:tempCode)");
		$query->execute(array('tempRoom' => $userId, 'tempUser' => $roomId, 'tempText' => $textArea, 'tempType' => $PL ,'tempCode' => $codeText));
		if ($query){
			echo 'success';
		}else{
			echo 'error to post Code';
		}
		$Connection = null;
	}catch(Exception $e){
		$e->getMessage();
	}
}else{
	echo 'nothing to do';
}	

?>
