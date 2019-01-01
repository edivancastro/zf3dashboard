var screenWidth, screenHeight, dialogWidth;

screenWidth = window.screen.width;
screenHeight = window.screen.height;

var minWidth ='600px'

if ( screenWidth < minWidth ) {
   dialogWidth = screenWidth * .95;
   dialogHeight = screenHeight * .80;
} else {
   dialogWidth = minWidth;
   dialogHeight = screenHeight * .60;
} 

var urlDialog = function(url,titulo, width=600){
	
	$('body').append('<div id="dialog"></div>');
	$('#dialog').load(url).dialog({
		width: "auto",
		position:{my:"center top", at:"center top+100", of: window},
		title: titulo,
		width: dialogWidth,
		maxHeight: dialogHeight,
		modal: true,
		resizable: true,
		close: function(){
			$('#dialog').remove();
		},
	});
}


