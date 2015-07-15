$(document).ready(function () {
	/* Basic JavaScript Course
	   Section Two, Item #7: DRILL
	   -- Slider Menu -- */
	$("nav ul").hide();
	$("#menu").hover(
		function () {  // handlerIn event
			$("nav ul").slideDown(); },
		function () {  // handlerOut event
			$("nav ul").slideUp(); }
	);  // end menu hover
	
	/* Basic JavaScript Course
	   Section Two, Item #17: FINAL PRACTICAL
	   -- Image Slider -- */
	var image;
	var preLoadedImages = [];
	$("#slider img").each(function () {  // pre-loading images
		image = new Image();
		image.src = $(this).attr("src");
		image.alt = $(this).attr("alt");
		preLoadedImages.push( image );
	});  //  end pre-loading images
	var imgCounter = 0;
	var nextSlide;
	setInterval(function () {  // starter the slider
		$("#currentSlide").fadeOut(2000,
			function() {
					imgCounter = (imgCounter + 1) % preLoadedImages.length;
					nextSlide = preLoadedImages[imgCounter];
					$("#currentSlide").attr("alt", nextSlide.alt);
					$("#currentSlide").attr("src", nextSlide.src).fadeIn(2000);
			}
		);
	}, 5000);  // end slider
}); 
