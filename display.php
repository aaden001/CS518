<?php
     ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();
    $_SESSION['currentRoomID'] = $_POST['currentRoomID'];
    $_SESSION['currentPage']   = $_POST['page'];
    $_SESSION['userId'] = $_POST['userId'];
   if(!isset($_SESSION['userId']) )
    {
        header("Location:index.php");
    }else
/*    elseif(!isset($_SESSION['authenticationFlag'])){
         header("Location:2Fa.php");
    }
*/




    $tempUserID = $_SESSION['userId'];
   
function likes_dislike_Post($rowID){
  include_once 'rating.php'; 
    $tempUserID = $_SESSION['userId'];
    $FinalLikeBuild ="";
   if(userLiked($rowID,$tempUserID)){
      $likesS =   'class="fa fa-thumbs-up like-btn" style="font-size:36px"';
   }else{
     $likesS =   'class="fa fa-thumbs-o-up like-btn" style="font-size:36px"';
   }

    $likesS .=  ' data-id="' .$rowID .'" data-user="' .$tempUserID .'"';

   if(userDisliked($rowID,$tempUserID)){
      $dislikeS = 'class="fa fa-thumbs-down dislike-btn" style="font-size:36px"';
   }else{
       $dislikeS = 'class="fa fa-thumbs-o-down dislike-btn" style="font-size:36px"';
   }
   
    $dislikeS .=  ' data-id="' .$rowID .'" data-user="' .$tempUserID .'"';
    $FinalLikeBuild .='<div class="col">';
    $FinalLikeBuild .='<i ' .$likesS .'></i>';
    $FinalLikeBuild .='<span class="col likes">';
    $FinalLikeBuild .= getusersLikes($rowID);
    $FinalLikeBuild .='</span>';
    $FinalLikeBuild .='<i ' .$dislikeS .'></i>';

    $FinalLikeBuild .='<span class="col dislikes">';
    $FinalLikeBuild .= getusersDislikes($rowID);
    if ($_SESSION['userId'] ==6){
      $FinalLikeBuild .='</span><i id="'.$rowID .'"class="fa fa-trash" style="font-size:36px; color:red;"></i></div>';
      $FinalLikeBuild .='<div class="col">';
      $FinalLikeBuild .='<button id="'.$rowID .'" type="button" style="float:right"class="btn btn-success view" >Comment</button></div>';

    }else{
    $FinalLikeBuild .='</span></div>';
    $FinalLikeBuild .='<div class="col">';
    $FinalLikeBuild .='<button id="'.$rowID .'" type="button" style="float:right"class="btn btn-success view" >Comment</button></div>';

    }
   
    return $FinalLikeBuild;
}


function roomName_querry(){
    include 'dbconnect.php';

    $tempUserCRID =  $_SESSION['currentRoomID'];
    $querrystatement = "SELECT Name FROM Rooms WHERE ID=:roomID";
    $roomNamequerry=$Connection->prepare($querrystatement);
    $roomNamequerry->execute(array('roomID' => $tempUserCRID));
    
    $roomNameData = $roomNamequerry->fetch();
    $Connection = null;
    $roomName =  "You are not of the room called " .$roomNameData['Name'];
    
    return $roomName;        /// echo "You are not of the room called " .$roomName;
}

function sql_max_chat_per_room(){
    include 'dbconnect.php';
    $currentRoomChatID =  $_POST['currentRoomID'];
    $SQL ="SELECT * FROM ChatBox WHERE RoomID=:roomIdentify";
    $query = $Connection->prepare($SQL);
    $query->execute(array('roomIdentify' => $currentRoomChatID));
    $result = $query->rowCount();
    $Connection = null;
    return $result;
}

function postArea(){
      $postA ='<div id="container">
      <form id="chatArea" style="margin-top: 47%" action="post.php" method="POST">
      <label for="messages">YourMessage:</label>
      <div class="form-group ">        
      <textarea class="form-control" rows="2" id="messages" name="messages" form="chatArea" maxlength="200" placeholder="Write a Post"></textarea>
      <span ><button  type="submit" id= "post-submit" class="btn btn-success" style="margin-top: 4px;">Send</button></span> 
      </div>
      </form>
      </div>';

      return $postA;
}
function commentArea($rowID){
      $commentArea = '<div class="input-group reply"><textarea id="' .'texArea' .$rowID  .'" class="form-control custom-control" rows="1" style="resize:none" placeholder="Write a Comment"></textarea>';   
      $commentArea .='<span id="' .'send'.$rowID .'" class="input-group-addon btn btn-primary Comment" data-userId="'.$_SESSION['userId'] .'" >Send</span></div>';

      return $commentArea;
}
function display_extra($rowId){

  try{
     include 'dbconnect.php';
      
      $querry = $Connection->prepare("SELECT type,Code, Link FROM ChatBox WHERE ID=:tempId");      
      $querry->execute(array('tempId' =>$rowId));
      $result = $querry->fetch();
       $buildString = '';
      
           if($result['type'] == 'PF' || $result['type'] == 'PO' ){
              $buildString .= '<img src="' .$result['Link'] .'" height="20%" width="20%"  class ="col-sm-12" >';
           }elseif($result['type'] == 'DF'){
            $fileName = str_replace('../POSTFiles/', '',$result['Link'] );
            $buildString .= '<a href="'.$result['Link'] .'" class ="col-sm-12" >'.$fileName.'</a>';
           }elseif($result['type'] == 'CO'){
      
             $buildString .='<div class="col-sm-12"><pre class="prettyprint" ><code  class="html php">' .$result['Code'].'</code></pre></div>';
           }
     

       return $buildString;

  }catch (Exception $e){
    $e->getMessage();
  }
   
function sql_fecth_post($maxpostsize){
          //Querry for text,user handle and time stamp
        $currentRoomChatID = $_SESSION['currentRoomID'];
        $currentPage = $_SESSION['currentPage'];
/*        echo 'max post size ->' .$maxpostsize .'<br>';
*/

        $StopCheck = $maxpostsize % 5;
        $Stop = 5;
    
        switch ($StopCheck) {
            case 0:
                
                if ($currentPage == 1){
                $Start = 0;
                }else{
                $Start = ($currentPage - 1)* 5;         
                }
            break;

            case 1:
                
                if ($currentPage == 1){
                $Start = 0;
                $Stop = $StopCheck; ///equals to 1
                }else{

                    
                $Start = (($currentPage -1)*5) - 4;
                $Stop = 5;
                }
            break;

            case 2:
                if ($currentPage == 1){
                $Start = 0;
                $Stop = $StopCheck; ///equals to 1
                }else{

                    
                $Start = (($currentPage -1)*5) - 3;
                $Stop = 5;
                }
            break;

            case 3:if ($currentPage == 1){
                $Start = 0;
                $Stop = $StopCheck; ///equals to 1
                }else{

                    
                $Start = (($currentPage -1)*5) - 2;
                $Stop = 5;
                }
            break;

            case 4:
            if ($currentPage == 1){
                $Start = 0;
                $Stop = $StopCheck; ///equals to 1
                }else{

                    
                $Start = (($currentPage -1)*5) - 1;
                $Stop = 5;
                }

            break;

        }
        include 'dbconnect.php';
        $SQL ="SELECT ID, created_at, TextA, type,Code,Link,ChatBox.UserID, userHandle FROM ChatBox 
                    INNER JOIN Users ON ChatBox.UserID = Users.userID WHERE RoomID=:roomIdentify ORDER BY ID DESC LIMIT :start ,:stop";
        $query = $Connection->prepare($SQL);
        $query->bindParam(':start', $Start, PDO::PARAM_INT);
        $query->bindParam(':stop', $Stop, PDO::PARAM_INT);
        $query->bindParam(':roomIdentify', $currentRoomChatID, PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetchAll();
        $Connection = null;

        return $result;
}



function sql_post_profilePic($UserID){
        include 'dbconnect.php';
        $getuserEmailquerry = $Connection->prepare("SELECT userEmail FROM Users WHERE userId=:tempId");
        $getuserEmailquerry->execute(array('tempId' => $UserID));
        $EmailResult = $getuserEmailquerry->fetch();
        $email = $EmailResult['userEmail'];

        $querryProfilPic= $Connection->prepare("SELECT * FROM ProfilePictures WHERE userID=:tempId");
        $querryProfilPic->execute(array('tempId' => $UserID));

        $PicLinkResult = $querryProfilPic->fetch();
        $root = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
     
        $imgString= $root;

        if($PicLinkResult['userId'] ==  $UserID){
          $imgString .= $PicLinkResult['pictureLink'];
          
        }else{
          $imgString .= '../ProfilePics/james.jpeg';
        }
        $Connection = null;
        $size = 40;

        $imgString = str_replace('..', '',$imgString);
    $occorance = substr_count( $imgString,"http");

    if($occorance == 2){
    $sample = preg_replace("/http:\/\/aaden001.cs518.cs.odu.edu/", "", $imgString);
    $imgString = $sample;
    }
    $default = $imgString;

    $grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;


    $imgString = '<img  src="' .$grav_url .'" alt="Smiley face" style="float:right" width="42" height="42"><br><br><br><div>';
    return $imgString;
}
function sql_fetch_comment(){
      include 'dbconnect.php';

      
      $currentRoomChatID = $_SESSION['currentRoomID'];

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
        $Connection = null;

        return $resultComment;
}


function printPagePanel($maxPageSize)
{
/* $root = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";*/
    $root = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
    $root .= "/GlobalRoom.php?currentRoomID=" .$_SESSION['currentRoomID'];
  $page = 1;
  if( isset($_GET['page']) )
  {
    $root = str_replace('&page='.$_GET['page'], '', $root);
    $page = $_GET['page'];
  }

  $pages = pagination($page, $maxPageSize);
$stringspan ="";
  $stringspan= '<div id="pagePanel" style="text-align:center; font-weight: bold; font-size:16px; padding-bottom: 5px;">';
  for($i = 0; $i<count($pages); $i++)
  {
    if( $pages[$i] == -1  )
    {
      $stringspan .= '<span>...</span>';
     /* echo '<a href="' . $root . '&page='.$maxPageSize. '">&nbsp;'. $pages[$i] .'&nbsp;</a>&nbsp;';*/
    }
    else
    {
      $stringspan .='<a href="' . $root . '&page='. $pages[$i] . '">&nbsp;'. $pages[$i] .'&nbsp;</a>&nbsp;';
    }
  }
 $stringspan .='</div>';  

    return  $stringspan;
}

//credit: https://gist.github.com/kottenator/9d936eb3e4e3c3e02598
function pagination($c, $m) 
{
    $current = $c;
    $last = $m;
    $delta = 2;
    $left = $current - $delta;
    $right = $current + $delta + 1;
    $range = array();
    $rangeWithDots = array();
    $l = -1;

    for ($i = 1; $i <= $last; $i++) 
    {
        if ($i == 1 || $i == $last || $i >= $left && $i < $right) 
        {
            array_push($range, $i);
        }
    }

    for($i = 0; $i<count($range); $i++) 
    {
        if ($l != -1) 
        {
            if ($range[$i] - $l === 2) 
            {
                array_push($rangeWithDots, $l + 1);
            } 
            else if ($range[$i] - $l !== 1) 
            {
              //-1 is used to mark ...
                array_push($rangeWithDots, -1);
            }
        }
        
        array_push($rangeWithDots, $range[$i]);
        $l = $range[$i];
    }

    return $rangeWithDots;
}


    include 'dbconnect.php';
    include 'ChatClass.php';
    $dispUser = new Chat;
    $tempUserCRID = $_SESSION['currentRoomID'];
    $buildString = '';
    $buildPageString = '';
    $maxpage = sql_max_chat_per_room();

    if($dispUser->matchCheck($_SESSION['userId'],$tempUserCRID) == true)
    {

        $postID = 0;
       
        $post = sql_fecth_post($maxpage);

        $remainder = $maxpage % 5;
        switch ($maxpage) {
        case $maxpage < 5:
        $PanelSize = 1;
        break;
        case $maxpage > 4:
              switch ($remainder ) {
                case $remainder < 3:
                $PanelSize =  round(($maxpage / 5)) + 1 ;
                $PanelSize = 1 +$PanelSize;
                  break;
                
                case $remainder > 2:
                  $PanelSize =  round(($maxpage / 5));
                  break;
             
              }

        break;

        }


        if (!empty($post)){

            $buildPageString = printPagePanel($PanelSize);
         /*   $buildString .= '<div id="display" class="pre-scrollable">';*/

            foreach ($post as $row) {
                 $postID++; 
                 $buildString .= ' <div id="' .$postID .'" class="posts-wrapper row">'; 
                 $buildString .=  '<div class="col-sm-10" style="background-color:lavender;">';
                 $buildString .=  "<p> {$row['TextA']}</p>";
                 $buildString .= '<p style="background-color:blue;"' .'>' .$row['created_at'] .'</p></div><div class="col-sm-2">';

                 $buildString .=  sql_post_profilePic($row['UserID']);
                 $buildString .= $row['userHandle'];

                /* $buildString .=  $row['ID'];*/
                 $buildString .= '</div><br></div>';
                 $buildString .= display_extra($row['ID']);

                 $buildString .=  likes_dislike_Post($row['ID']);

                 $comment = sql_fetch_comment();



                 $buildString .= '<div   id="'.'div'.$row['ID'] .'" class="comment-div row" style="display: none" >';
                 $buildString .= '<div " class="comment-wrapper row">';

                  foreach($comment as $value){

                         if($value['ID'] == $row['ID'] ){
                              if (!empty($comment)){
                                $buildString .='<div class="col-sm-10" style="background-color:lavender;">';
                                $buildString .="<p> {$value['TextArea']}</p>";
                                $buildString .='<p style="background-color:blue;"' .'>' .$value['Ccreated_at'] .'</p></div>';
                                $buildString .='<div class="col-sm-2">';
                                $buildString .=  sql_post_profilePic($value['userId']);
                                $buildString .= $value['t3userHandle']; 
                                $buildString .= '</div><br></div>';
                               


                              }

                         }

                  }
                $buildString .= commentArea($row['ID']);
                $buildString .= '</div></div><div></div></div>';
            }
            $buildString .=  "</div>";
         


        }else{

        $buildString .= "Welcome to link, link with other people in the room by chatting <br>";
        /*echo $NochatInRomm;*/
        }
    
 /*   $buildString postArea();*/
    }
/*else{
    $buildString roomName_querry();
    }
*/


   $buildString .=' <script type="text/javascript" src="rating.js"></script>
    <script type="text/javascript" src="comment.js"></script><script type="text/javascript" src="delete.js"></script>';
    $result = array('pagination' => $buildPageString, 'buildpage' =>$buildString);
   

      echo json_encode($result);


?>  
