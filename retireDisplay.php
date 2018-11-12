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
    $Start = 0;
    $Stop = 5;
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

?>
    <div id="display" class="pre-scrollable">
<?php       
        $postID = 0;
        if(!empty($result)){
?>

<?php   foreach ($result as $row): ?>
    
        <?php $postID++; ?>
        <div id="<?php echo $postID; ?>" class="posts-wrapper">
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