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
              <li>
              <a href='help.php'>Help</a>
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
                
                    <?php echo "<pre>Welcome to Get Together

<h4>For Users:</h4>

Send a post as a text:
    Starting at the Home page(Welcome.php), click on Rooms from the sidebar of the page.
    You will see a drop down of rooms you can chat on. Click the room of your chosen. 
    Click on the Write a Post a begin to type, once you are done click sendto post your text.
Send a post as a document File:
    Starting at the Home page(Welcome.php), click on Rooms from the sidebar of the page.
    You will see a drop down of rooms you can chat on. Click the room of your chosen.
    Click on the button More, you would see a dialog box that says “Post a Document File Content Here” .
    Choose your selected document and hit Submit to post the document for download and view in the post area.

Send a post as Picture  using a Link:
    Starting at the Home page(Welcome.php), click on Rooms from the sidebar of the page.
    You will see a drop down of rooms you can chat on. Click the room of your chosen.
    Click on the button More, you would see a dialog box.
    Above it, you  would see three button name document, picture code.Click on the picture,
     Click on Link then paste the link to a picture online and hit Post.
Send a post as Picture from your computer
    Starting at the Home page(Welcome.php), click on Rooms from the sidebar of the page.
    You will see a drop down of rooms you can chat on. Click the room of your chosen.
    Click on the button More, you would see a dialog box.
    Above it, you  would see three buttons name document, picture code.
    click on the picture, Click on FileImage then chose the picture  from your computer and hit Submit.

Send a post in a Code Format:
    Starting at the Home page(Welcome.php), click on Rooms from the sidebar of the page.
    You will see a drop down of rooms you can chat on. Click the room of your chosen.
    Click on the button More, you would see a dialog box.
    Above it, you  would see three button name document, picture code.
    Click on Code paste the Code format you want to embed in your post and hit post.

<h3>For Administrator:</h3>
Delete a Post From a Room:
    Click On the name of the room from the sidebar, In the room You would see a trash Icon click on it to delete the post from the database.
Remove A user From a Room:
    Click On the name of the room from the sidebar, In the room, on the right bottom area you would see a text area that accept user email address to be deleted.
    You can also see all users in the room.
Add a user to a Room:
    Administrator has the right to invite anybody to any to anyroom. The administrator must be in the room to which he/she wants to add the user.
    Click on the invite link at the sidebar and enter the user email address to add user.
Archive a Room:
    Click on the any room,you must make sure you are in the GlobalRoom.php to be able to affect the archive and unarchive button. Red mean archived, Black mean unarchived.


<h3>For Both Users and Administrator:</h3>

To Sign Up:
    From the sign in are there is a blue text that say “Click to sign Up”. 
    Enter you full name , email address, handle, and a match password to confirm registration the the website.
    If an email or/and an handle is taken please use another of credentials to register. 
To Sign In:
    Sign In with you email address and password. If your haven't register for out 2 Factor Authentication you’d be prompted to do so.
    Once done you will have to input the code from Google Authenticator app to confirm your login.
    You can also sign in using your github account
Contact the administrator if you misplaced your phone and you  are no able to access your account using the google authenticator
@**aaden001@odu.edu**

To View Notifications:
    From the sidebar Click on Notifications, Here you would see all the notification sent by other room member for you to join/refuse to chat with.
To View other user Profile:
    From the Home page(Welcome.php), you would see Search on the sidebar, click on it to go to the search page.
    Begin type a random letter to see who appears in the search.
    Click on the name you wish to view their profile and you would be directed to the person profile page
To View you profile:
    From the sidebar Click on View my Profile to see your profile.
To Upload a Picture:
    From the side bar click on Upload Picture to go to the upload picture page. Chose an image file to upload and click upload.
View All Public Rooms:
    From the Home page (Welcome.php) you will automatically see the list of public rooms displayed in  content area.
Creating a New Room:
    Only from the Homepage(Welcome.php), At the top part of the page, click Create New Group.You have the option to make your group public or private.
Inviting a user to a room:
    Click on the Room you Own, you would see the Invite Link on the side bar. Click on it and enter a user email address  you want to send an invite to.

</pre>"; ?>
 



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