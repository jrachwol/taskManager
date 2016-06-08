$(document).ready(function () {
    loadGridMason();
    increment();
    changeTheme()
})


function loadGridMason() {

    $('.flipper:even').removeClass("large");
    $('.flipper:eq(4)').removeClass("large").addClass("tall");

    $("#grid").mason({
        itemSelector: '.flipper',
        ratio: 1.1,
        sizes: [
            [1, 1],
            [2, 1]
        ],
        promoted: [
            ['tall', 1, 1],
            ['large', 2, 1]
        ],
        columns: [
            [0, 479, 2],
            [480, 767, 3],
            [768, 991, 4],
            [992, 1920, 6]
        ],
        filler: {
            itemSelector: '.filler',
            filler_class: 'mason-filler',
        },
        gutter: 3,
        layout: 'fluid'
    });

    $(".wrapper-flip").css("visibility", "visible");

}

// Statistic

function increment() {
    $('.box').hide();
    setTimeout(function() {
        $('.box').show();
    }, 100);

    $('.number').each(function() {
        var $this = $(this),
            value = $this.text();
        $({
            someValue: 0
        }).animate({
            someValue: value
        }, {
            duration: 1200,
            easing: 'swing',
            step: function() {
                $this.text(Math.round(this.someValue));
            },
            complete: function() {
                $this.text(value);
            }
        });
    });
}


// Theme

function changeTheme() {

    var body = $("body"),
        nav = $("nav"),
        li = $("li.active"),
        val = $("#theme_theme").val();
    
    if(val == "dark-grey") {
        body.removeClass().addClass("dark-grey");
        nav.removeClass("dark-blue grey-orange").addClass("dark-grey");
        li.removeClass("dark-blue grey-orange").addClass("dark-grey");
    }
    if(val == "dark-blue") {
        body.removeClass().addClass("dark-blue");
        nav.removeClass("dark-grey grey-orange").addClass("dark-blue");
        li.removeClass("dark-grey grey-orange").addClass("dark-blue");
    }
    if(val == "grey-orange") {
        body.removeClass().addClass("grey-orange");
        nav.removeClass("dark-grey dark-blue").addClass("grey-orange");
        li.removeClass("dark-grey dark-blue").addClass("grey-orange");
    }

}

