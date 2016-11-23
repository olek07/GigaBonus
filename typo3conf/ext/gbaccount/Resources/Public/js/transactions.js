Gbtransactions = {

    lastAjaxURL : null,
    
    init: function(){

        var obj = this;
        obj.initDates();
        obj.setUpPaginateLinks()

    },

    initDates : function() {
        $('#startdate').datepicker({dateFormat: 'dd.mm.yy' });
        $('#enddate').datepicker({dateFormat: 'dd.mm.yy' });
    },

    // Refresh Pager
    handlePager : function (data) {
        this.replaceSearchResultContent(data, false);
    },

    replaceSearchResultContent : function (data, all) {
        $('#transaction-list').replaceWith(data);
        this.init();
    },


    setUpPaginateLinks : function() {
        var obj = this;

        $('ul.pagination a').on('click', function (e) {
            obj.ajax({
                'url': $(this).attr('href'),
                'type': 114,
                'callback': $.proxy(obj.handlePager, obj)
            });
            e.preventDefault();
        });

    },

    ajax : function (data) {
        var params = $.extend({
            'url': '',
            'type': 0,
            'callback': null,
            'updateLocation': true,
            'scroll': true
        }, data);

        $(document).trigger(Layout.EVENT_START_LOADING);
        
        this.lastAjaxURL = params.url;
        $.ajax({
            url: params.url,
            data: {type: params.type},
            dataType: 'html',
            success: function (data) {

                if (params.updateLocation && history && history.pushState) history.pushState(JSON.stringify(params), '', params.url);

                $(document).trigger(Layout.EVENT_STOP_LOADING);

                if (params.callback) params.callback(data);
                if (params.scroll) {
                    var $scrollTarget = $('body');
                    if ($(window).scrollTop() > $scrollTarget.offset().top) Layout.scrollToElement($scrollTarget);
                }
            },
            error: function (data) {
                // $(Layout.get()).trigger(Layout.EVENT_ERROR_LOADING, data);
            }
        });
    }

}

