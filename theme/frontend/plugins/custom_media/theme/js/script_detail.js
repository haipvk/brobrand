var globalUrlCustomMedia = null;
var URL_CUSTOM_MEDIA = (function(){
    
    var getCustomMediaQueryVariable = function(url,variable) {
        var base = $("base").attr("href")+"Techsystem/Media/media?";
        var query = url.replace(base,"");
        var vars = query.split("&");
        for (var i = 0; i < vars.length; i++) {
            var pair = vars[i].split("=");
            if (decodeURIComponent(pair[0]) == variable) {
                return decodeURIComponent(pair[1]);
            }
        }
        return "";
    }
    var showIframeMedia = function(e){
        $(document).on("click",".btn.iframe-btn",function(e){
            if($(this).text()=="Browse File ..."){
                URL_CUSTOM_MEDIA.setUrlIframe($(this));
            }
        })
        $(document).on("click",".btn.iframe-btn",function(e){
            if($(this).text()=="Browse File ..."){
                URL_CUSTOM_MEDIA.setUrlIframe($(this));
            }
        })
    }
    var setUrlIframe = function(_this){
        if(globalUrlCustomMedia!=null){
            var istiny = getCustomMediaQueryVariable(globalUrlCustomMedia,"istiny");
            var newistiny = getCustomMediaQueryVariable(_this.attr("href"),"istiny");
            var newUrl = globalUrlCustomMedia.replace("istiny="+istiny,"istiny="+newistiny);
            setTimeout(function(){
                $(".fancybox-iframe").attr("src",newUrl);
            },100)
        }
        setTimeout(function(){
            $(".fancybox-iframe").load(function(){
                var nurl = this.contentWindow.location.href;
                if(nurl.indexOf("trash")==-1){
                    globalUrlCustomMedia = nurl;    
                }
                
            })
        },1000)
    }
    return{
        _:function(){
            showIframeMedia();
        },
        setUrlIframe:function(_this){
            setUrlIframe(_this);
        }
    }
})();
URL_CUSTOM_MEDIA._();