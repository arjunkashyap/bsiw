$(document).ready(function(){
	$("html, body").hide().fadeIn('slow').animate({ scrollTop: $('#menu').offset().top }, 1000);
	// Shuffles
	$.shuffle('#realSlider .realSliderItem');
	// Shuffles Ends here
});
$(window).load(function(){
	
	// Find the slider and add bullets holder
	$('#realSlider').append('<div id="dots"></div>');
	// Get all slider items
	var divs = $('.realSliderItem').hide();
	// Foreach slider items, append one bullet inside bullet holder
	divs.each(function(e,c){
		// append bullet inside bullet holder
		$('#dots').append('<div class="dot" data="'+e+'"></div>')
	});
	// get all bullets and remove .dotActive class if exists
	var dots = $('#dots > .dot').removeClass('.dotActive');
	// i for auto increment
	i = 0;

	$('.dot').click(function(){
		i = $(this).attr('data');
	});

	// Cycle starts
	(function slidecycle(inc) {
		divs.eq(i).show("fade", 0)
				  .delay(7000)
				  .hide("fade", 200);
		dots.eq(i).addClass("dotActive", 0)
				  .delay(7000)
				  .removeClass("dotActive", 200, slidecycle);
		i = ++i % divs.length;
	})();
	// Cycle ends
	
});

(function(d){d.fn.shuffle=function(c){c=[];return this.each(function(){c.push(d(this).clone(true))}).each(function(a,b){d(b).replaceWith(c[a=Math.floor(Math.random()*c.length)]);c.splice(a,1)})};d.shuffle=function(a){return d(a).shuffle()}})(jQuery);
