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
        // var modal = $('<div>').addClass('modal-container');
        var modal = $('<div>').addClass('reveal-overlay').css('display', 'block');
        $('body').prepend(modal);

        // $('body').addClass('is-reveal-open');
        $('body').addClass('modal-open');
        // $('html').addClass('modal-open-html');



        // $('html').css('overflow-y', 'hidden');
        // $('body').css('overflow-y', 'scroll');
    },
    
    loadingStop : function (evt, message) {
        // $('html').removeProp("overflow-y");
        // $('body').removeProp("overflow-y");

        $('.reveal-overlay').remove();

        // $('body').removeClass('is-reveal-open');

        // $('html').removeClass('modal-open-html');
        $('body').removeClass('modal-open');

        // $('.modal-container').remove();
    }

};

Layout.EVENT_INIT_FORMS = 'init_forms';
Layout.EVENT_START_LOADING = 'start_loading';
Layout.EVENT_STOP_LOADING = 'stop_loading';
Layout.EVENT_ERROR_LOADING = 'error_loading';

Layout.init();