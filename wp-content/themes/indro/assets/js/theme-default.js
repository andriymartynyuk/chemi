jQuery( document ).ready(function($) {

    // Preloader
    $(window).on('load', function () {
        $('#preloader').fadeOut(1000); 
       });
     
    // Nice Select Plugin
    //$('select').niceSelect();

    $('a.next').text('→');
    $('a.prev').text('←');

  if (window.location.href.indexOf("home") > -1) {
      $('body').addClass('home_not_set');
    }
	
	
	
// 	Scroll button
	
	var btn = $('.bdt-scroll-button');

$(window).scroll(function() {
  if ($(window).scrollTop() > 500) {
    btn.addClass('show');
  } else {
    btn.removeClass('show');
  }
});

btn.on('click', function(e) {
  e.preventDefault();
  $('html, body').animate({scrollTop:0}, '500');
});

});
