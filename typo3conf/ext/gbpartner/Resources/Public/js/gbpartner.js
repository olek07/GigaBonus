Gbpartner = {
    init: function () {
        var obj = this;
    },

    gotoPartner: function(t, partnerId, userId) {
        $.getJSON  ('/index.php?type=118&tx_gbpartner_partnerlisting[partner]=' + partnerId + '&userId=' + userId + '&t=' + t + '&r' + Math.random())
            .done(function (resp) {
                if (typeof resp.token !== 'undefined') {
                    location.href = url + '&sId=' + resp.sessionId + '&token=' + resp.token;
                }
            });
    }
}

