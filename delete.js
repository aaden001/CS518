$(document).ready(function(){

  $('.fa-trash').on('click',function(){
  	event.preventDefault();

  	var postId = $(this).attr('id');
  	/*alert(postId);*/
  	
  			$.ajax({
			url : 'delete.php',
			type : 'post',
			data :{
				'postId' : postId,
				'userId' : userID,
			},success: function(data){
				var result = $.trim(data);
				if(result =="success"){
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
						$('div#display').find('div').remove();
						$('div#display').find('script').remove();
						$('div#displayArea').find('div#pagePanel').remove();
						/*	$('div#displayArea #pagePanel').remove();*/
						$('div#displayArea').prepend(page);
						$('div#display').append(buildpage);
						}

						});
				}else{
					alert(result);
				}
			}
		});
  		
		
  });




  $('fa-archive').on('click',function(){
  	var roodId =  $(this).attr('id');

  			$.ajax({
			url : 'delete.php',
			type : 'post',
			data :{
				'postId' : postId,
				'userId' : userID,
			},success: function(data){

			}
  });


});


});