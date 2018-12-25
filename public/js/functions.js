    
var urlDialog = function(url,titulo, width=600){
	var screenWidth, screenHeight, dialogWidth;

	screenWidth = window.screen.width;
	screenHeight = window.screen.height;

	if ( screenWidth < width ) {
	    dialogWidth = screenWidth * .95;
	    dialogHeight = screenHeight * .95;
	} else {
	    dialogWidth = width;
	    dialogHeight = screenHeight * .80;
	}
	
	$('body').append('<div id="dialog"></div>');
	$('#dialog').load(url).dialog({
		width: "auto",
		position:{my:"center top", at:"center top+100", of: window},
		title: titulo,
		width: dialogWidth,
		maxHeight: dialogHeight,
		modal: true,
		resizable: false,
		fluid: true,
	});
}


