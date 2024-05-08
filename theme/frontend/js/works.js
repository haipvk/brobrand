var WORK_MANAGE = (function () {
    var initPaginate = function () {
        initBtnLoadMore();
        $(document).on("worksAjaxLoaded", function (e, eventInfo) {
            initBtnLoadMore();
        });
        $(document).on("click", "#load-more-btn-result a", function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr("href"),
                type: "GET",
            }).done(function (data) {
                $(".works-page-pagination").remove();
                $(".garelly-we__dos .my-shuffle").append(data);
                initBtnLoadMore();
            });
        });
    };

    var initBtnLoadMore = function () {
        var nextBtn = $('a[rel="next"]');
        if (nextBtn.length == 0) {
            $("#load-more-btn-result").addClass("d-none");
            return;
        }
        $("#load-more-btn-result").removeClass("d-none").find("a").attr("href", nextBtn.attr("href"));
    };

    return {
        _: function () {
            initPaginate();
        },
    };
})();
$(document).ready(function () {
    WORK_MANAGE._();
});
