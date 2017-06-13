Gbpartner = {
    init: function () {

        var obj = this;
    },

    setToken: function() {
        $.ajax('/index.php?eID=getToken')
            .done(function (resp) {
                alert(resp)
            });
    }

}

