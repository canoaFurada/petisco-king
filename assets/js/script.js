/* Script personalizado aqui */
$(function() {
	$(".day").on('click', function() {
		console.log(this);
		if ($(this).hasClass('btn-success')) {
			$(this).removeClass('btn-success');
			$(this).addClass('btn-default');
		} else {
			$(this).removeClass('btn-default');
			$(this).addClass('btn-success');
		}
	});
});