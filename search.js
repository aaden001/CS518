$(document).ready( function(){

	function load_data(querytext)
	{
		$.ajax({
				url : 'fetchSearch.php',
				type : 'post',
				data :{
					'searchText': querytext,
				},
				success: function(response){
					response = $.trim(response);
					$('div#resultSearch').html(response);
					/*if($('div#resultSearch').length){
					$('div#resultSearch').remove();	
					$('div#resultSearch').html(response);
					}else{
						
					}*/
					
				},
				error: function(xhr, ajaxOptions, thrownError){
					alert(xhr.status);
					alert(thrownError);
				}
			});
	}
	
	$('#search').keyup(function(){
		event.preventDefault();
		var text = $.trim($(this).val());
		if(text != ''){
			load_data(text);
		}else{
			
		}
		
	});
});