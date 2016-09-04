Gbfemanager = {

   init: function(){

        var obj = this;
        
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
    


}


jQuery(document).ready(function(){
    Gbfemanager.init();
});