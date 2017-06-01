$(function(){
	var url = ['outbox', 'inbox'];
	var index = 0;

	$("#outbox").click(function(){
		var _this = $(this);
		$.get({
			url : '/messages/'+url[index],
			success : function(data){
				$("#messagebox tbody").html('');
				$.each(data, function(key, item){
					console.log(item);

					var row = '<tr>';
					row += '<td>'+item.time+'</td>';
					row += '<td>'+item.from_user+'</td>';
					row += '<td>'+item.to_user+'</td>';
					row += '<td>'+item.message+'</td>';
					row += '</tr>';

					$("#messagebox tbody").append(row);
				});
				index = (index == 1) ? 0 : 1;
				$(_this).text(url[index]);
			}
		});
	});
});