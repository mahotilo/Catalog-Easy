/* swipe support from http://wowmotty.blogspot.com/2011/10/adding-swipe-support.html */
var maxTime = 1000, // allow movement if < 1000 ms (1 sec)
	maxDistance = 30,  // swipe movement of 50 pixels triggers the swipe
	startX = 0,
	startTime = 0,
	touch = "ontouchend" in document,
	startEvent = (touch) ? 'touchstart' : 'mousedown',
	moveEvent = (touch) ? 'touchmove' : 'mousemove',
	endEvent = (touch) ? 'touchend' : 'mouseup';

$(function(){
	$('.EC_Carousel:not(.owl-carousel)').each(function(){
		var $carousel = $(this);
		var speed = $carousel.data('speed') || 5000;

  		$carousel
			.carousel({interval:speed})

			.bind(startEvent, function(e){
				// prevent image drag (Firefox)
				e.preventDefault();
				startTime = e.timeStamp;
				startX = e.originalEvent.touches ? e.originalEvent.touches[0].pageX : e.pageX;
			})
			.bind(endEvent, function(e){
				startTime = 0;
				startX = 0;
			})
			.bind(moveEvent, function(e){
				e.preventDefault();
				var currentX = e.originalEvent.touches ? e.originalEvent.touches[0].pageX : e.pageX,
					currentDistance = (startX === 0) ? 0 : Math.abs(currentX - startX),
					currentTime = e.timeStamp;
				if (startTime !== 0 && currentTime - startTime < maxTime && currentDistance > maxDistance) {
					if (currentX < startX) {
						$carousel.carousel('next');
					}
					if (currentX > startX) {
						$carousel.carousel('prev');
					}
					startTime = 0;
					startX = 0;
				}
			})
						
			.filter('.start_paused')
			.carousel('pause');
		if ( $carousel.find(".item, .carousel-item").length < 2 ){
      		$carousel.find(".carousel-indicators, .carousel-control").hide();
    	}
	});
});