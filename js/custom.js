(function ($) {
    'use strict';

    $(document).on('ready', function () {
        // -----------------------------
        //  Screenshot Slider
        // -----------------------------
        $('.speaker-slider').slick({
            slidesToShow: 3,
            centerMode: true,
            infinite: true,
            autoplay: true,
            arrows:true,
            responsive: [
                {
                    breakpoint: 1440,
                    settings: {
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 500,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]
         });
        // -----------------------------
        //  Count Down JS
        // -----------------------------
        $('.timer').syotimer({
            year: 2025,
            month: 11,
            day: 13,
            hour: 9,
            minute: 30
        });
        // -----------------------------
        // To Top Init
        // -----------------------------
        $('.to-top').click(function() {
          $('html, body').animate({ scrollTop: 0 }, 'slow');
          return false;
        });
        
        // -----------------------------
        // Magnific Popup
        // -----------------------------
        $('.image-popup').magnificPopup({
            type: 'image',
            removalDelay: 160, //delay removal by X to allow out-animation
            callbacks: {
                beforeOpen: function () {
                    // just a hack that adds mfp-anim class to markup
                    this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
                    this.st.mainClass = this.st.el.attr('data-effect');
                }
            },
            closeOnContentClick: true,
            midClick: true,
            fixedContentPos: false,
            fixedBgPos: true

        });
        // -----------------------------
        // Mixitup
        // -----------------------------
        var containerEl = document.querySelector('.gallery-wrapper');
        var mixer;
        if (containerEl) {
            mixer = mixitup(containerEl);
        }

          // Get the URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const tabName = urlParams.get('tab'); // Get the 'tab' parameter value
        console.log(84, tabName)
    // If a tab name is found in the URL, activate the corresponding tab
    if (tabName) {
        const tabToActivate = $(`.nav-link[href="#${tabName}"]`);
        const tabContentToActivate = $(`#${tabName}`);

        if (tabToActivate.length && tabContentToActivate.length) {
            // Deactivate currently active tab and content
            $('.nav-link.active').removeClass('active');
            $('.tab-pane.active').removeClass('active show');

            // Activate the selected tab and content
            tabToActivate.addClass('active');
            tabContentToActivate.addClass('active show');
        }
    }

    $('.read-more').on('click', function (e) {
        e.preventDefault();
        var fullText = $(this).siblings('.card-text').text();
        $(this).siblings('.card-text').css({
            '-webkit-line-clamp': 'none',
            'display': 'block'
        }).text(fullText);
        $(this).remove();
    });
    });

})(jQuery);


// Countdown Timer for December 8, 2025
function updateCountdown() {
    const targetDate = new Date("December 8, 2025 00:00:00").getTime();
    const now = new Date().getTime();
    const distance = targetDate - now;

    if (distance < 0) {
        document.getElementById("countdown").innerHTML = "The event has started!";
        clearInterval(interval);
        return;
    }

    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

    document.getElementById("countdown").innerHTML =
        `${days}d ${hours}h ${minutes}m ${seconds}s`;
}

const interval = setInterval(updateCountdown, 1000);
updateCountdown();

