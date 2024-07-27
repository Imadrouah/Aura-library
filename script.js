$(".year").html(new Date().getFullYear());

$("#btn").click(() => {
    $(".sidebar").toggleClass("open");
});
$(document).scroll(function () {
    if ($(".sidebar").hasClass("open")) $(".sidebar").removeClass("open");
});
$("#book").addClass("reveal");
function scrollAnime() {
    if ($("#book .books > div").hasClass("card")) {
        let pos =
            document.getElementById("book").offsetTop +
            document.querySelector(".books .card").offsetHeight -
            150;
        let bottomPos = window.scrollY + window.innerHeight;
        if (bottomPos > pos) {
            $("#book").addClass("revealed");
        } else {
            if ($("#book").hasClass("revealed")) {
                $("#book").removeClass("revealed");
            }
        }
    }
}
$(document).on("scroll", function () {
    scrollAnime();
    if (window.scrollY > window.innerHeight / 2.1)
        $(".scrollTop").css("opacity", 1);
    else $(".scrollTop").css("opacity", 0);
});
$(".scrollTop").click(function () {
    window.scrollTo(0, 0);
});
