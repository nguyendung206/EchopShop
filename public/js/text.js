$(document).ready(function () {
    $(".multiple-items-1").slick({
        rows: 2,
        slidesToShow: 2,
        slidesToScroll: 2,
        infinite: false,
        prevArrow:
            "<button type='button' class='slick-prev pull-left'><i class='fa-solid fa-angle-left'></i></button>",
        nextArrow:
            "<button type='button' class='slick-next pull-right'><i class='fa-solid fa-angle-right'></i></button>",
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: true,
                },
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                },
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                },
            },
        ],
    });
});

$(".multiple-items-2").slick({
    infinite: true,
    slidesToShow: 4,
    slidesToScroll: 4,
    infinite: false,
    prevArrow: "<button type='button' class='slick-prev pull-left'><i class='fa-solid fa-angle-left'></i></button>",
    nextArrow: "<button type='button' class='slick-next pull-right'><i class='fa-solid fa-angle-right'></i></button>",
    responsive: [{
        breakpoint: 1024,
        settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
            infinite: true,
            dots: true,
        },
    },
    {
        breakpoint: 600,
        settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
        },
    },
    {
        breakpoint: 480,
        settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
        },
    },
    ],
});
$('.gift-list').slick({
    dots: true,
    infinite: false,
    speed: 300,
    slidesToShow: 5,
    slidesToScroll: 2,
    prevArrow: $('.slick-prev-gift'),
    nextArrow: $('.slick-next-gift'),
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
            navbar.classList.toggle('showMenu');
            toggle.classList.toggle('rotate');
            bodypadding.classList.toggle('expander');
            overlay.classList.toggle('overlay');
        });
    }

    if (close && navbar) {
        close.addEventListener('click', () => {
            navbar.classList.remove('showMenu');
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
$(document).ready(function () {
    var activeTab = localStorage.getItem('activeTab');

    if (activeTab) {
        $('.profile-tab[data-tab="' + activeTab + '"]').addClass('active-profile');
    }

    $('.profile-tab').on('click', function () {
        $('.profile-tab').removeClass('active-profile');

        $(this).addClass('active-profile');

        var tab = $(this).data('tab');
        localStorage.setItem('activeTab', tab);
    });
});


