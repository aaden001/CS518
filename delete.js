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
			},
			error: function(xhr, ajaxOptions, thrownError){
					alert(xhr.status);
					alert(thrownError);
				}
		});
  		
		
  });




  $('.fa-archive').on('click',function(){
  	event.preventDefault();
  	var roomId =  $(this).attr('id');

  			$.ajax({
			url : 'delete.php',
			type : 'post',
			data :{
				'roomId' : roomId,
				'userId' : userID,
			},success: function(data){
				var result = $.trim(data);
				if(result =="1"){
					
					$('i#'+roomId).css('color','black');
				}else{
					
					$('i#'+roomId).css('color','red');	
				}
			},
			error: function(xhr, ajaxOptions, thrownError){
			alert(xhr.status);
			alert(thrownError);
			}
  });


});

  $('button#delete').on('click',function(){
  	event.preventDefault();
  	var textArea = $.trim($('textarea#deleteUser').val());

  			$.ajax({
  				url: 'delete.php',
  				type: 'post',
  				data: {
  					'userId' :userID,
  					'emailDel': textArea,
  					'roomIdD': roomID,
  				},success: function(data){
  						alert(data);
  						$('textarea#deleteUser').val('');
  				},
			error: function(xhr, ajaxOptions, thrownError){
			alert(xhr.status);
			alert(thrownError);
			}

  			});

  

  });


});