<?php
   ini_set('display_errors', 1);
   ini_set('display_startup_errors', 1);
   error_reporting(E_ALL);
     session_start();
  	if(!isset($_SESSION['userId']))
    {
        header("Location:index.php");
    }else
    echo $_SESSION['userId'];

$target_dir = "ProfilePics/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 10000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
	include 'dbconnect.php';
	$querryIfposted = $Connection->prepare("SELECT userId FROM ProfilePictures WHERE userId=:tempuserID");
        $querryIfposted->execute(array('tempuserID' => $_SESSION['userId']));
        $resultantquery = $querryIfposted->rowCount();

		if($resultantquery == 0 || !(isset($resultantquery))){

			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			echo "The file ". basename( $_FILES["fileToUpload"]["name"]) . " has been uploaded.";



			$link = "../ProfilePics/" .basename( $_FILES["fileToUpload"]["name"]) ;
			$sqlquerry = $Connection->prepare("INSERT INTO ProfilePictures(userId,pictureLink) VALUES(:tempAdminID,:tempLinkAddress) ON DUPLICATE KEY UPDATE userId=:tempUser");
			$sqlquerry->execute(array('tempAdminID' => $_SESSION['userId'],'tempLinkAddress' =>$link, 'tempUser' => $_SESSION['userId'] ));

			
			header("Refresh:5; url=upload.php",true, 303);
			} else {
			echo "Sorry, there was an error uploading your file.";
			header("Refresh:5; url=upload.php",true, 303);

			}
		}else{
			$sqldelete = $Connection->prepare("DELETE FROM ProfilePictures WHERE userId=:tempUserID");
			$sqldelete->execute(array('tempUserID' => $_SESSION['userId']));

			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			echo "The file ". basename( $_FILES["fileToUpload"]["name"]) . " has been uploaded.";



			$link = "../ProfilePics/" .basename( $_FILES["fileToUpload"]["name"]) ;
			$sqlquerry = $Connection->prepare("INSERT INTO ProfilePictures(userId,pictureLink) VALUES(:tempAdminID,:tempLinkAddress) ON DUPLICATE KEY UPDATE userId=:tempUser");
			$sqlquerry->execute(array('tempAdminID' => $_SESSION['userId'],'tempLinkAddress' =>$link, 'tempUser' => $_SESSION['userId'] ));

			
			header("Refresh:5; url=upload.php",true, 303);
			} else {
			echo "Sorry, there was an error uploading your file.";
			header("Refresh:5; url=upload.php",true, 303);

			}


		}


$Connection = null;

   
}
?>