var scroll_smooth = (target,delay) => {
	$('html, body').animate({scrollTop: $(target).offset().top}, delay);
}