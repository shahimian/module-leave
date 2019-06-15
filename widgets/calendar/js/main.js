$('table.calendar-jalali tr:not(:first-child) td').click(function(){
	$('table.calendar-jalali td.active').removeClass('active');
	$(this).addClass('active');
	$('a[href*="create"]').show();
})

$(document).mouseup(function(e){
    var container = $("table.calendar-jalali td.active");
    if (!container.is(e.target) && container.has(e.target).length === 0)
    {
        container.removeClass('active');
        $('a[href*="create"]').hide();
    }
});
