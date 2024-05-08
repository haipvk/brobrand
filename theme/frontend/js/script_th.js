var INIT = (function () {
    var _initAjaxWorks = function () {
        $(".ajax__load").click(function (event) {
            event.preventDefault();
            var _id = $(this).data("parent");
            $(this).parent().addClass("active");
            $(".list-prj__works ul li").not($(this).parent()).removeClass("active");
            $(".form-filter-ajax-works").find("input[name=id]").val(_id);
            $(".form-filter-ajax-works").submit();
        });
        $(".ajax__load_industries").click(function (event) {
            event.preventDefault();
            var _id = $(this).data("parent");
            $(this).parent().addClass("active");
            $(".list-prj__works_industries ul li").not($(this).parent()).removeClass("active");
            $(".form-filter-ajax-works").find("input[name=industries]").val(_id);
            $(".form-filter-ajax-works").submit();
        });
    };

    var _doFilter = function () {
        $(".form-filter-ajax-works").submit(function (event) {
            event.preventDefault();
            $("body").addClass("loading");
            $.ajax({
                url: $(this).attr("action"),
                type: "GET",
                dataType: "html",
                data: $(this).serialize(),
            }).done(function (data) {
                $(".result__ajax").html(data);
                $("body").removeClass("loading");
                $(document).trigger("worksAjaxLoaded", [1011]);
            });
        });
    };

    function makeHttpObject() {
        try {
            return new XMLHttpRequest();
        } catch (error) {}
        try {
            return new ActiveXObject("Msxml2.XMLHTTP");
        } catch (error) {}
        try {
            return new ActiveXObject("Microsoft.XMLHTTP");
        } catch (error) {}
        throw new Error("Could not create HTTP request object.");
    }
    var _loadContent = function () {
        var itemProject = $(".__load");
        itemProject.click(function (event) {
            event.preventDefault();
            var slug = $(this).attr("href");
            sendAjaxRequest(slug);
        });
    };
    var sendAjaxRequest = function (_slug) {
        var request = makeHttpObject();
        request.open("GET", _slug, true);
        request.setRequestHeader("X-Requested-With", "xmlhttprequest");
        $("body").addClass("loading");
        request.send(null);
        request.onreadystatechange = function () {
            if (request.readyState == 4) {
                globalBeforeUrlAjax = document.location.href;
                $(".paste__content").html(request.responseText);
                $(".header").addClass("modals-fix__header");
                var bgModalPrj = $("#modal-news__prjs .tops-prj__details").data("bg");
                var textModalPrj = $("#modal-news__prjs .tops-prj__details").data("text");
                $(".modal-prj__news").css("backgroundColor", bgModalPrj);
                $(".modal-prj__news").css("color", textModalPrj);
                $("#modal-news__prjs").modal("show");
                $(".modals-alls .modal-content").animate({
                    scrollTop: 0,
                });
                window.history.replaceState("", "", _slug);
            }
            $("body").removeClass("loading");
        };
    };
    var _backToTop = function () {
        var backTop = $(".back-to-top");
        var _posHeight = $("header").height();
        $(window).scroll(function (event) {
            if ($(window).scrollTop() > _posHeight) {
                backTop.show(300);
            } else {
                backTop.hide(300);
            }
        });
        backTop.click(function (event) {
            $("html,body").animate({ scrollTop: 0 }, 0);
        });
    };
    var _pushHTML = function () {
        if (url != "") {
            sendAjaxRequest(url);
            window.history.pushState("", "", url);
        }
    };

    return {
        _: function () {
            _initAjaxWorks();
            _doFilter();
            _loadContent();
            _backToTop();
            _pushHTML();
        },
    };
})();

var CONTACT = (function () {
    var sendContact = function (json) {
        if (json.code == 200) {
            toastr["success"](json.message);
            window.location.reload();
        } else {
            toastr["error"](json.message);
        }
    };
    return {
        _: function (json) {
            sendContact(json);
        },
    };
})();

$(document).ready(function () {
    $.ajaxSetup({
        data: {
            csrf_tech5s_name: $('meta[name="csrf-token"]').attr("content"),
        },
    });
    INIT._();
});
