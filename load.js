$(document).ready(
	function(){
		var currentRoom = getParameterByName('currentRoomID');
		var page = getParameterByName('page');
	
/*Credit https://stackoverflow.com/questions/901115/how-can-i-get-query-string-values-in-javascript*/
		function getParameterByName(name) {
			var match = RegExp('[?&]' + name + '=([^&]*)').exec(window.location.search);
			return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
		}



		$("#container").load('/display.php?currentRoomID=' +currentRoom +'&page=' + page);

	}
);