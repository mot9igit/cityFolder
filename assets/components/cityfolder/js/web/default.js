$(document).ready(function () {
    $('.cf-city-input').keyup(function() {
        if ($(this).val() != '') {
            $('.cf-city-item').hide();
            s = $(this).val();
            s = s.charAt(0).toUpperCase() + s.substr(1);
            $('li:contains("'+s+'")').show();
        } else {
            //$('.sd-city-item').show();
        }
    });
});