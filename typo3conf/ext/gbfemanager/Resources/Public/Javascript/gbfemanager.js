GbfemanagerEdit = {

    lang : 0,
    form : null,

    init: function(){

        var obj = this;

        obj.form = $('#changeUserdataForm');

        obj.initLanguage();
        obj.initBirthday();
        obj.initCitySuggest();
        obj.initForm();
        obj.scrollToMessage();

    },

    initLanguage : function(){
        var obj = this;
        var lang = $(obj.form).data('languageid');
        if (typeof lang !== 'undefined') {
            obj.lang = lang
        }
    },

    initCitySuggest: function() {
        var cityField = $('#femanager_field_city');
        if (cityField.length == 0) return;

        var obj = this;
        var cityFound = true;
        var cityName = cityField.val();

        cityField.autocomplete({
            source      : '/index.php?eID=cities&L=' + obj.lang,
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

        cityField.keydown(function(){
            if (cityName !== cityField.val().trim()) $('#femanager_field_city_id').val(0);
        })

    },


    initBirthday : function() {

        var birthdayField = $('#femanager_field_dateOfBirth');
        if (birthdayField.length == 0) return;
        
        var res = [];
        var birthday = birthdayField.val();


        if (birthday == 0) {
            res[0] = 0;
            res[1] = 0;
            res[2] = 0;
        }
        else {
            res = birthday.split('.');
        }

        $("select[data-birthday-day]").val(res[0]);
        $("select[data-birthday-month]").val(res[1]);
        $("select[data-birthday-year]").val(res[2]);

        $('.birthday input,select').change(function () {
            birthdayField.val(
                $("select[data-birthday-day]").val() + '.'
                + $("select[data-birthday-month]").val() + '.'
                + $("select[data-birthday-year]").val()
            );
        });
    },

    initForm: function() {
        var obj = this;

        var options = {
            // target:        '.tx-femanager',      // target element(s) to be updated with server response
            beforeSubmit:  obj.prepareFormRequest,  // pre-submit callback
            success:       obj.showFormResponse,    // post-submit callback
            error: function(data) {
                // alert(123);
                $(document).trigger(Layout.EVENT_STOP_LOADING);
            },

            // other available options:
            //url:       url         // override for form's 'action' attribute
            //type:      type        // 'get' or 'post', override for form's 'method' attribute
            dataType:  'html'        // 'xml', 'script', or 'json' (expected server response type)
            //clearForm: true        // clear all form fields after successful submit
            //resetForm: true        // reset the form after successful submit

            // $.ajax options can be used here too, for example:
            //timeout:   3000
        };

        // bind form using 'ajaxForm'
        $('#changeUserdataForm').ajaxForm(options);
    },

    showFormResponse : function(responseText, statusText, xhr, $form) {
        $('.tx-femanager').replaceWith(responseText);
        $(document).trigger(Layout.EVENT_STOP_LOADING);
        $(document).trigger(Layout.EVENT_INIT_FORMS);

    },

    prepareFormRequest: function(){

        $(document).trigger(Layout.EVENT_START_LOADING);

    },

    scrollToMessage: function(){
        var obj = this;
        var elMessage = $('.tx-femanager');
        var elMessage = $('body');
        if (elMessage.length > 0){
            Layout.scrollToOffset($(elMessage[0]).offset().top - 50);
        }
    }

};



GbfemanagerNew = {

    form : null,

    init: function(){

        var obj = this;

        obj.form = $('#newUserForm');

        obj.initForm();
        obj.scrollToMessage();

    },


    initForm: function() {
        var obj = this;

        var options = {
            // target:        '.tx-femanager',      // target element(s) to be updated with server response
            beforeSubmit:  obj.prepareFormRequest,  // pre-submit callback
            success:       obj.showFormResponse,    // post-submit callback

            // other available options:
            //url:       url         // override for form's 'action' attribute
            //type:      type        // 'get' or 'post', override for form's 'method' attribute
            dataType:  'html'        // 'xml', 'script', or 'json' (expected server response type)
            //clearForm: true        // clear all form fields after successful submit
            //resetForm: true        // reset the form after successful submit

            // $.ajax options can be used here too, for example:
            //timeout:   3000
        };

        // bind form using 'ajaxForm'
        $(obj.form).ajaxForm(options);
    },

    showFormResponse : function(responseText, statusText, xhr, $form) {
        $('.tx-femanager').replaceWith(responseText);
        $(document).trigger(Layout.EVENT_STOP_LOADING);
        $(document).trigger(Layout.EVENT_INIT_FORMS);

    },

    prepareFormRequest: function(){
        $(document).trigger(Layout.EVENT_START_LOADING);
    },

    scrollToMessage: function(){
        var obj = this;
        var elMessage = $('.tx-femanager');
        var elMessage = $('body');
        if (elMessage.length > 0){
            Layout.scrollToOffset($(elMessage[0]).offset().top - 50);
        }
    }
};

GbfemanagerRestorePassword = {

    form : null,

    init: function(){

        var obj = this;

        obj.form = $('#restorePasswordForm');

        obj.initForm();
        obj.scrollToMessage();

    },


    initForm: function() {
        var obj = this;

        var options = {
            // target:        '.tx-femanager',      // target element(s) to be updated with server response
            beforeSubmit:  obj.prepareFormRequest,  // pre-submit callback
            success:       obj.showFormResponse,    // post-submit callback

            // other available options:
            //url:       url         // override for form's 'action' attribute
            //type:      type        // 'get' or 'post', override for form's 'method' attribute
            dataType:  'html'        // 'xml', 'script', or 'json' (expected server response type)
            //clearForm: true        // clear all form fields after successful submit
            //resetForm: true        // reset the form after successful submit

            // $.ajax options can be used here too, for example:
            //timeout:   3000
        };

        // bind form using 'ajaxForm'
        $(obj.form).ajaxForm(options);
    },

    showFormResponse : function(responseText, statusText, xhr, $form) {
        $('.tx-femanager').replaceWith(responseText);
        $(document).trigger(Layout.EVENT_STOP_LOADING);
        $(document).trigger(Layout.EVENT_INIT_FORMS);

    },

    prepareFormRequest: function(){
        $(document).trigger(Layout.EVENT_START_LOADING);
    },

    scrollToMessage: function(){
        var obj = this;
        var elMessage = $('.tx-femanager');
        var elMessage = $('body');
        if (elMessage.length > 0){
            Layout.scrollToOffset($(elMessage[0]).offset().top - 50);
        }
    }
};


GbfemanagerModalRegistrationForm = {

    form : null,


    init: function(){

        var obj = this;

        obj.form = $('#modalRegistrationForm');


        $('[data-signin-button]').click(function(){

            var $modal = $('#modalWindow');

            $.ajax('/?L=1&type=104&tx_femanager_pi1[action]=newAjax&tx_femanager_pi1[controller]=New')
                .done(function(resp){
                    $modal.html(resp).foundation('open');
                    obj.initForm();
                });
        });

        $(document).on(Layout.EVENT_INIT_FORMS, function() {
            obj.initForm();
        });

    },

    initForm: function() {
        var obj = this;

        var options = {
            success:       obj.showFormResponse,    // post-submit callback
            error: function(data) {
                $(document).trigger(Layout.EVENT_STOP_LOADING);
            },

            dataType:  'html'        // 'xml', 'script', or 'json' (expected server response type)
        };

        $('#modalRegistrationForm').ajaxForm(options);
    },

    showFormResponse : function(responseText, statusText, xhr, form) {
        $('#modalRegistrationForm').replaceWith(responseText);
        $(document).trigger(Layout.EVENT_INIT_FORMS);
    }

}