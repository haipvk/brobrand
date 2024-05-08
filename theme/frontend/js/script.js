var GUI = (function () {
    var win = $(window);
    var html = $("html,body");
    function doAnimations(elems) {
        var animEndEv = "webkitAnimationEnd animationend";
        elems.each(function () {
            var $this = $(this),
                $animationType = $this.data("animation");
            $this.addClass($animationType).one(animEndEv, function () {
                $this.removeClass($animationType);
            });
        });
    }
    var menuMobile = function () {
        $(document).ready(function ($) {
            $(".button-phone").on("click", function (event) {
                $(".animated-icon1").toggleClass("open");
                $(".bg-over-menu").toggleClass("show-over");
                $("#header_main").toggleClass("d-none");
                $(".header").toggleClass("header-show__menus");
                $("#main-menu-mobile").fadeToggle("fast");
                $(".close-menu-btn").addClass("active-close__menussss");
                $(".content-header").toggleClass("active-content__header");
                $(".modals-fix__header").toggleClass("modal-menus__shows");
                $("body").toggleClass("overflow-hidden");
                var aniElm = $("header").find("[data-animation ^= 'animated']");
                doAnimations(aniElm);
            });
            $(".bg-over-menu").on("click", function (event) {
                $(".animated-icon1").toggleClass("open");
                $(".bg-over-menu").toggleClass("show-over");
                $("#main-menu-mobile").fadeUp();
                $(".close-menu-btn").removeClass("active-close__menussss");
                $(".content-header").removeClass("active-content__header");
            });
            $(".close-menu-btn").on("click", function (event) {
                $(".animated-icon1").toggleClass("open");
                $(".bg-over-menu").toggleClass("show-over");
                $("#main-menu-mobile").removeClass("active-menu-mobile");
                $(this).removeClass("active-close__menussss");
                $(".content-header").removeClass("active-content__header");
            });
        });
        $("#main-menu-mobile .menu_clone")
            .find("ul li")
            .each(function () {
                if ($(this).find("ul>li").length > 0) {
                    $(this).prepend("<i></i>");
                }
            });
        $(".menu-desktop")
            .find("ul li ul li")
            .each(function () {
                if ($(this).find("ul>li").length > 0) {
                    $(this).prepend("<i></i>");
                }
            });
        $("#main-menu-mobile .menu_clone ul")
            .find("li i")
            .click(function (event) {
                var ul = $(this).nextAll("ul");
                if (ul.is(":hidden")) {
                    $(this).addClass("active");
                    ul.slideDown(200);
                } else {
                    $(this).removeClass("active");
                    ul.slideUp();
                }
            });

        var hw = window.innerHeight;
        var heighttops = $(".header").outerHeight();
        $(".body-pages").css("padding-top", heighttops);
    };

    var _scroll_menus = function () {
        window.onscroll = function () {
            var currentScrollPos = window.pageYOffset;
            if (win.scrollTop() > 1) {
                $(".header").addClass("active-fixed__headers");
                $(".logo-fade__headers .right").addClass("active");
                $(".logo-fade__headers .left").addClass("active");
            } else {
                $(".header").removeClass("active-fixed__headers");
                $(".logo-fade__headers .right").removeClass("active");
                $(".logo-fade__headers .left").removeClass("active");
            }
        };
    };

    var scrollVideosMains = function () {
        var win = $(window);
        var vdMains = $(".banner-mains").outerHeight();
        var headerMains = $(".header").outerHeight();

        if ($(".banner-mains").hasClass("videos-mains__plays")) {
            $("body").addClass("overflow-hidden");
        }

        $(window).bind("mousewheel DOMMouseScroll", function (event) {
            if (event.originalEvent.wheelDelta > 0 || event.originalEvent.detail < 0) {
            } else {
                $(".banner-mains").removeClass("videos-mains__plays");
                $("body").removeClass("overflow-hidden");
                $("body").css("padding-top", "0");

                if ($(".banner-mains").length > 0) {
                    $(".what-we__do").css("padding-top", headerMains);
                    $(".header").addClass("header-whell__pages ");
                } else {
                    $(".what-we__do").css("padding-top", headerMains);
                    $(".header").removeClass("header-whell__pages ");
                }
            }
        });
    };

    var textImgs = function () {
        $(".modal").on("show.bs.modal", function () {
            setTimeout(function () {
                if ($(".intros-prjs__details p").find("img").length < 1) {
                }
            }, 500);
        });
    };

    var modalsColor = function () {
        var win = $(window);
        var heighttops = $(".header").outerHeight();
        var linkPrjMain = $(".name-prj__items");
        $(".modal-prj__news").removeClass("modals-career");
        linkPrjMain.click(function (event) {
            event.preventDefault();

            var bgModalPrj = $(this).data("backgrounds");
            var textModalPrj = $(this).data("text");

            $(".modal-prj__news").css("backgroundColor", bgModalPrj);

            $(".modal-prj__news").css("color", textModalPrj);

            $(".header").addClass("modals-fix__header");
        });

        var linkCareerMain = $(".name-career__items");
        linkCareerMain.click(function (event) {
            event.preventDefault();

            $(".header").addClass("header-modal__career");

            $(".header").addClass("modals-fix__header");

            // $(".modal-prj__news .modal-content").addClass("modals-careerss");
        });

        $(".modal-prj__news .modal-content").css("padding-top", heighttops);
        $(".modal.modal-prj__news").on("show.bs.modal", function () {
            heighttops = $(".header").outerHeight();
            // $(".modal-prj__news .modal-content").css("padding-top", heighttops);
        });
    };
    var resetModal = function () {
        $("#modal-news__prjs").modal("hide");
        $(".header").removeClass("modals-fix__header");
        $(".header").removeClass("header-modal__career");
        $(".bg-over-menu").removeClass("show-over");
        $("#main-menu-mobile").slideUp("fast");
        $(".modal-prj__news").removeClass("modals-careerss");
    };
    var modalsScroll = function () {
        var win = $(window);
        var currentScrollPos = window.pageYOffset;
        var prevScrollpos = window.pageYOffset;

        $("#modal-carrers").scroll(function () {
            var scroll2 = $("#modal-carrers").scrollTop();
            var heights2s = $(".header").outerHeight();
            prevScrollpos = currentScrollPos;

            if (scroll2 >= heights2s) {
                $(".header").removeClass("header-modal__career");
            } else {
                $(".header").addClass("header-modal__career");
            }
        });

        $(document).ready(function () {
            $(".btn-close__pages").click(function () {
                resetModal();
                if (globalBeforeUrlAjax == undefined) {
                    globalBeforeUrlAjax = "/";
                }
                var location = globalBeforeUrlAjax.replace(document.location.origin + "/", "");
                window.history.replaceState("", "", location);
            });
        });
    };

    var bgAlls = function () {
        if ($(".body-pages").hasClass("body-pages")) {
            $(".header").addClass("header-pagess");
        } else {
        }

        if ($(".body-pages").hasClass("body-pages__greens")) {
            $(".all-pages__web").addClass("bg-green__bodys");
            $(".header").addClass("green-headers");
            $(".footer").addClass("green-footer");
        } else {
            $(".all-pages__web").removeClass("bg-green__bodys");
            $(".header").removeClass("green-headers");
            $(".footer").removeClass("green-footer");
        }

        if ($(".body-pages").hasClass("body-pages__greys")) {
            $(".all-pages__web").addClass("bg-grey__bodys");
            $(".header").addClass("grey-headers");
            $(".footer").addClass("grey-footer");
        } else {
            $(".all-pages__web").removeClass("body-pages__greys");
            $(".header").removeClass("grey-headers");
            $(".footer").removeClass("grey-footer");
        }

        if ($("body").find(".banner-mains").length > 0) {
            $(".logo-mains").addClass("logo-white__mains");
        } else {
            $(".logo-mains").removeClass("logo-white__mains");
        }
    };

    var showsPartners = function () {
        $(".see-more__partners").click(function () {
            $(".list-names__partners li").slideToggle();
        });
    };

    var slideTitle = function () {
        $(".slide-title > span").first().addClass("visits");
        setInterval(function () {
            $(".slide-title > span:nth-child(1)").fadeOut(0).removeClass("visits").next().fadeIn(350).addClass("visits").end().appendTo(".slide-title");
        }, 6000);
        $(".slide-title__rights > span").first().addClass("visits");
        setInterval(function () {
            $(".slide-title__rights > span:nth-child(1)").fadeOut(0).removeClass("visits").next().fadeIn(350).addClass("visits").end().appendTo(".slide-title__rights");
        }, 1600);
    };

    var sliderMotto = function () {
        if ($(".slide-mottos").length === 0) return;
        var swiper2 = new Swiper(".slide-mottos", {
            slidesPerView: 1,
            spaceBetween: 20,
            draggable: true,
            loop: true,
            speed: 1500,
            autoplay: {
                delay: 3200,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            effect: "coverflow",
            coverflowEffect: {
                rotate: 50,
                stretch: 10,
                depth: 100,
                modifier: 1,
                slideShadows: true,
            },
            breakpoints: {
                // when window width is >= 320px
                320: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                },
                576: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                },
                992: {
                    slidesPerView: 1,
                    spaceBetween: 10,
                },
                1200: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                },
                1440: {
                    slidesPerView: 1,
                    spaceBetween: 02,
                },
            },
        });

        $(".banner-button-prev").click(function () {
            $(this).parents(".motto-shows__slides").find(".swiper-button-prev").trigger("click");
        });

        $(".banner-button-next").click(function () {
            $(this).parents(".motto-shows__slides").find(".swiper-button-next").trigger("click");
        });
    };

    var initWowJs = function () {
        new WOW().init();
    };

    var initSliderBanner = function () {
        if ($(".slider-banner-main").length == 0) return;
        var swiper = new Swiper(".slider-banner-main", {
            slidesPerView: 1,
            spaceBetween: 0,
            draggable: true,
            loop: true,
            speed: 800,
            autoplay: {
                delay: 6000,
                disableOnInteraction: false,
            },
            effect: "fade",
        });
        $(".slider-banner-main .btn-prev").click(function () {
            swiper.slidePrev();
        });
        $(".slider-banner-main .btn-next").click(function () {
            swiper.slideNext();
        });
    };

    var intTabServices = function () {
        $(".item-service-category .header-item").click(function () {
            var parentBox = $(this).parent();
            var contentItem = parentBox.find(".content-item");
            if (parentBox.hasClass("active")) {
                parentBox.removeClass("active");
                contentItem.slideUp(200);
            } else {
                $(".item-service-category .content-item").slideUp(200);
                $(".item-service-category").removeClass("active");
                parentBox.addClass("active");
                contentItem.slideDown(200);
            }
        });
    };

    var initSliderPartner = function () {
        if ($(".slider-partner").length == 0) return;
        $(".slider-partner").each(function () {
            var prevBtn = $(this).parent().find(".slider-partner-prev");
            var nextBtn = $(this).parent().find(".slider-partner-next");
            const swiper = new Swiper($(this), {
                slidesPerView: 1,
                spaceBetween: 0,
                draggable: true,
                // loop: true,
                speed: 1000,
                navigation: {
                    nextEl: nextBtn,
                    prevEl: prevBtn,
                },
                autoplay: {
                    delay: 10000,
                    disableOnInteraction: false,
                },
                breakpoints: {
                    1200: {
                        spaceBetween: 0,
                    },
                    1599: {
                        spaceBetween: 0,
                    },
                },
            });
        });
    };
    return {
        _: function () {
            menuMobile();
            bgAlls();
            sliderMotto();
            modalsColor();
            modalsScroll();
            _scroll_menus();
            slideTitle();
            initWowJs();
            showsPartners();
            initSliderBanner();
            intTabServices();
            initSliderPartner();
        },
    };
})();
$(document).ready(function () {
    GUI._();
});

const items = document.querySelectorAll(".accordion button");

function toggleAccordion() {
    const itemToggle = this.getAttribute("aria-expanded");

    for (i = 0; i < items.length; i++) {
        items[i].setAttribute("aria-expanded", "false");
    }

    if (itemToggle == "false") {
        this.setAttribute("aria-expanded", "true");
    }
}

items.forEach((item) => item.addEventListener("click", toggleAccordion));


