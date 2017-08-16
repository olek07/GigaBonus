Gbpartner = {
    init: function () {
        var obj = this;
    },

    gotoPartner: function(t, partnerId) {
        $.getJSON  ('/index.php?type=118&tx_gbpartner_partnerlisting[partner]=' + partnerId + '&t=' + t + '&r' + Math.random())
            .done(function (resp) {
                if (typeof resp.token !== 'undefined') {
                    location.href = url + '&sId=' + resp.sessionId + '&token=' + resp.token;
                }
                else {
                    location.href = '/';
                }
            });
    },

    reloadOpener: function() {
        try {
            window.opener.location.reload(true);
        }
        catch(e) {
        }
    }
}

