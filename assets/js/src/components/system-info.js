window.onload = function() {
	var textarea = jQuery('#system-info-textarea');
	if (textarea.length) {
		textarea.css('height', jQuery(window).height() * 0.7 + 'px');
	}
	console.log('test');
};
