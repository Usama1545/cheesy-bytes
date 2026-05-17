$('.currency_code').on('keyup',function(){
    "use strict";
    this.value = this.value.replace(/[^a-zA-Z]/g, "");
});