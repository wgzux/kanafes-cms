(function ($) {
    "use strict";

    // jQuery(document).ready(function ($) {




    // });


    // jQuery(window).load(function () {


    // });
  jQuery(document).ready(function ($) {
    // Mobile menu functionality
    $('.mobile-menu-toggle').on('click', function () {
        $(this).toggleClass('active');
        $('.header__nav-bar').toggleClass('mobile-menu-open');
    });
    $('.header__nav-bar a').on('click', function() {
        $('.mobile-menu-toggle').removeClass('active');
        $('.header__nav-bar').removeClass('mobile-menu-open');
        $('body').removeClass('mobile-menu-is-open');
    });

    const track = $('.sponsors-slider__track');
    const items = $('.sponsors-slider__item');
    
    if (items.length > 0) {
        // Initialize slider only after all images are loaded
        let sliderInterval;
        let imagesLoaded = 0;
        const totalImages = items.find('img').length;
        
        // Function to initialize the slider
        function initializeSlider() {
            // Clone all items and append them for seamless loop
            const clonedItems = items.clone();
            track.append(clonedItems);
            
            const itemWidth = items.first().outerWidth(true);
            const totalItems = items.length;
            const trackWidth = itemWidth * totalItems * 2; // Double width for cloned items
            
            track.css('width', trackWidth + 'px');
            
            let position = 0;
            let isAnimating = false;
            
            function slideNext() {
                if (isAnimating) return;
                isAnimating = true;
                
                position -= itemWidth;
                
                track.css({
                    'transform': `translateX(${position}px)`,
                    'transition': 'transform 0.5s ease-in-out'
                });
                
                // Reset position when we've moved through all original items
                if (Math.abs(position) >= itemWidth * totalItems) {
                    setTimeout(() => {
                        position = 0;
                        track.css({
                            'transform': `translateX(${position}px)`,
                            'transition': 'none'
                        });
                        isAnimating = false;
                    }, 500); // Wait for transition to complete
                } else {
                    setTimeout(() => {
                        isAnimating = false;
                    }, 500);
                }
            }
            
            // Auto-slide functionality
            sliderInterval = setInterval(slideNext, 3000);
        }
        
        // Check if there are images to load
        if (totalImages > 0) {
            // Add load event listener to each image
            items.find('img').each(function() {
                // Check if image is already loaded (from cache)
                if (this.complete) {
                    imagesLoaded++;
                    if (imagesLoaded === totalImages) {
                        initializeSlider();
                    }
                } else {
                    // Add load event for images not yet loaded
                    $(this).on('load', function() {
                        imagesLoaded++;
                        if (imagesLoaded === totalImages) {
                            initializeSlider();
                        }
                    });
                    
                    // Handle error case
                    $(this).on('error', function() {
                        imagesLoaded++;
                        if (imagesLoaded === totalImages) {
                            initializeSlider();
                        }
                    });
                }
            });
        } else {
            // No images to load, initialize slider immediately
            initializeSlider();
        }
    }
});

}(jQuery));