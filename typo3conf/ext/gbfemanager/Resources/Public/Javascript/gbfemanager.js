Gbfemanager = {

   init: function(){

        var obj = this;
        
        obj.initCitySuggest();
        
        var birthDay = $('#femanager_field_dateOfBirth').val();
        var res = birthDay.split('.');
        
        $("select[data-birthday-day]").val(res[0]);
        $("select[data-birthday-month]").val(res[1]);
        $("select[data-birthday-year]").val(res[2]);
        
        $('.birthday input,select').change(function(){
            $('#femanager_field_dateOfBirth').val(
                   $("select[data-birthday-day]").val() + '.'
                 + $("select[data-birthday-month]").val() + '.'
                 + $("select[data-birthday-year]").val()
            )
        });

    },
    
    initCitySuggest: function() {
        var cityFound = true;
        var term1 = $('#femanager_field_city').val();
        var cityName = $('#femanager_field_city').val();

        $('#femanager_field_city').autocomplete({
            source      : '/index.php?eID=cities&lang=ru',
            minLength   : 3,
            delay       : 500,
            html        : true,
            select: function(event, ui) {
                    var url = ui.item.id;
                    $('#femanager_field_city_id').val(url);
                    cityFound = true;
                    cityName = ui.item.value;
            },
            // wurde etwas gefunden?    
            response: function( event, ui ) {
                if (ui.content.length == 0) cityFound = false;
            },
        });

        $('#femanager_field_city').keydown(function(){
            if (cityName !== $('#femanager_field_city').val().trim()) $('#femanager_field_city_id').val(0);
        })
        
        $('#changeUserdataForm').submit(function(event) {
              if (!cityFound) return false;
              if ($('#femanager_field_city_id').val() === 0) return false;
        });
    }
    


}


jQuery(document).ready(function(){
    Gbfemanager.init();
});