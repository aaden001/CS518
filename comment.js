$(document).ready(
    function(){
        var previous;
                /*alert(user_id + "  " + post_id);*/

        $('.view').on('click',
        
            function(){
            var comment_id = this.id;  ///this give the chat id 
            var div_id = "#div" +comment_id;
            var sendOnce = "#send"+ comment_id;

            /*$(div_id).hide();    */   

            $(div_id).toggle();

            $(comment_id).on("focus",function () {
             previous = comment_id;

            }).change(function() {
            var value =  comment_id;
                if(previous != value){
                     $(previous).toggle();
                }
            });

            $(sendOnce).on('click',
                function(){
                    var send_id = comment_id;    ///this give the chat id  too
                    var text_id = "#texArea" + comment_id;
                     var div_id = "#div" +comment_id;
                    ///send these three
                    var text = $(text_id).val();
                    var chatBox_id = send_id;
                    
                    var userId = $(this).data(userId);
                    var id = userId["userid"];
                    
                    if(!(text === '' || text ===null) ){

                    $.ajax({
                                url: 'comment.php',
                                type: 'post',
                                data: {
                                    'text' :text,
                                    'chatBox_id': chatBox_id,
                                    'userId': id,
                                },
                                success: function(data){
                                 /*   alert("Comment sent");*/
                                    window.location.reload();
                                     $(div_id).toggle();
                                }



                    });    


                    }else{
                         alert('string can not be empty'); 
                    }

                    
                    

                    }
                
                
                );
                


            }

            

        );




    }





);