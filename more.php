<?php
	
	if(isset($_FILES)){
		$build = '<pre>';
		$build .= $_FILES;
		$build .= '</pre>';
		print_r($build);
	}else{
		echo "nothing";
	}
?>
