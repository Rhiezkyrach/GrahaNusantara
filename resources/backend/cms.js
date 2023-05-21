let justify = document.querySelector("#justify");
let hamburger = document.querySelector("#hamburger");
let navlinks = document.querySelector("#navlinks");

let line = hamburger.querySelector("#line");
let line2 = hamburger.querySelector("#line2");
let line3 = hamburger.querySelector("#line3");

hamburger.addEventListener("click", function () {
    if (navlinks.classList.contains("hidden")) {
        navlinks.classList.remove("hidden");
        justify.classList.add("justify-between");
        line2.classList.add("hidden");
        line.classList.add("rotate-45", "absolute");
        line3.classList.add("-rotate-45", "absolute");
        line3.classList.remove("mt-1.5");
    } else {
        navlinks.classList.add("hidden");
        line2.classList.remove("hidden");
        line.classList.remove("rotate-45", "absolute");
        line3.classList.remove("-rotate-45", "absolute");
        line3.classList.add("mt-1.5");
    }
});
