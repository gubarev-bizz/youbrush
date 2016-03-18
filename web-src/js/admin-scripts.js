(function($) {

    $(document).ready(function() {
        $('.content-wrapper').css({
            "min-height" : $(window).height() - $('.main-header').height() + "px"
        });
        $(window).resize(function() {
            $('.content-wrapper').css({
                "min-height" : $(window).height() - $('.main-header').height() + "px"
            });
        });
    });

})(jQuery);