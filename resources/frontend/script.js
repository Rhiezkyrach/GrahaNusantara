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

//Dark Mode
var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

// Change the icons inside the button based on previous settings
if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    themeToggleLightIcon.classList.remove('hidden');
} else {
    themeToggleDarkIcon.classList.remove('hidden');
}

var themeToggleBtn = document.getElementById('theme-toggle');

themeToggleBtn.addEventListener('click', function() {

    // toggle icons inside button
    themeToggleDarkIcon.classList.toggle('hidden');
    themeToggleLightIcon.classList.toggle('hidden');

    // if set via local storage previously
    if (localStorage.getItem('color-theme')) {
        if (localStorage.getItem('color-theme') === 'light') {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
        }

    // if NOT set via local storage previously
    } else {
        if (document.documentElement.classList.contains('dark')) {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
        } else {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
        }
    }
    
});

//Dark Mode Mobile
var themeToggleDarkIconMobile = document.getElementById('theme-toggle-dark-icon-mobile');
var themeToggleLightIconMobile = document.getElementById('theme-toggle-light-icon-mobile');

// Change the icons inside the button based on previous settings
if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    themeToggleLightIconMobile.classList.remove('hidden');
} else {
    themeToggleDarkIconMobile.classList.remove('hidden');
}

var themeToggleBtnMobile = document.getElementById('theme-toggle-mobile');

themeToggleBtnMobile.addEventListener('click', function() {

    // toggle icons inside button
    themeToggleDarkIconMobile.classList.toggle('hidden');
    themeToggleLightIconMobile.classList.toggle('hidden');

    // if set via local storage previously
    if (localStorage.getItem('color-theme')) {
        if (localStorage.getItem('color-theme') === 'light') {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
        }

    // if NOT set via local storage previously
    } else {
        if (document.documentElement.classList.contains('dark')) {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
        } else {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
        }
    }
    
});
