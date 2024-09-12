$('.gift-list').slick({
    dots: true,
    infinite: false,
    speed: 300,
    slidesToShow: 5,
    slidesToScroll: 2,
    prevArrow: $('.slick-prev'),
    nextArrow: $('.slick-next'),
    responsive: [
        {
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: true
            }
        },
        {
            breakpoint: 600,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 3
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 3
            }
        }
    ]
});
$('.responsive').slick({
    dots: true,
    infinite: false,
    speed: 300,
    slidesToShow: 6,
    slidesToScroll: 4,
    prevArrow: "<button type='button' class='slick-prev pull-left'><i class='fa-solid fa-angle-left'></i></button>",
    nextArrow: "<button type='button' class='slick-next pull-right'><i class='fa-solid fa-angle-right'></i></button>",
    responsive: [
        {
            breakpoint: 1024,
            settings: {
                slidesToShow: 5,
                slidesToScroll: 3,
                infinite: true,
                dots: true
            }
        },
        {
            breakpoint: 600,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3
            }
        }
    ]
});


$('.list-brand').slick({
    dots: true,
    infinite: false,
    speed: 300,
    slidesToShow: 4,
    slidesToScroll: 2,
    prevArrow: "<button type='button' class='slick-prev pull-left'><i class='fa-solid fa-angle-left'></i></button>",
    nextArrow: "<button type='button' class='slick-next pull-right'><i class='fa-solid fa-angle-right'></i></button>",
    responsive: [
        {
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: true
            }
        },
        {
            breakpoint: 600,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 3
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 3
            }
        }
    ]
});

const showMenu = (toggleId, navbarId, bodyId, overlayId, closeId) => {
    const toggle = document.getElementById(toggleId),
        navbar = document.getElementById(navbarId),
        bodypadding = document.getElementById(bodyId),
        overlay = document.getElementById(overlayId),
        close = document.getElementById(closeId);

    if (toggle && navbar) {
        toggle.addEventListener('click', () => {
            navbar.classList.toggle('show');
            toggle.classList.toggle('rotate');
            bodypadding.classList.toggle('expander');
            overlay.classList.toggle('overlay');
        });
    }

    if (close && navbar) {
        close.addEventListener('click', () => {
            navbar.classList.remove('show');
            toggle.classList.remove('rotate');
            bodypadding.classList.remove('expander');
            overlay.classList.remove('overlay');
        });
    }
}

showMenu('nav-toggle', 'navbar', 'body', 'overlay', 'close-sidebar');

$(document).ready(function () {
    $('#menu-profile-toggle').click(function () {
        $('#category-profile').slideToggle();
    });
})