$("html").on("click", ".rpl-btn", function(event) {
    var btn = $(event.currentTarget);
    var x = event.pageX - btn.offset().left;
    var y = event.pageY - btn.offset().top;
    
    $("<span class='rpl-span' />").appendTo(btn).css({left: x, top: y});
    setTimeout(function () {
        $(btn).find('.rpl-span').remove();
    }, 1000);
});
