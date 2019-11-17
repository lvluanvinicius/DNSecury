$(document).ready(function() {

    // OWL Carousel
    $("#owl-slider").owlCarousel({
        items : 4,
        loop : true,
        margin : 10,
        autoplay : true,
        autoplayTimeout : 2000,
        dots : false,

        // Layout responsivo
        responsive : {
            
            0 : {
                items : 1
            },
            575 : {
                items : 2
            },
            926 : {
                items : 3
            },
            1100 : {
                items : 4
            },
            1370 : {
                items : 5
            }
        }
    });


});