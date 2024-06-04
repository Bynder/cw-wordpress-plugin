document.addEventListener('DOMContentLoaded', function() {
	if (typeof redirectData !== 'undefined' && redirectData.redirectUrl) {
		window.location = redirectData.redirectUrl;
	}
});
