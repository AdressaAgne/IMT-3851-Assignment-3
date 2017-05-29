// Activate navigation drawer when hamburger is clicked
$('.hamburger').on('click', function() {
	$('nav.overlay').addClass('active');
});

// Deactivate navigation drawer when overlay (not drawer) is clicked
$('nav.overlay').on('click', function() {
	$('nav.overlay').removeClass('active')
}).children().click(function(e) {
	return false;
});	