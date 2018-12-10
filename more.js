$(document).ready(function(){

    function document_Upload() {
    $(".input-file").before(
        function() {
            if ( ! $(this).prev().hasClass('input-ghost') ) {
                var element = $("<input id='docUpload' type='file' class='input-ghost' name='docUpload' style='visibility:hidden; height:0' accept='application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf'>");
                element.attr("name",$(this).attr("name"));
                element.change(function(){
                    element.next(element).find('input').val((element.val()).split('\\').pop());
                });
                $(this).find("button.btn-choose").click(function(){
                    element.click();
                });
                $(this).find("button.btn-reset").click(function(){
                    element.val(null);
                    $(this).parents(".input-file").find('input').val('');
                });
                $(this).find('input').css("cursor","pointer");
                $(this).find('input').mousedown(function() {
                    $(this).parents('.input-file').prev().click();
                    return false;
                });
                return element;
            }
        }
    );
}

   function picture_Upload() {
    $(".input-file2").before(
        function() {
            if ( ! $(this).prev().hasClass('input-ghost') ) {
                var element = $("<input  name='imgUpload' id='imgUpload' type='file' name='img' class='input-ghost' style='visibility:hidden; height:0' accept='image/* '>");
                element.attr("name",$(this).attr("name"));
                element.change(function(){
                    element.next(element).find('input').val((element.val()).split('\\').pop());
                });
                $(this).find("button.btn-choose").click(function(){
                    element.click();
                });
                $(this).find("button.btn-reset").click(function(){
                    element.val(null);
                    $("div").remove("#image-holder");
                    $(this).parents(".input-file").find('input').val('');
                });

                $(this).find('input').css("cursor","pointer");
                $(this).find('input').mousedown(function() {
                    $(this).parents('.input-file').prev().click();
                    return false;
                });
                return element;
            }
            /* Picture preview*/
            



        }
    );
}


$(function() {
    document_Upload();
    picture_Upload();

     $("#imgUpload").on('change', function() {
          //Get count of selected files
          var countFiles = $(this)[0].files.length;
          var imgPath = $(this)[0].value;
          var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
          var image_holder = $("#image-holder");
          image_holder.empty();
          if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
            if (typeof(FileReader) != "undefined") {
              //loop for each file selected for uploaded.
              for (var i = 0; i < countFiles; i++) 
              {
                var reader = new FileReader();
                reader.onload = function(e) {
                  $('<img />', {
                    "src": e.target.result,
                    "class": "thumb-image",
                    "height": "20%",
                    "width": "20%"
                  }).appendTo(image_holder);
                }
                image_holder.show();
                reader.readAsDataURL($(this)[0].files[i]);
              }
            } else {
              alert("This browser does not support FileReader.");
            }
          } else {
            alert("Pls select only images");
          }
        });


     $('.doc').on('click',function(){
            event.preventDefault();
            var fileInput = document.getElementById('docUpload');
            var file = fileInput.files[0];
            var formData = new FormData();
            formData.append('file',file);
            formData.append('userId', userID);
            formData.append('roomId',roomID);
        $.ajax({
            url: 'more.php',  
            type: 'POST',
            data: formData,
            success:function(data){
                data = $.trim(data);
               if(data == "success"){

                    $.ajax({
                    url: 'display.php',
                    type: 'post',
                    data: {
                    'currentRoomID': roomID,
                    'page': pageNumber,
                    'userId': userID,
                    },
                    success: function(response){
                  
                    var obj = jQuery.parseJSON(response);
                    var page = $.trim(obj.pagination);
                    var buildpage = $.trim(obj.buildpage);
                    
                    $('modal-1').modal('hide');
                    $('div#display').find('div').remove();
                    $('div#display').find('script').remove();


                    $('div#displayArea').find('div#pagePanel').remove();


                    /*  $('div#displayArea #pagePanel').remove();*/
                    $('div#displayArea').prepend(page);
                   $('div#display').append(buildpage);              
                    }

                    });

               }else{
                    alert(data);
               }
            },
            cache: false,
            contentType: false,
            processData: false
        })
     });


     $('.img').on('click',function(){
            event.preventDefault();
            var fileInput = document.getElementById('imgUpload');
            var file = fileInput.files[0];
            var formData = new FormData();
            formData.append('file',file);
            formData.append('userId', userID);
            formData.append('roomId',roomID);
        $.ajax({
            url: 'more.php',  
            type: 'POST',
            data: formData,
            success:function(data){
               data = $.trim(data);
               if(data == "success"){

                    $.ajax({
                    url: 'display.php',
                    type: 'post',
                    data: {
                    'currentRoomID': roomID,
                    'page': pageNumber,
                    'userId': userID,
                    },
                    success: function(response){
                  
                    var obj = jQuery.parseJSON(response);
                    var page = $.trim(obj.pagination);
                    var buildpage = $.trim(obj.buildpage);
                    
                    $('modal-5').modal('hide');
                    $('div#display').find('div').remove();
                    $('div#display').find('script').remove();


                    $('div#displayArea').find('div#pagePanel').remove();


                    /*  $('div#displayArea #pagePanel').remove();*/
                    $('div#displayArea').prepend(page);
                   $('div#display').append(buildpage);              
                    }

                    });
                     $("div").remove("#image-holder");
               }else{
                    alert(data);
               }
            },
            cache: false,
            contentType: false,
            processData: false
        })
     });
     

     $('#code').on('click', function(){
          event.preventDefault();
          var codeText = $('.postCode').val();
          if(codeText  != ''){
           
            $.ajax({

                url: 'more.php',
                type: 'post',
                data: {
                'code':codeText,
                'roomId': roomID,
                'userId': userID,
                },
               success: function(data){
                data = $.trim(data);
                if(data == 'success'){
                    
                    $.ajax({
                    url: 'display.php',
                    type: 'post',
                    data: {
                    'currentRoomID': roomID,
                    'page': pageNumber,
                    'userId': userID,
                    },
                    success: function(response){
                  
                    var obj = jQuery.parseJSON(response);
                    var page = $.trim(obj.pagination);
                    var buildpage = $.trim(obj.buildpage);
                    
                    $('modal-5').modal('hide');
                    $('div#display').find('div').remove();
                    $('div#display').find('script').remove();


                    $('div#displayArea').find('div#pagePanel').remove();


                    /*  $('div#displayArea #pagePanel').remove();*/
                    $('div#displayArea').prepend(page);
                   $('div#display').append(buildpage);              
                    }

                    });
                $('.postCode').val('');

                }else{
                    alert(data);
                }
               },
               error: function(xhr, ajaxOptions, thrownError){
                    alert(xhr.status);
                    alert(thrownError);
                }
            });


          }else{
            alert("You cant send an empty code");
          }
          
     });

     $('#postL').on('click', function(){
         event.preventDefault();
          var pictureLink = $.trim($('.postLink').val());
          if(pictureLink  != ''){
           

            $.ajax({

                url: 'more.php',
                type: 'post',
                data: {
                'pictureLink': pictureLink,
                'roomId': roomID,
                'userId': userID,
                },
               success: function(data){
                data = $.trim(data);
                if(data == 'success'){
                    
                    $.ajax({
                    url: 'display.php',
                    type: 'post',
                    data: {
                    'currentRoomID': roomID,
                    'page': pageNumber,
                    'userId': userID,
                    },
                    success: function(response){
                  
                    var obj = jQuery.parseJSON(response);
                    var page = $.trim(obj.pagination);
                    var buildpage = $.trim(obj.buildpage);
                    
                    $('modal-5').modal('hide');
                    $('div#display').find('div').remove();
                    $('div#display').find('script').remove();


                    $('div#displayArea').find('div#pagePanel').remove();


                    /*  $('div#displayArea #pagePanel').remove();*/
                    $('div#displayArea').prepend(page);
                   $('div#display').append(buildpage);              
                    }

                    });
                     $('.postLink').val('');
                }else{
                    alert(data);
                }
               },
               error: function(xhr, ajaxOptions, thrownError){
                    alert(xhr.status);
                    alert(thrownError);
                }
            });


          }else{
            alert("You cant send an empty code");
          }
     });



});

});

