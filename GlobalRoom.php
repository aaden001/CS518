<?php
     ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();
    $_SESSION['currentRoomID'] = $_GET['currentRoomID'];
   
    echo $_SESSION['userId'];
   if(!isset($_SESSION['userId']))
    {
        header("Location:index.php");
    }else

    $tempUserID = $_SESSION['userId'];
      include 'rating.php'; 
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" type="text/css" href="stylewelcome.css">
    <title>Get Together </title>

<!--   Bootstrap CSS CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
<!-- Our Custom CSS-->
   <link rel="stylesheet" href="style2.css">
<!--    Scrollbar Custom CSS-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
<!--    Font Awesome JS-->
   <!-- <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js" integrity="sha384-kW+oWsYx3YpxvjtZjFXqazFpA7UP/MbiY4jvs+RWZo2+N94PFZ36T6TFkc9O3qoB" crossorigin="anonymous"></script>
   <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script> -->
<!-- Thumps Up thump down -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   
<style>
  @media (min-width: 1200px) {
    .post{
        max-width: 100%;
    }

}

#timestamp{
  color: red;
  background-color:blue;
}
.posts-wrapper {
  width: 70%;
  margin: 20px auto;
  border: 1px solid #eee;
}
.comment-wrapper {
  width: 50%;
  margin: 20px auto;
  border: 1px solid #eee;
}
.comment-div {
  width: 100%;
  margin: 20px auto;
  border: 1px solid #eee;
}

.post {
  width: 90%;
  margin: 20px auto;
  padding: 10px 5px 0px 5px;

}
.post-info {
  margin: 10px auto 0px;
  padding: 5px;
}
.fa {
  font-size: 1.2em;
}
.fa-thumbs-down, .fa-thumbs-o-down {
  transform:rotateY(180deg);
}
.logged_in_user {
  padding: 10px 30px 0px;
}
i {
  color: blue;
}
    </style>
</head> 
<body>

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
                    <li>
                        <a href="#roomSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Rooms</a>
                        <ul class="collapse list-unstyled" id="roomSubmenu">
                        <a href="#JoinSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Joined Room</a>
                        <ul class="collapse list-unstyled" id="JoinSubmenu">
                            <?php 
                        require 'dbconnect.php';
                        $tempId = $_SESSION['userId'];
                        ///used the user Id to display the users list of rooms to them
                        $query = $Connection->prepare("SELECT RoomsID, Name FROM UserGroups INNER JOIN Rooms ON UserGroups.RoomsID = Rooms.ID WHERE UserID=:tempUserId");
                        $query->execute(array('tempUserId'=> $tempId));
                while( $result = $query->fetch()){
                    echo '<li><a href="GlobalRoom.php?currentRoomID=' .$result['RoomsID'] .'">' .$result['Name'] .'Room'.'</a></li>'; 
                }
                    $Connection = null;

                             ?>
                        </ul>

                        <a href="#ownSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Own Room</a>
                        <ul class="collapse list-unstyled" id="ownSubmenu">
                        <?php 
                        require 'dbconnect.php';
                        $tempId = $_SESSION['userId'];
                        ///used the Admin(user) Id to display the users list of rooms to them
                        $query = $Connection->prepare("SELECT RoomsID, Name FROM Administrators INNER JOIN Rooms ON Administrators.RoomsID = Rooms.ID WHERE UserID=:tempUserId");
                        $query->execute(array('tempUserId'=> $tempId));
                while( $result = $query->fetch()){
                    echo '<li><a href="GlobalRoom.php?currentRoomID=' .$result['RoomsID'] .'">' .$result['Name'] .'Room'.'</a></li>'; 
                }
                    $Connection = null;

                             ?>
                        </ul>
                        </ul>
                    </li>
                    <li>
                        <a href="profile.php">View My Profile</a>
                    </li>
                    <?php 
                        require 'dbconnect.php';
                        $tempId = $_SESSION['userId'];
                        $query = $Connection->prepare("SELECT * FROM Administrators WHERE UserID=:tempUserId AND RoomsID=:tempRoomID");
                        $query->execute(array('tempUserId'=> $tempId,'tempRoomID' => $_SESSION['currentRoomID']));
                        $result = $query->fetch();
                if($query->rowCount() > 0){
                    echo '<li><a href="sendInvitation.php?currentRoomID=' .$result['RoomsID'] .'">' .'Invite' .'</a></li>'; 
                }
                    $Connection = null;

                             ?>
            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content" style="position: fixed;">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                        <span>More Information</span>
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>

                   <!--  <div class="collapse navbar-collapse" id="navbarSupportedContent">
                       <ul class="nav navbar-nav ml-auto">
                           <li class="nav-item active">
                               <button type="button" class="btn btn-primary">Create New Group</button>
                           </li>
                       </ul>
                   </div> -->
                </div>
            </nav>
            
            <div class="line"></div>
            <div id="container">
            <?php 
             
                include 'dbconnect.php';
                include 'ChatClass.php';
              
                $dispUser = new Chat;
                $tempUserCRID = $_SESSION['currentRoomID'];

                $querrystatement = "SELECT Name FROM Rooms WHERE ID=:roomID";
                $roomNamequerry=$Connection->prepare($querrystatement);
                $roomNamequerry->execute(array('roomID' => $tempUserCRID));
                
                $roomNameData = $roomNamequerry->fetch();
                $roomName = $roomNameData['Name'];

                if($dispUser->matchCheck($_SESSION['userId'],$tempUserCRID) == true)
                {
                    //Querry for text,user handle and time stamp
                    $currentRoomChatID = $_SESSION['currentRoomID'];
                    $SQL ="SELECT ID, created_at, TextA, ChatBox.UserID, userHandle FROM ChatBox 
                    			INNER JOIN Users ON ChatBox.UserID = Users.userID WHERE RoomID=:roomIdentify ORDER BY ID DESC";
                    $query = $Connection->prepare($SQL);
                    $query->execute(array('roomIdentify' => $currentRoomChatID));
                    $result = $query->fetchAll();
                    ///Querry for the picture Link
                   
                    $sqlComment ="SELECT C1.`Id`as Id,`ChatBox`.`ID` as ID,
                    `ChatBox`.`created_at`,
                    `ChatBox`.`TextA`,
                    `ChatBox`.`UserID`,
                    t2.`userHandle` as t2userHandle,
                    C1.`userId` as userId,
                    C1.`TextArea` as TextArea,
                    C1.`Ccreated_at` as Ccreated_at,
                    t3.`userHandle` as t3userHandle
                    FROM `ChatBox` 
                    INNER JOIN `Users` AS t2 ON `t2`.`UserID` = `ChatBox`.`userID`
                    INNER JOIN `Comment` AS C1 ON `ChatBox`.`ID` = `C1`.`ChatBoxID` 
                    INNER JOIN `Users` AS t3 ON `t3`.`UserID` = `C1`.`userId` 
                    WHERE `RoomID`=:roomIdentify
                    ORDER BY C1.`Id` DESC";
                    /*$sqlComment = "SELECT TextArea, ChatBoxID, Comment.userId AS userComment, Ccreated_at FROM Comment ORDER BY Id";*/
                    $query = $Connection->prepare($sqlComment);
                    $query->execute(array('roomIdentify' => $currentRoomChatID));
                    $resultComment = $query->fetchAll();
                    $secificCommey = $query->fetchAll();

                    
                    if(!empty($result)){
            ?>
            <div id="display" class="pre-scrollable">
            <?php   foreach ($result as $row): ?>
                
  
                    <div class="posts-wrapper">
                        <div class="container">           
                        <div class="container-fluid post">
                        <div class="row">
                        <div class="col-sm-10" style="background-color:lavender;">
                        <p><?php echo $row['TextA']  ?>
                        </p><div id= "timestamp">
                        <?php echo $row['created_at']?>
                        </div></div>


                        <div class="col-sm-2">
                        <?php 
                            ///Do a comparism with the session id and the chatbox user id to get distinct profile pictureLink
                        $querryProfilPic= $Connection->prepare("SELECT * FROM ProfilePictures WHERE userID=:tempId");
                        $querryProfilPic->execute(array('tempId' => $row['UserID']));
                        $PicLinkResult = $querryProfilPic->fetch();
                            if($PicLinkResult['userId'] ==  $row['UserID']){
                        ?>
                        <img  src="<?php echo $PicLinkResult['pictureLink'] ?>" alt="Smiley face" style="float:right" width="42" height="42"><br><br><br><div>
                        <?php

                            }else{
                        ?>
                             <img  src="../ProfilePics/james.jpeg" alt="Smiley face" style="float:right" width="42" height="42"><br><br><br><div>
                        <?php } ?>
                        
                        <?php echo $row['userHandle']?>
                        </div></div>
                        </div><br>
                        <div class="row">
                        <div class="col" > 
                            <div><?php echo "UserID:" .$row['UserID'] ?></div>
                            <i   
                                <?php if(userLiked($row['ID'],$tempUserID)): ?>
                                class="fa fa-thumbs-up like-btn" style="font-size:36px"
                                <?php else: ?>
                                class="fa fa-thumbs-o-up like-btn" style="font-size:36px"
                                <?php endif ?>
                                data-id="<?php echo $row['ID']?>" data-user="<?php echo $tempUserID ?>">
                            </i>
                            <span class="col likes"><?php echo getusersLikes($row['ID']) ?></span>

                            <i   <?php if(userDisliked($row['ID'],$tempUserID)): ?>
                                class="fa fa-thumbs-down dislike-btn" style="font-size:36px"
                                <?php else: ?>
                                class="fa fa-thumbs-o-down dislike-btn" style="font-size:36px"
                                <?php endif ?>
                                data-id="<?php echo $row['ID']?>" data-user="<?php echo $tempUserID ?>">
                            </i>
                            <span class="col dislikes"><?php echo getusersDislikes($row['ID']) ?></span>
                        </div>
                        <div class="col">
                            <div><?php echo "UserID:" .$row['UserID'] ?></div>
                            <button id="<?php echo $row['ID']?>" type="button" style="float:right"class="btn btn-success view" >Comment</button>
                        </div>
                        </div>
                        <!-- Replies to comment div -->
                      
                      	
                        <div   id="<?php echo 'div'.$row['ID']?>" class="comment-div" style="display: none" >
                            <div class="posts-wrapper">
                                    <div class="container">           
                                        <div class="container-fluid comment">
                    					<?php foreach ($resultComment as $value) 
                    					{
                    					# code...

                    					?>
                                        	<?php  
                                        	if(!empty($resultComment)) 
                      							{			
                      						?>
                                        	<?php if($value['ID'] == $row['ID'] ): ?>
                                            
                                            <div class="posts-wrapper">
                                            <div class="row">
                                                <div class="col-sm-10" style="background-color:lavender;">
                                                    <p><?php echo $value['TextArea'] ?></p>
                                                    <div id= "timestampcomment">
                                                    <?php echo $value['Ccreated_at']?>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                      <!-- this will have the profile pic to te replying user -->
                                                        <?php 
                                                        ///Do a comparism with the session id and the chatbox user id to get distinct profile pictureLink
                                                        $querryProfilPic= $Connection->prepare("SELECT * FROM ProfilePictures WHERE userID=:tempId");
                                                        $querryProfilPic->execute(array('tempId' => $value['userId']));
                                                        $PicLinkResult = $querryProfilPic->fetch();
                                                        if($PicLinkResult['userId'] ==  $value['userId']){ ///compares with user commnent user Id
                                                        ?>
                                                        <img  src="<?php echo $PicLinkResult['pictureLink'] ?>" alt="Smiley face" style="float:right" width="42" height="42"><br><br><br><div>
                                                        <?php

                                                        }else{
                                                        ?>
                                                        <img  src="../ProfilePics/james.jpeg" alt="Smiley face" style="float:right" width="42" height="42"><br><br><br><div>
                                                        <?php } ?>



                                                     <div>
                                                        <!-- The handle of the user replying user goes here -->
                                                       	<?php echo $value['t3userHandle'] ?>
                                                     </div>
                                                </div>
                                                </div>
                                            </div>
                                            </div>
                                        	
                                            <?php endif ?>
                    						<?php }else{
                    						echo "No comment"; 
                    						}  }?>
                    					
                                        </div>
                                    </div>  
                                </div>
                        	
                                <div class="input-group reply">
                                    <textarea id="<?php echo 'texArea'.$row['ID']?>" class="form-control custom-control" rows="1" style="resize:none" placeholder="Write a Comment"></textarea>     
                                    <span id="<?php echo  'send'.$row['ID'] ?>" class="input-group-addon btn btn-primary Comment" data-userId="<?php echo  $_SESSION['userId'] ?>" >Send</span>
                                </div>
                            
                            </div>
                    		
                    </div>
                    </div>
                    </div>
                    <?php endforeach ?>
                    <?php                 
                            
                        }else{
                          echo "Welcome to link, link with other people in the room by chatting <br>";
                        }
                         
                    }else{
                     echo "You are not of the room called " .$roomName;
                    }
                       
                    $Connection= null; 

                    ?>
                
                    </div>   <!-- End of each post-wrapper -->
                    </div>  <!--end of post wrapper -->
                    <div id="container">  
                                <form id="chatArea" style="margin-top: 13%" action="post.php" method="post">
                                <div class="form-group">
                                <label for="messages">YourMessage:</label>
                                <textarea class="form-control" rows="2" id="messages" name="messages" form="chatArea" maxlength="400" placeholder="Write a Post"></textarea>

                                <button  type="submit" class="btn btn-success" style="margin-top: 4px">Send</button>
                                </div>
                                </form>
                    </div>
                </div> <!-- end or pre-scrollable -->
                
            </div>   <!-- End of Container -->
             
         
       
    </div><!-- End ofPage Content  -->

    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
     <script type="text/javascript" src="toggle.js"></script>
    <script type="text/javascript" src="jquery.js"></script>
   
    <script type="text/javascript" src="rating.js"></script>
    <script type="text/javascript" src="comment.js"></script>

</body>

</html> 