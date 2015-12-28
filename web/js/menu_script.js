function isHover(id) {
    return ($('#' + id + ':hover').length > 0);
}

$(document).ready(function() {
    $("#lt_survey_filters_year")
        .replaceWith('<select id="lt_survey_filters_year" name="lt_survey_filters[year][text]" style="width:90px !important">' +
        '<option value=""></option>' +
        '<option value="2015">2015</option>' +
        '<option value="2014">2014</option>' +
        '<option value="2013">2013</option>' +
        '<option value="2012">2012</option>' +
        '<option value="2011">2011</option>' +
        '<option value="2010">2010</option>' +
        '<option value="2009">2009</option>' +
        '</select>');

    $('#navigation li').hover(function() {
        $('#navigation').addClass('open');
        $(this).children('ul').first().slideDown();
    },
            function() {
                if (!isHover('submenu')) {
                    $('#navigation').delay('50').removeClass('open');
                }
            });

    setInterval(function() {
        if (!$('#navigation').hasClass('open')) {
            $('#navigation li ul').delay('50').fadeOut();
        }
    }, 500);
    
    $(document).click(function() {
        if (!isHover('submenu')) {
            $('#navigation').removeClass('open');
            $('#navigation li ul').fadeOut();
        }        
    });
    $('.sf_admin_td_actions li a').empty();
});
