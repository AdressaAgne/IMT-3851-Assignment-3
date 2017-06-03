$(function(){

	// Add sticky menu on scroll
	$(window).scroll(function(){
		if ($(window).width() > 700 )
		   if($(this).scrollTop() > 49){
				$('nav').css('position','fixed');
				$('nav').css('z-index','100000');
				$('nav').css('box-shadow','0px 0px 10px 0px rgba(0,0,0,.2)');
				$('header').css('margin-bottom', '60px');
		   } else {
				$('nav').css('z-index','0');
				$('nav').css('box-shadow','none');
				$('nav').css('position','static');
				$('header').css('margin-bottom', '0px');
		   }
   })

	   // Go back if an element with data-back attribute is clicked
	$('[data-back]').click(function(){
		console.log(this);
		window.history.back();
	});

});

function registerFromEvents(){
	$(function(){
		// remove eventListeners
		$('form').off('submit');
		// Add eventListeners
		$('form').submit(function(e){
			e.preventDefault();
			var data = {};
			var _this = $(this);
			// calling function for form
			var successFunc = $(this).find('[type=submit]').attr('name');

			// Assigning key and names to data object
			$(this).find('input, textarea, select').each(function(key,item){
				data[$(item).attr('name')] = $(item).val();
			});

			// calling ajax
			ajax($(this).attr('action'), data, function(json) {

				// If responce has a toast param, show toast
				if(typeof json.toast != undefined && json.toast != null){
					toast(json.toast);
				}
				// check if the submit button name is a function, and call it. setting the this varibale to the json data, wroks same way as call_user_func_array in php
				if(typeof window[successFunc] == 'function') {
					window[successFunc].call(json, _this);
				} else {
					if(typeof successFunc != undefined) console.log('please add function: ' + successFunc, 'Outside of the jQuery function $(function(){})');
				}
			});
		});

		$('#logout').off('click');
		// Fetch new menu and logout the user
		$('#logout').click(function(){
			fetch('/logout', function(){
				// Redirect to index if lgout was successfull
				location.href = "/";
			});
		});
	});
}

// Simple jQuery ajax shorthand
function ajax(url, data, successCallback, fail){
	$(function(){
		$.post({
			url : url,
			data : data,
			success : function(e){
				if(typeof successCallback == 'function') successCallback(e);
			},
			error : function(e, str){
				if(typeof fail == 'function') {
					fail(e);
				} else {
					console.log('error', str);
					console.log(e);
				}
			}
		});
	});
}

// Simple jQuery ajax for get requests
function fetch(url, func){
	$(function(){
		return $.get({
			url : url,
			success : function(response){
				if(typeof response.toast != undefined && response.toast != null){
					toast(response.toast);
				}
				// Reload event listeners
				func(response);
				ajaxData();
				registerFromEvents();
				refreshMenu()
				return response;
			}
		});
	});
}

// Creates a toast, to notice user of changes
function toast(str){
	$('.toast').remove();
	$('body').append('<div class="toast">'+str+'</div>');
}

// Relace the main tag with new data from ajax response, and set the url to corespondant url
function ajaxData(){
	$('[data-ajax]').off('click');
	$('[data-ajax]').click(function(){
		var url = $(this).attr('data-ajax');
		fetch(url, function(response){
			$('main').html(response);
			window.history.pushState(url, 'Title', url);
			document.title = url;
		});
	});
}


// Activate navigation drawer when hamburger is clicked
function refreshMenu(){
	$(function(){
		$('.hamburder').off('click');
		$('.hamburger').on('click', function() {
			$('nav.overlay').addClass('active');
		});

		// Deactivate navigation drawer when overlay (not drawer) is clicked
		$('.exit-click').off('click');
		$('.exit-click').on('click', function() {
			$('nav.overlay').removeClass('active');
		});

		// Toggle login form in navigation
		$('body').off('click');
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
				// Toggle show class if close button is clicked
				if(e.target.id == 'close')
					$('.login-form').toggleClass('show hide');
				// Ignore any children of login-form (except above close button as stated in above if)
				if($(e.target).closest('#login-form').length)
					return;
				// Toggle show class if anywhere on body except the login-form is clicked
				$('.login-form').toggleClass('show hide');
			}

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
			}

		});
		//# Remove icon from input if a value is present
		$('input, textarea').keyup(function() {
			inputBg(this);
		});

		$('input, textarea').each(function(key, item) {
			inputBg(item);
		});

		function inputBg(elm){
			if ($(elm).val().length !== 0)
				return $(elm).css('background-image', 'none');
			return $(elm).css('background-image', '');
		}
	});
}

// Register ajax click events
ajaxData();
// Register form click events
registerFromEvents();
refreshMenu()

// This is run when the form sith type="submit" and name="login_submit"
function login_submit(){
	if(this.status === true){
		fetch('/menu', function(data){
			$('.drawer ul').html(data);
		});
	} else {
		$('#login-error').html(this.status);
	}
}
// This is run when the form sith type="submit" and name="register_submit"
function register_submit(){
	console.log(this);
}
// This is run when the form sith type="submit" and name="item_delete"
function item_delete(form){
	$(form).parent().parent().parent().slideUp();
}
// This is run when the form sith type="submit" and name="create_item"
function create_item(elm){
	// Redirect to new page when item was created
	if(this.id != null) location.href = "/item/"+this.id;
}