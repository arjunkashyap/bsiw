
$(function() {
	$('li').has('ul').mouseover(function(){
	$(this).children('ul').css('visibility','visible');
	}).mouseout(function(){
	$(this).children('ul').css('visibility','hidden');
	});
}); 
