// Activate navigation drawer when hamburger is clicked
$('.hamburger').on('click', function() {
	$('nav.overlay').addClass('active');
});

// Deactivate navigation drawer when overlay (not drawer) is clicked
$('.exit-click').on('click', function() {
	$('nav.overlay').removeClass('active');
});

// Toggle login form in navigation
$('body').click(function(e){
	
	// If login is clicked
	if(e.target.id == 'login')
		// Toggle show hide classes
		$('.login-form').toggleClass('show hide');
	// If login-form has class show
	if($('.login-form').hasClass('show')) {
		// Ignore if login-form or login is clicked
		if(e.target.id == 'login-form' || e.target.id == 'login')
			return;
		// Ignore any children of login-form
		if($(e.target).closest('#login-form').length)
			return;
		// Toggle show class if anywhere on body except the login-form is clicked
		$('.login-form').toggleClass('show hide');
	};
	
	// If categories is clicked
	if(e.target.id == 'categories')
		// Toggle show hide classes
		$('#categories-list').toggleClass('show hide');
	// If categories has class show
	if($('#categories-list').hasClass('show')) {
		// Ignore if categories-list or categories is clicked
		if(e.target.id == 'categories' || e.target.id == 'categories-list')
			return;
		// Ignore any children of categories-list
		if($(e.target).closest('#categories-list').length)
			return;
		// Toggle show class if anywhere on body except the categories-list is clicked
		$('#categories-list').toggleClass('show hide');
	};
	
});