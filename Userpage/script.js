$(document).ready(function(){
    $('.carousel').slick({
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: true,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 3000,
        appendDots: $(".carousel-section"),
        dotsClass: "slick-dots custom-dots",
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });

    $('.see-more').on('click', function(e) {
        e.preventDefault();
        $(this).prev('.product-description').toggleClass('expanded');
        $(this).text($(this).text() === 'See more' ? 'See less' : 'See more');
    });
    // Dropdown functionality
    $('nav ul li').hover(
        function() {
            $(this).children('.dropdown').stop(true, false, true).slideToggle(300);
        }
    );
});
