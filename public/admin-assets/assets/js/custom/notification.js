$(function(){
    "use strict";
    $(".type").on('change',function(){
        "use strict";
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");
            if(optionValue){
                $(".gravity").not("." + optionValue).addClass('dn');
                $("." + optionValue).removeClass('dn');
            } else{
                $(".gravity").addClass('dn');
            }
        });
    }).change();
});