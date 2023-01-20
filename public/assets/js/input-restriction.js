$('.input').on('keypress', function (event) {
    var regex = new RegExp("^[a-zA-Z ,.'-]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (event.which === 32 && !this.value.length){
        event.preventDefault();
        return false;
    }
    if (!regex.test(key)) {
        event.preventDefault();
        return false;
    }
});

$('.input-number').on('keypress', function (event) {
    var regex = new RegExp("^[0-9-]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    
    if (event.which === 32 && !this.value.length){
        event.preventDefault();
        return false;
    }
    if (!regex.test(key)) {
        event.preventDefault();
        return false;
    }
});

$('.input-address').on('keypress', function (event) {
    var regex = new RegExp("^[a-zA-Z0-9 ,.#/'-]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    
    if (event.which === 32 && !this.value.length){
        event.preventDefault();
        return false;
    }
    if (!regex.test(key)) {
        event.preventDefault();
        return false;
    }
});
