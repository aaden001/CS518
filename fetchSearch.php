<?php 
  ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
	include 'dbconnect.php';
	$text = $_POST['searchText'];
	$output = '';
	

	if(isset($_POST['searchText'])){
		
		$sql = "SELECT userId, userFullName FROM Users WHERE userFullName LIKE '%" .$_POST['searchText'] ."%'
		OR userHandle LIKE '%" .$text ."%'";
		$resultsql = $Connection->prepare($sql);
	
		
		$resultsql->execute();
	while($row = $resultsql->fetch(PDO::FETCH_ASSOC)){
		$output .='<a href="profile.php?userId='.$row['userId'] .'">'.$row['userFullName'] .'</a><br>';
		
		
		}

			echo $output;
		
	

	}
	

	
	
?>