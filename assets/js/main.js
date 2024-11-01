var top_btn = jQuery('.top_but');

top_btn.click(function () {
    jQuery('html, body').animate({
        scrollTop: 0,
    }, 700);
});

var scrollDisatance = parseInt(vs_top_but.scroll_distance);

jQuery(window).scroll(function () {
    var currentValueScroll = jQuery(window).scrollTop();

    if (currentValueScroll >= scrollDisatance)
        top_btn.fadeIn(500);
    else top_btn.fadeOut(500);

});
