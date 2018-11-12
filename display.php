 <?php 

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
             
    include 'dbconnect.php';
    include 'ChatClass.php';
    include 'rating.php'; 
    $_SESSION['currentRoomID'] = $_GET['currentRoomID'];
    $_SESSION['userId'] = $_GET['userId'];
    $tempUserID = $_SESSION['userId'];
    echo $_SESSION['currentRoomID'];
    $dispUser = new Chat;
    $tempUserCRID = $_SESSION['currentRoomID'];

    $querrystatement = "SELECT Name FROM Rooms WHERE ID=:roomID";
    $roomNamequerry=$Connection->prepare($querrystatement);
    $roomNamequerry->execute(array('roomID' => $tempUserCRID));
    
    $roomNameData = $roomNamequerry->fetch();
    $roomName = $roomNameData['Name'];
    $Start = 0;
    $Stop = 5;
    echo $_SESSION['userId'];
  
    if($dispUser->matchCheck($_SESSION['userId'],$tempUserCRID) == true)
    {
        //Querry for text,user handle and time stamp
        $currentRoomChatID = $_SESSION['currentRoomID'];
        $SQL ="SELECT ID, created_at, TextA, ChatBox.UserID, userHandle FROM ChatBox 
        			INNER JOIN Users ON ChatBox.UserID = Users.userID WHERE RoomID=:roomIdentify ORDER BY ID DESC LIMIT :start ,:stop";
        $query = $Connection->prepare($SQL);
        $query->bindParam(':start', $Start, PDO::PARAM_INT);
        $query->bindParam(':stop', $Stop, PDO::PARAM_INT);
        $query->bindParam(':roomIdentify', $currentRoomChatID, PDO::PARAM_INT);
        $query->execute();
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
        /*$secificCommey = $query->fetchAll();*/
 
        $postID = 0;
        if(!empty($result)){
        ?>     
        <?php   foreach ($result as $row): ?>
        <?php      
        echo '<div class="container">';        
        echo '<div class="container-fluid post"><div class="row"><div class="col-sm-10" style="background-color:lavender;"><p>';
        echo $row['TextA'] ;
        echo'</p><div id= "timestamp">';
        echo $row['created_at'];
        echo '</div></div><div class="col-sm-2">';
        ///Do a comparism with the session id and the chatbox user id to get distinct profile pictureLink
    $querryProfilPic= $Connection->prepare("SELECT * FROM ProfilePictures WHERE userID=:tempId");
    $querryProfilPic->execute(array('tempId' => $row['UserID']));
    $PicLinkResult = $querryProfilPic->fetch();
        if($PicLinkResult['userId'] ==  $row['UserID']){
        echo '<img  src="'.$PicLinkResult['pictureLink'] .'" alt="Smiley face" style="float:right" width="42" height="42">';
        echo '<br><br><br><div>';
        }else{
        echo '<img  src="../ProfilePics/james.jpeg" alt="Smiley face" style="float:right" width="42" height="42"><br><br><br>
        <div>';
        }
        echo $row['userHandle'];
        echo '</div></div></div><br><div class="row"><div class="col"><div>';
        echo "UserID:" .$row['UserID'] ."</div>";
       $stringD = '<i';

    ?> 
    <?php if(userLiked($row['ID'],$tempUserID)): ?>
    <?php  $stringD .='class="fa fa-thumbs-up like-btn" style="font-size:36px"';?>
        <?php else: ?>
    <?php $stringD .='class="fa fa-thumbs-o-up like-btn" style="font-size:36px"';?>
        <?php endif ?>
    <?php 
        $stringD .='data-id="' .$row['ID'] .'" data-user="$tempUserID" >'; 
        $stringD .='</i><span class="col likes">';
        echo $stringD;
       echo getusersLikes($row['ID']);
       echo '</span>';
       $stringL = '<i';
    ?>
    <?php if(userDisliked($row['ID'],$tempUserID)): ?>
    <?php  $stringL .='class="fa fa-thumbs-down dislike-btn" style="font-size:36px"';?>
        <?php else: ?>
    <?php $stringL .='class="fa fa-thumbs-o-down dislike-btn" style="font-size:36px"'; ?>        
        <?php endif ?>
        <?php  $stringL .='data-id="' .$row['ID'] .'" data-user="$tempUserID"'; ?>
    <?php 
        $stringL .='></i><span class="col dislikes">';
        echo $stringL;
        echo getusersDislikes($row['ID']); 
        echo '</span></div><div class="col"><div>';
        echo "UserID:" .$row['UserID'] ;
        echo '</div>';
        echo '<button id="';
        ?>
        <?php echo $row['ID']?>"
    <?php echo 'type="button" style="float:right"class="btn btn-success view" >Comment</button>'; 
        echo "</div></div>";

        /*Replies to comment div */
        echo '<div id="div"'.$row['ID'] .'class="comment-div" style="display: none" ';
        echo '<div class="posts-wrapper"><div class="container"><div class="container-fluid comment">';
        foreach ($resultComment as $value) 
            {
                if(!empty($resultComment)) 
            {

    ?> 
    <?php if($value['ID'] == $row['ID'] ): ?>
    <?php 
        echo '<div class="posts-wrapper"><div class="row"><div class="col-sm-10" style="background-color:lavender;"><p>';
        echo $value['TextArea'];
        echo '</p><div id= "timestampcomment">';
        echo $value['Ccreated_at'];
        echo '</div></div><div class="col-sm-2">';
        /*this will have the profile pic to te replying user*/
    
        ///Do a comparism with the session id and the chatbox user id to get distinct profile pictureLink
        $querryProfilPic= $Connection->prepare("SELECT * FROM ProfilePictures WHERE userID=:tempId");
        $querryProfilPic->execute(array('tempId' => $value['userId']));
        $PicLinkResult = $querryProfilPic->fetch();


        if($PicLinkResult['userId'] ==  $value['userId']){ ///compares with user commnent user Id
        echo '<img  src="'.$PicLinkResult['pictureLink'] .'" alt="Smiley face" style="float:right" width="42" height="42">';
        echo '<br><br><br>';
        echo '<div>';

    }else{

    echo '<img  src="../ProfilePics/james.jpeg" alt="Smiley face" style="float:right" width="42" height="42"><br><br><br><div>';
   

    }
        echo "<div>"; 
        /*<!-- The handle of the user replying user goes here -->*/
        echo $value['t3userHandle'];
        echo '</div></div></div></div></div>';    
    ?>
    <?php endif ?>
    <?php 
        }else{
		echo "No comment"; 
		} 
     }
    ?>
	<?php 
    echo '</div></div></div>';
    echo '<div class="input-group reply">';

    echo '<textarea id="texArea"'.$row['ID'] .'class="form-control custom-control" rows="1" style="resize:none" placeholder="Write a Comment"></textarea>';  
    echo '<span id="send"'.$row['ID'] .'class="input-group-addon btn btn-primary Comment" data-userId="'.$_SESSION['userId'] .'">Send</span>';
    echo '</div></div></div></div></div>';
    ?> 
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
    </div></div>
?>
<script type="text/javascript" src="rating.js"></script>
<script type="text/javascript" src="comment.js"></script>