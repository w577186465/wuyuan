function gotoTop(){
	$('body').fadeOut(400);
	setTimeout(function(){
		scroll(0,0);
	},400);
	$('body').fadeIn(300);
}