<?php
     ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();


     require 'dbconnect.php';
   $tempId = $_SESSION['userId'];
   $query = $Connection->prepare("SELECT RoomsID, Name FROM UserGroups INNER JOIN Rooms ON UserGroups.RoomsID = Rooms.ID WHERE UserID=:tempUserId");
    $query->execute(array('tempUserId'=> $tempId));




    function rating_All_count (){
        include 'dbconnect.php';
        $Count = $Connection->query("SELECT count(*) FROM ChatLikes")->fetchColumn(); 
        $Connection = null;
        return $Count;
    }
    function rating_per_individual($temp){
         include 'dbconnect.php';
        $querryCount = $Connection->prepare("SELECT * FROM ChatLikes WHERE userRateID=:temp");
        $querryCount->execute(array('temp' => $temp));
        $Count = $querryCount->rowCount();
        $Connection = null;

        return $Count;
    }
    function total_Post(){
        include 'dbconnect.php';
        $Count  = $Connection->query("SELECT count(*) FROM ChatBox")->fetchColumn();
     
        $Connection = null;
        return $Count;
    }
    function total_Post_per_person($temp){
         include 'dbconnect.php';
        $querryCount = $Connection->prepare("SELECT * FROM ChatBox WHERE UserID=:temp");
        $querryCount->execute(array('temp' => $temp));
        $Count = $querryCount->rowCount();
        $Connection = null;

        return $Count;
    }
    function total_Comment(){
        include 'dbconnect.php';
        $Count  = $Connection->query("SELECT count(*) FROM Comment")->fetchColumn();
        $Connection = null;
        return $Count;
    }
    function total_Comment_per_person($temp){
        include 'dbconnect.php';
        $querryCount = $Connection->prepare("SELECT * FROM Comment WHERE userID=:temp");
        $querryCount->execute(array('temp' => $temp));
        $Count = $querryCount->rowCount();
        $Connection = null;

        return $Count;
    }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" type="text/css" href="stylewelcome.css">
    <title>Collapsible sidebar using Bootstrap 4</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="style2.css">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js" integrity="sha384-kW+oWsYx3YpxvjtZjFXqazFpA7UP/MbiY4jvs+RWZo2+N94PFZ36T6TFkc9O3qoB" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
<style>
    
 @media (min-width: 1200px) {
    .container-fluid{
        max-width: 50%;
    }
}

</style>
</head>

<body>

    <div class="wrapper">
        <!-- Sidebar  -->
       <nav id="sidebar">
            <div class="sidebar-header">
                <h3 style="color: orange; font-family: tahoma; font-size: 25px;">Welcome 
                    <span>
                        <?php echo $_SESSION['userName'];?>
                            
                        </span>
                </h3>
        
            </div>
        
            <!-- <ul class="list-unstyled components"> -->
            <ul class="list-unstyled CTAs" >
              <p></p>
              <li>
              <a href="Welcome.php">Home</a>
              </li>
              <li>
              <a href="notify.php">Notification</a>
              </li>
              
                <?php 

              if($_SESSION['userId'] == 6){
                include_once 'roomClass.php';
                $newRoomObj = new Room();
                echo '<li>
                <a href="#roomSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Rooms</a>
                <ul class="collapse list-unstyled" id="roomSubmenu">';
                 require 'dbconnect.php';
                $tempId = $_SESSION['userId'];
                ///used the Admin(user) Id to display the users list of rooms to them
                $query = $Connection->prepare("SELECT RoomsID, Name FROM Administrators INNER JOIN Rooms ON Administrators.RoomsID = Rooms.ID WHERE UserID=:tempUserId");
                $query->execute(array('tempUserId'=> $tempId));
                while( $result = $query->fetch()){


                echo '<li class="row"><a href="GlobalRoom.php?currentRoomID=' .$result['RoomsID'] .'&page=1' .'"  class="col-8" style="margin-left: 7%">' .$result['Name'] .'Room'.'</a>';

                  if($newRoomObj->check_room_status($result['RoomsID'] ) ==1){
                 echo '<i id="' .$result['RoomsID'] .'" class="fa fa-archive col-3" style="font-size:36px; color:black;"></i></li>'; 
                  }else{
                  echo '<i id="' .$result['RoomsID'] .'" class="fa fa-archive col-3" style="font-size:36px; color:red;"></i></li>'; 
                  }
              
                }
                $Connection = null;
                echo '</ul></li>';

            }else{  
                echo '<li>
                <a href="#roomSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Rooms</a>
                <ul class="collapse list-unstyled" id="roomSubmenu">
                <a href="#JoinSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Joined Room</a>
                <ul class="collapse list-unstyled" id="JoinSubmenu">';
               
                require 'dbconnect.php';
                $tempId = $_SESSION['userId'];
                ///used the user Id to display the users list of rooms to them
                $query = $Connection->prepare("SELECT RoomsID, Name FROM UserGroups INNER JOIN Rooms ON UserGroups.RoomsID = Rooms.ID WHERE UserID=:tempUserId");
                $query->execute(array('tempUserId'=> $tempId));
                while( $result = $query->fetch()){
                echo '<li><a href="GlobalRoom.php?currentRoomID=' .$result['RoomsID'] .'&page=1'.'">' .$result['Name'] .'Room'.'</a></li>'; 
                }
                $Connection = null;

                echo '</ul><a href="#ownSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Own Room</a>
                <ul class="collapse list-unstyled" id="ownSubmenu">';
                require 'dbconnect.php';
                $tempId = $_SESSION['userId'];
                ///used the Admin(user) Id to display the users list of rooms to them
                $query = $Connection->prepare("SELECT RoomsID, Name FROM Administrators INNER JOIN Rooms ON Administrators.RoomsID = Rooms.ID WHERE UserID=:tempUserId");
                $query->execute(array('tempUserId'=> $tempId));
                while( $result = $query->fetch()){
          echo '<li class="row"><a href="GlobalRoom.php?currentRoomID=' .$result['RoomsID'] .'&page=1' .'"  class="col-8" style="margin-left: 7%">' .$result['Name'] .'Room'.'</a></li>'; 
/*<i id="' .$result['RoomsID'] .'" class="fa fa-archive col-3" style="font-size:36px; color:black;"></i>*/

                }               
                $Connection = null;

               echo '</ul></ul></li>';
              }
              echo '<li> <a href="upload.php">Upload Picture</a></li>';
                             
              ?>
              <li>
              <a href='profile.php?userId=<?php echo $_SESSION['userId'] ?>'>View My Profile</a>
              </li>
        </nav>

        <!-- Page Content  -->
        <div id="content">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                        <span>More Information</span>
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>
                </div>
            </nav>
            
            <div class="line"></div>
          
                <!-- User Profile Goes in here -->
                <div class="container">
                <?php
                    if(isset($_GET['userId'])){
                        require 'dbconnect.php';
                        $querryProfilPic= $Connection->prepare("SELECT * FROM ProfilePictures WHERE userID=:tempId");
                        $querryProfilPic->execute(array('tempId' => $_GET['userId']));
                        $PicLinkResult = $querryProfilPic->fetch();
                        $namequerry = $Connection->prepare("SELECT userFullName, userEmail,userHandle FROM Users WHERE userId=:tempUserId");
                        $namequerry->execute(array('tempUserId' => $_GET['userId']));
                        $resultquerry = $namequerry->fetch();
                        $roomIdquerry = $Connection->prepare("SELECT RoomsID FROM UserGroups WHERE UserID=:tempID");
                        $roomIdquerry->execute(array('tempID' => $_GET['userId']));
                        $resultRoomId = $roomIdquerry->fetchAll();
                       
                       
                        echo '<div class="container-fluid"><div class="wrapper">';
                        if($querryProfilPic->rowCount() == 1){
                            echo'<img  src="' .$PicLinkResult['pictureLink'] .'" class="vtop"alt="Smiley face" style="float:left" width="60%" height="42%">';
                        }else{
                            echo '<img  src="../ProfilePics/james.jpeg" alt="Smiley face" style="float:left" width="60%" height="42%">';
                        }


                        echo '</div>';

                        

                        echo '<div class="constainer" style="margin-top: 0%"><h4>' .$resultquerry['userFullName'] .'</h4>';
                        echo '<h4>' .$resultquerry['userEmail'] .'</h4></div>';    


                        echo '<div class="container row" style="margin-top: 0%;margin-left: 0px;margin-right: 0px;"><div class="row"  style="margin-top: 4%;">
                                <div class="col-6">';
                        echo '<span><h3>room</h3></span>';
                       foreach ($resultRoomId as $value) {
                            # code...
                            $querryRoomName = $Connection->prepare("SELECT Name FROM Rooms WHERE ID=:tempId");
                            $querryRoomName->execute(array('tempId' =>$value['RoomsID']));
                            $resultRoomName = $querryRoomName->fetch();
                            echo $resultRoomName['Name'] .'<br>';
                        }

                        echo '</div>
                                <div class="col-6" style="left: 50%;">';
                        
                        $totalPost = total_Post();
                        $totalComment = total_Comment();
                        $totalRating = rating_All_count();

                        $postIndividual = total_Post_per_person($_GET['userId']);
                        $commentIndividual = total_Comment_per_person($_GET['userId']);
                        $ratingIndividual = rating_per_individual($_GET['userId']);
                        $sumTotal = $totalPost + $totalComment + $totalRating;

                        $totalIndividaul = $postIndividual + $commentIndividual + $ratingIndividual;
                        $ratingScore = round((($totalIndividaul / $sumTotal)*5),2);
                        echo 'sumtotal: ' .$sumTotal .'<br> individual count: ' .$totalIndividaul .'<br>rating: ' .$ratingScore .'<br>';
                        $minStar = 1;
                        $maxStar = 5;
                        echo '<div class="row" style="margin-left: 0%;"><div class="col-13"><span>';
                        /*Credit to this youtube video  https://www.youtube.com/watch?v=jlI2ctgEHBk*/
                            for($i=$minStar; $i<=$maxStar; $i++) { // simple for loop

                            if ($ratingScore >= 1) { // it going to check if your average rating is greater than equal to 1 or not if it is then it give you full star.
                            echo '<img src="Star (Full).png" width="20"/>';
                            $ratingScore--; //after getting full star it decremnt the value and contiune the loop.
                            }else {
                            if ($ratingScore >= 0.5) { // if user select 3.5 rating, so in above condition at last it remain 0.5 rating will get left. then it came to this condition and give you the half star.
                            echo '<img src="Star (Half Full).png" width="20"/>';
                            $ratingScore -= 0.5;
                            }else { // at last but not the least when value gets zero then it return empty star.
                            echo '<img src="Star (Empty).png" width="20"/>';
                            }
                            }
                            }
                        echo '</span></div></div>';
                        echo '</div>
                            </div>
                            </div> </div>';
                        
                    }

 


                ?>
                   



                </div>
           

        </div>
    </div>

    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
    <script type="text/javascript" src="toggle.js"></script>

</body>

</html> 