// === Button to Top
var btn = $("#button");

$(window).scroll(function () {
    if ($(window).scrollTop() > 300) {
        btn.addClass("show");
    } else {
        btn.removeClass("show");
    }
});

btn.on("click", function (e) {
    e.preventDefault();
    $("html, body").animate({ scrollTop: 0 }, "300");
});


$(".gallery").each(function () {
    // the containers for all your galleries
    $(this).magnificPopup({
        delegate: "a", // the selector for gallery item
        type: "image",
        gallery: {
            enabled: true,
        },
    });
});

