Gbfemanager = {

    sendDataToValidate : null,

    init: function(lang, pageUid){

        var obj = this;
        var form = $('#changeUserdataForm');
        var submitFormAllowed = false;

        
        this.lang = lang;
        this.pageUid = pageUid;

        switch (pageUid) {
            case 6:
                this.initChangeUserData();
                break;
            default:
        }

        form.submit(function(e){

            $('#femanager_field_submit').attr('disabled', 1);
            if (!obj.submitFormAllowed) {

                obj.setFieldsToValidate();
                if (obj.sendDataToValidate == null) return;

                $.getJSON({
                    url: '/index.php?eID=gbfemanagerValidate&L=' + obj.lang,
                    data: {'tx_gbfemanager_pi2[data]' : JSON.stringify(obj.sendDataToValidate)},
                    type: 'POST',
                    cache: false,
                    success: function(data) { // return values
                        if (data) {
                            try {
                                    var json = data;
                                    if (!json.validate) {
                                        // writeErrorMessage(element, json.message)
                                        $('#error-messages').html('');
                                        for(message in json.messages) {
                                            for (key in json.messages[message]) {
                                                if (json.messages[message].hasOwnProperty(key)) {
                                                    // console.log(key + " = " + json.messages[message][key]);
                                                    $('#' + key).addClass('error');
                                                    $('#error-messages').append('<div>' + json.messages[message][key] + '</div>');
                                                }
                                            }
                                        }
                                        obj.enableSubmitButton();
                                    } else {
                                        obj.submitFormAllowed = true;
                                        form.submit();        
                                        // cleanErrorMessage(element);
                                    }
                            } 
                            catch(e) {
                            }

                        }

                    },
                    error: function() {
                            // logAjaxError();
                            obj.enableSubmitButton();
                    }
                });

                return false;
            }
        });

    },
    
    disableSubmitButton: function() {
        $('#femanager_field_submit').prop('disabled',  true);
    },
    
    enableSubmitButton: function() {
        $('#femanager_field_submit').prop('disabled', false);
    },
    
    initCitySuggest: function() {
        var cityFound = true;
        var cityName = $('#femanager_field_city').val();

        $('#femanager_field_city').autocomplete({
            source      : '/index.php?eID=cities&L=' + this.lang,
            minLength   : 3,
            delay       : 500,
            html        : true,
            select: function(event, ui) {
                    var url = ui.item.uid;
                    $('#femanager_field_city_id').val(url);
                    cityFound = true;
                    cityName = ui.item.value;
            },
            // wurde etwas gefunden?    
            response: function( event, ui ) {
                if (ui.content.length == 0) cityFound = false;
            }
        });

        $('#femanager_field_city').keydown(function(){
            if (cityName !== $('#femanager_field_city').val().trim()) $('#femanager_field_city_id').val(0);
        })
        
        /*
        $('#changeUserdataForm').submit(function(event) {
              if (!cityFound) return false;
              if ($('#femanager_field_city_id').val() == 0) return false;
        });
        */
    },

    setFieldsToValidate : function() {

        switch (this.pageUid) {
            case 6:     // change userdata
                this.sendDataToValidate = {
                    'firstName' : $('#femanager_field_firstName').val(),
                    'middleName' : $('#femanager_field_middleName').val(),
                    'lastName' : $('#femanager_field_lastName').val(),
                    'gender' : $('#femanager_field_gender1').prop('checked') + $('#femanager_field_gender0').prop('checked'),
                    'cityId' : $('#femanager_field_city_id').val(),
                    // 'zip' : $('#femanager_field_zip').val(),
                    'dateOfBirth' : $('#femanager_field_dateOfBirth').val()
                };
                break;

            case 8:     // change password
                this.sendDataToValidate = {
                    'password' : $('#femanager_field_password').val(),
                    'password_repeat' : $('#femanager_field_password_repeat').val()
                };

        }

    },


    initChangeUserData : function() {

        var res = [];
        var birthDay = $('#femanager_field_dateOfBirth').val();

        this.initCitySuggest();

        if (birthDay == 0) {
            res[0] = 0;
            res[1] = 0;
            res[2] = 0;
        }
        else {
            res = birthDay.split('.');
        }

        $("select[data-birthday-day]").val(res[0]);
        $("select[data-birthday-month]").val(res[1]);
        $("select[data-birthday-year]").val(res[2]);

        $('.birthday input,select').change(function () {
            $('#femanager_field_dateOfBirth').val(
                $("select[data-birthday-day]").val() + '.'
                + $("select[data-birthday-month]").val() + '.'
                + $("select[data-birthday-year]").val()
            );
        });
    }


};


