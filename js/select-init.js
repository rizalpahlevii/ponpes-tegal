$(document).ready(function() {
    $(".e1p").select2();
    $("#e1").select2();
    $("#e4").select2();
    $("#e5").select2();
    $("#e6").select2();
    $("#e7").select2();
    $("#e8").select2();
    $("#e9").select2();
    $("#e2").select2({
        placeholder: "Select a State",
        allowClear: true
    });
    $("#e3").select2({
        minimumInputLength: 2
    });
    
});

