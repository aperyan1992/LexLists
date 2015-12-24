function isHover(id) {
    return ($('#' + id + ':hover').length > 0);
}

$(document).ready(function() {
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
