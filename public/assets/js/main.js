function registerFromEvents(){
	$(function(){
		// remove eventListeners
		$('form').off('submit');
		// Add eventListeners
		$('form').submit(function(e){
			e.preventDefault();
			var data = {};
			// calling function for form
			var successFunc = $(this).find('[type=submit]').attr('name');

			// Assigning key and names to data object
			$(this).find('input').each(function(key,item){
				data[$(item).attr('name')] = $(item).val();
			});

			// calling ajax
			ajax($(this).attr('action'), data, function(json) {
				$('span.input-error').remove();
				if(typeof data.invalid != null){
					$('input[name='+data.invalid+']').after('<span class="input-error">'+data.invalid+' is Invalid</span>');
				}

				if(typeof json.toast != undefined && json.toast != null){
					toast(json.toast);
				}
				// check if the submit button name is a function, and call it. setting the this varibale to the json data
				if(typeof window[successFunc] == 'function') {
					window[successFunc].call(json);
				} else {
					console.log('please add function: ' + successFunc, 'Outside of the jQuery function $(function(){})');
				}
			});
		});

		$('#logout').off('click');

		$('#logout').click(function(){
			fetch('/logout', function(){
				fetch('/menu', function(data){
					$('.drawer ul').html(data);
				});
			});
		});
	});
}

function ajax(url, data, successCallback, fail){
	$(function(){
		$.post({
			url : url,
			data : data,
			dataType : 'JSON',
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

function fetch(url, func){
	$(function(){
		return $.get({
			url : url,
			success : function(response){
				if(typeof response.toast != undefined && response.toast != null){
					toast(response.toast);
				}
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

// window.onpopstate = function(e){
// 	if(e.state){
// 		fetch(e.state, function(response){
// 			$('main').html(response);
// 			console.log(e.state)
// 			window.history.pushState(e.state, 'Title', e.state);
// 			document.title = e.state;
// 		});
// 	}
// };

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
	});
}

// Register ajax click events
ajaxData();
// Register form click events
registerFromEvents();
refreshMenu()

function login_submit(){
	if(this.status === true){
		fetch('/menu', function(data){
			$('.drawer ul').html(data);
		});
	} else {
		$('#login-error').html(this.status);
	}
}

function register_submit(){
	console.log(this);
}