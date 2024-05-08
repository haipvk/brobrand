var RATING = {
    _: function() {
        $(".item-rating .rating-box i").click(function(t) {
            var _this = $(this);
                t.preventDefault(), $.ajax({
                    url: $(this).closest('.rating-box').data('action'),
                    type: "GET",
                    data: {
                        rate: $(this).data("score"),
                        id: $(this).data("id"),
                        link: $(this).data("link")
                    },
                    dataType: "json"
                }).done(function(t) {
                    if ("object" == typeof window.toastr ? null != t.code && 200 == t.code ? window.toastr.success(t.message) : null != t.code && 100 == t.code && window.toastr.error(t.message) : null != t.message && alert(t.message), null != t.code && 200 == t.code) {
                        var a = 100 * t.rating.average / 5;
                        var box =_this.parents('.rating-box');
                        var span = $(box).find("span");
                        var textscore = $(box).next();
                        span.width(a + "%"), span.attr("data-width", a + "%");
                        if(textscore.length>0) textscore.text("(" + t.rating.average + "/5)");
                    }
                })
            }),
            function() {
                
                $(".item-rating .rating-box").mousemove(function(a) {
                    var t = $(this).width();
                    var i = 100 * (a.pageX - $(this).offset().left) / t;
                    $(this).find("span").width(i + "%")
                }), $(".item-rating .rating-box").mouseout(function(t) {
                    var span = $(this).find('span');
                    span.width(span.attr("data-width"))
                })
            }()
    }
};
$(function() {
    RATING._()
});