$(document).ready(function(){
	/*	$(".prettyprinted span").after("<br>");*/
	$( 'textarea#messages' ).on('input',function(){
		 if ($(this).val().length>=200) {
      alert('you have reached a limit of 200');   
      }
      });

		/*	function(){
		var currentRoom = getParameterByName('currentRoomID');
		var page = getParameterByName('page');
	
Credit https://stackoverflow.com/questions/901115/how-can-i-get-query-string-values-in-javascript
		function getParameterByName(name) {
			var match = RegExp('[?&]' + name + '=([^&]*)').exec(window.location.search);
			return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
		}*/
      
       $('button#post-submit').on('click', function(){
       	event.preventDefault();
		var textArea = $.trim($('textarea#messages').val());

/*https://stackoverflow.com/questions/377644/jquery-ajax-error-handling-show-custom-exception-messages*/
		if(textArea != ""){
				$.ajax({

				url: 'post.php',
				type: 'post',
				data: {
				'messages':textArea,
				'roomId': roomID,
				'userId': userID,
				},
				success: function(data){
					data = $.trim(data);
						if(data =='success'){
							/*url = 'display.php';*/
						/*	alert(roomID +" pageNumber ->"+ pageNumber + " userId ->"+ userID)*/
							$.ajax({
								url: 'display.php',
								type: 'post',
								data: {
									'currentRoomID': roomID,
									'page': pageNumber,
									'userId': userID,
								},
								success: function(response){
									console.log(response);
									var obj = jQuery.parseJSON(response);
									var page = $.trim(obj.pagination);
									var buildpage = $.trim(obj.buildpage);
									
								$('div#display').find('div').remove();
								$('div#display').find('script').remove();

							
									$('div#displayArea').find('div#pagePanel').remove();
									
							
								/*	$('div#displayArea #pagePanel').remove();*/
									$('div#displayArea').prepend(page);
							
									$('div#display').append(buildpage);
									$('#messages').val('');


								}

							});

						}
						else{
							alert(data);
						}

				
				},
				error: function(xhr, ajaxOptions, thrownError){
					alert(xhr.status);
					alert(thrownError);
				}



			});    

		}else{
			    alert('You can\'t send an empty post');   
		}
		
		
		
       });
   
	

		
	}
);