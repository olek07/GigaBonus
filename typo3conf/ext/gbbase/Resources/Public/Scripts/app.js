$(document).foundation()


var Layout = {

    init : function () {
        $(document).on(this.EVENT_START_LOADING, this.loadingStart);
        $(document).on(this.EVENT_STOP_LOADING, this.loadingStop);
    },

    scrollToOffset : function (offset, hash) {
        var duration_per_pixel = .5;
        var distance = Math.abs($(window).scrollTop() - offset);

        $('html,body').animate({
            scrollTop: offset
        }, distance * duration_per_pixel, function () {
            if (hash) {
                var tmp = $(window).scrollTop();
                document.location.hash = hash;
                $(window).scrollTop(tmp);
            }
        });
    },

    loadingStart : function (evt, message) {

    }

};

Layout.EVENT_INIT_FORMS = 'init_forms';
Layout.EVENT_START_LOADING = 'start_loading';
Layout.EVENT_STOP_LOADING = 'stop_loading';
Layout.EVENT_ERROR_LOADING = 'error_loading';

Layout.init();