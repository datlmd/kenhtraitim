$.fn.tabs = function() {
	var selector = this;
	var isSelected = false;
	
	this.each(function() {
		var obj = $(this); 
		
		$(obj.attr('href')).hide();
		
		if (obj.hasClass('selected')) {
			isSelected = true;
		}
		
		$(obj).click(function() {
			$(selector).removeClass('selected');
			
			$(selector).each(function(i, element) {
				$($(element).attr('href')).hide();
			});
			
			$(this).addClass('selected');
			
			$($(this).attr('href')).show();
			
			return false;
		});
	});

	$(this).show();
	
	if (isSelected == false) {
	$(this).first().click();
	}
	else {
		$(this, '.selected').click();
	}
};